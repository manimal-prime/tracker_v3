<div class="panel panel-filled">
    <div class='panel-body border-bottom'>
        <div id='playerFilter'></div>
    </div>
    <div class="table-responsive">

        <table class='table table-striped table-hover members-table'>
            <thead>
            <tr>
                <th class='col-hidden'><strong>Rank Id</strong></th>
                <th class='col-hidden'><strong>Last Login Date</strong></th>
                <th><strong>Member</strong></th>
                <th class='nosearch text-center'><strong>Rank</strong></th>
                <th class='text-center hidden-xs hidden-sm'><strong>Joined</strong></th>
                <th class='text-center'><strong>Last Activity</strong></th>
                <th class='text-center'>
                    <string>Last Promoted</string>
                </th>
            </tr>
            </thead>

            <tbody>

            @foreach($members as $member)
                <tr role="row">
                    <td class="col-hidden">{{ $member->rank_id }}</td>
                    <td class="col-hidden">{{ $member->last_activity }}</td>
                    <td class="">{!! $member->present()->nameWithIcon !!} <a
                                href="{{ route('member', $member->clan_id) }}"><i
                                    class="fa fa-search text-muted pull-right" title="View profile"></i></a></td>
                    <td class="text-center">{{ $member->rank->abbreviation }}</td>
                    <td class="text-center hidden-xs hidden-sm">{{ $member->join_date }}</td>
                    <td class="text-center">
                        <span class="{{ getActivityClass($member->last_activity, $division) }}">{{ $member->present()->lastActive }}</span>
                    </td>
                    <td class="text-center">{{ $member->last_promoted }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>