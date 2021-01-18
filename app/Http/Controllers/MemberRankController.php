<?php

namespace App\Http\Controllers;

use App\AOD\Traits\Procedureable;
use App\Http\Requests\ChangeMemberRank;
use App\Models\Member;
use App\Models\MemberHistory;
use App\Models\Rank;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\QueryException;

class MemberRankController extends Controller
{
    use Procedureable;

    public function update(ChangeMemberRank $form, Member $member)
    {
        $newRank = Rank::findOrFail(request()->rank);

        $newRank->history()->create([
            'member_id' => $member->id,
            'admin_id' => auth()->user()->member_id
        ]);

        if (!request('historical')) {

            try {
                $this->callProcedure('set_user_rank', [$member->clan_id, $newRank->name]);
            } catch (QueryException $e) {
                // silence
            }

            $member->rank_id = $newRank->id;
            $member->save();
        }

        $this->showToast('Rank has been updated successfully!');

        return redirect(route('member', $member->getUrlParams()));
    }

    /**
     * @param  Member  $member
     * @return Application|Factory|View
     */
    public function edit(Member $member)
    {
        $this->authorize('update', $member);

        $ranks = (auth()->user()->isRole('admin'))
            ? Rank::all()
            : Rank::where('id', '<', auth()->user()->member->rank_id)->get();

        $rankHistory = MemberHistory::query()
            ->with([
                'trackable' => function (MorphTo $morphTo) {
                    $morphTo->morphWith([Rank::class]);
                },
            ])->get();

        $division = $member->division;

        return view('member.rank.edit', compact('ranks', 'member', 'division', 'rankHistory'));
    }
}
