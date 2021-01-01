<?php

namespace App\Http\Controllers;

use App\AOD\Traits\Procedureable;
use App\Models\Member;
use App\Models\Rank;

class MemberRankController extends Controller
{
    use Procedureable;

    public function update(Member $member)
    {
        $this->authorize('update', $member);

        request()->validate([
            'created_at' => 'required',
            'rank' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value >= auth()->user()->member->rank_id && auth()->user()->member->rank_id >= 5 && !auth()->user()->isRole('admin')) {
                        $fail("You are not authorized to set that rank");
                    }
                }
            ]
        ]);

        $newRank = Rank::findOrFail(request()->rank);

        $member->recordActivity('rank_' . strtolower($newRank->abbreviation), request('created_at'));

        if(!request('historical')) {

            if (!$this->callProcedure('set_user_rank', [$member->clan_id, $newRank->name])) {
                return response('An error has occurred', 500);
            }

            $member->rank_id = $newRank->id;
            $member->save();
        }

        return redirect(route('member', $member->getUrlParams()));
    }

    /**
     * @param  Member  $member
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Member $member)
    {
        $ranks = (auth()->user()->isRole('admin'))
            ? Rank::all()
            : Rank::where('id', '<', auth()->user()->member->rank_id)->get();

        $rankActivity = $member->rankActivity()->get();

        $division = $member->division;

        return view('member.rank.edit', compact('ranks', 'member', 'division', 'rankActivity'));
    }
}
