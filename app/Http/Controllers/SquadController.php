<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Http\Requests\CreateSquadForm;
use App\Http\Requests\DeleteSquadForm;
use App\Http\Requests\UpdateSquadForm;
use App\Models\Member;
use App\Models\Platoon;
use App\Models\Squad;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SquadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Division $division
     * @param Platoon $platoon
     * @return Response
     */
    public function show(Division $division, Platoon $platoon, Squad $squad)
    {
        $members = $squad->members()->with([
            'handles' => $this->filterHandlesToPrimaryHandle($division),
            'rank',
            'position',
            'leave'
        ])->get()->sortByDesc('rank_id');

        $members = $members->each($this->getMemberHandle());

        $forumActivityGraph = $this->getSquadForumActivity($squad);
        $tsActivityGraph = $this->getSquadTSActivity($squad);

        return view(
            'squad.show',
            compact('squad', 'platoon', 'members', 'division', 'forumActivityGraph', 'tsActivityGraph')
        );
    }

    /**
     * @param $division
     * @return Closure
     */
    private function filterHandlesToPrimaryHandle($division)
    {
        return function ($query) use ($division) {
            $query->where('id', $division->handle_id);
        };
    }

    /**
     * @return Closure
     */
    private function getMemberHandle()
    {
        return function ($member) {
            $member->handle = $member->handles->first();
        };
    }

    public function getSquadForumActivity(Squad $squad)
    {
        $twoWeeksAgo = Carbon::now()->subDays(14);
        $oneMonthAgo = Carbon::now()->subDays(30);

        $twoWeeks = $squad->members()->where('last_activity', '>=', $twoWeeksAgo)->count();

        $oneMonth = $squad->members()->where('last_activity', '<=', $twoWeeksAgo)
            ->where('last_activity', '>=', $oneMonthAgo)->count();

        $moreThanOneMonth = $squad->members()->where('last_activity', '<=', $oneMonthAgo)->count();

        return [
            'labels' => ['Current', '14 days', '30 days'],
            'values' => [$twoWeeks, $oneMonth, $moreThanOneMonth],
            'colors' => ['#28b62c', '#ff851b', '#ff4136']
        ];
    }

    public function getSquadTSActivity(Squad $squad)
    {
        $twoWeeksAgo = Carbon::now()->subDays(14);
        $oneMonthAgo = Carbon::now()->subDays(30);

        $twoWeeks = $squad->members()->where('last_ts_activity', '>=', $twoWeeksAgo)->count();

        $oneMonth = $squad->members()->where('last_ts_activity', '<=', $twoWeeksAgo)
            ->where('last_ts_activity', '>=', $oneMonthAgo)->count();

        $moreThanOneMonth = $squad->members()->where('last_ts_activity', '<=', $oneMonthAgo)->count();

        return [
            'labels' => ['Current', '14 days', '30 days'],
            'values' => [$twoWeeks, $oneMonth, $moreThanOneMonth],
            'colors' => ['#28b62c', '#ff851b', '#ff4136']
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Division $division
     * @param Platoon $platoon
     * @return Response
     */
    public function create(Division $division, Platoon $platoon)
    {
        $this->authorize('create', [Squad::class, $division]);

        return view('squad.create', compact('division', 'platoon'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateSquadForm $form
     * @param Division $division
     * @param Platoon $platoon
     * @return RedirectResponse
     */
    public function store(CreateSquadForm $form, Division $division, Platoon $platoon)
    {
        if ($form->leader_id && !$this->isMemberOfDivision($division, $form)) {
            return redirect()->back()
                ->withErrors(['leader_id' => "Member {$form->leader_id} not assigned to this division!"])
                ->withInput();
        }

        $form->persist();

        $this->showToast(ucwords($division->locality('squad')) . " has been created!");

        return redirect()->route('platoon', [$division->abbreviation, $platoon]);
    }

    /**
     * @param $request
     * @param Division $division
     * @return bool
     */
    public function isMemberOfDivision(Division $division, $request)
    {
        $member = Member::whereClanId($request->leader_id)->first();

        return $member->division instanceof Division &&
            $member->division->id === $division->id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Division $division
     * @param Platoon $platoon
     * @param Squad $squad
     * @return Response
     */
    public function edit(Division $division, Platoon $platoon, Squad $squad)
    {
        $this->authorize('update', $squad);

        return view('squad.edit', compact('squad', 'platoon', 'division'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSquadForm $form
     * @param Division $division
     * @param Platoon $platoon
     * @param Squad $squad
     * @return RedirectResponse
     */
    public function update(UpdateSquadForm $form, Division $division, Platoon $platoon, Squad $squad)
    {
        if ($form->leader_id && !$this->isMemberOfDivision($division, $form)) {
            return redirect()->back()
                ->withErrors(['leader_id' => "Member {$form->leader_id} not assigned to this division!"])
                ->withInput();
        }

        $form->persist();

        $this->showToast('Squad has been updated');

        return redirect()->route('squad.show', [$division->abbreviation, $platoon, $squad]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteSquadForm $form
     * @param Division $division
     * @param Platoon $platoon
     * @return Response
     */
    public function destroy(DeleteSquadForm $form, Division $division, Platoon $platoon)
    {
        $form->persist();

        $this->showToast('Squad has been deleted');

        return redirect()->route('platoon', [$division->abbreviation, $platoon]);
    }

    /**
     * Assign a member to a squad
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function assignMember(Request $request)
    {
        $member = Member::find($request->member_id);

        // if squad id is zero, user wants to unassign member
        if ($request->squad_id == 0) {
            $member->platoon()->dissociate();
            $member->squad()->dissociate();
        } else {
            // ensure they are assigned to current platoon
            $squad = Squad::find($request->squad_id);
            $member->platoon()->associate($squad->platoon);
            $member->squad()->associate($squad);
        }

        $member->save();

        return response()->json([
            'success' => true
        ]);
    }
}
