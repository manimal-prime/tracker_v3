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
            'admin_id' => auth()->user()->member_id,
            'created_at' => request()->created_at,
        ]);

        if (!request('historical')) {

            try {
                $this->callProcedure('set_user_rank', [$member->clan_id, $newRank->name]);
            } catch (QueryException $e) {
                // silence
            }

            // is this a promotion?
            if ($member->rank_id < $newRank->id) {
                $member->last_promoted_at = now();
            }

            $member->rank_id = $newRank->id;
            $member->save();
        }

        $this->showToast('Rank has been updated successfully!');

        return redirect(route('member', $member->getUrlParams()));
    }
}
