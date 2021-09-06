<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Http\Requests\DeleteMember;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
class InactiveMemberController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $division
     * @return Factory|View
     */
    public function index($division)
    {
        $queryingTsInactives = strpos(request()->path(), 'inactive-members-ts');

        $inactiveMembers = $division->members()->whereFlaggedForInactivity(false)->where(function ($query) use ($division, $queryingTsInactives) {
            if ($queryingTsInactives) {
                $query->where('last_ts_activity', '<', \Carbon\Carbon::today()->subDays($division->settings()->inactivity_days));
            } else {
                $query->where('last_activity', '<', \Carbon\Carbon::today()->subDays($division->settings()->inactivity_days));
            }
        })->whereDoesntHave('leave')->with('rank', 'squad')->orderBy('last_activity')->get();

        if (request()->platoon) {
            $inactiveMembers = $inactiveMembers->where('platoon_id', request()->platoon->id);
        }

        $flagActivity = \App\Models\Activity::whereDivisionId($division->id)->where(function ($query) {
            $query->where('name', 'flagged_member')->orWhere('name', 'unflagged_member')->orWhere('name', 'removed_member');
        })->orderByDesc('created_at')->with('subject', 'subject.rank')->get();

        $flaggedMembers = $division->members()->with('rank')->whereFlaggedForInactivity(true)->get();

        /**
         * Using this to determine the active route, whether filtering
         * by teamspeak or forum. Used in platoon filter options, reset
         * filter button
         */
        $requestPath = $queryingTsInactives ? 'division.inactive-members-ts' : 'division.inactive-members';
        return view('division.inactive-members', compact('queryingTsInactives', 'division', 'inactiveMembers', 'flaggedMembers', 'flagActivity', 'requestPath'));
    }

    /**
     * Flags a member for inactivity
     *
     * @param Member $member
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function create(\App\Models\Member $member)
    {
        $this->authorize('update', $member);
        $member->flagged_for_inactivity = true;
        $member->save();
        $member->recordActivity('flagged');
        $this->showToast($member->name . " successfully flagged for removal");
        return redirect(route('division.inactive-members', $member->division->abbreviation));
    }

    /**
     * Remove a flag from an inactive member
     *
     * @param Member $member
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function destroy(\App\Models\Member $member)
    {
        $this->authorize('update', $member);
        $member->flagged_for_inactivity = false;
        $member->save();
        $member->recordActivity('unflagged');
        $this->showToast($member->name . " successfully unflagged");
        return redirect(route('division.inactive-members', $member->division->abbreviation));
    }

    public function removeMember(\App\Models\Member $member, \App\Http\Requests\DeleteMember $form)
    {
        $this->authorize('delete', $member);
        $division = $member->division;
        $form->persist();
        $this->showToast(ucwords($member->name) . " has been removed from the {$division->name} Division!");
        $member->recordActivity('removed');
        return redirect(route('division.inactive-members', [$division->abbreviation]) . '#flagged');
    }
}
