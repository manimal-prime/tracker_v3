@if($rankHistory->count())
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Rank</th>
            <th>Date</th>
            <th>Admin</th>
        </tr>
        </thead>
        @foreach ($rankHistory as $rank)
            <tr>
                <td>{{ $rank->trackable->name }}</td>
                <td>{{ $rank->created_at->format('Y-m-d') }}</td>
                <td>{{ $rank->admin->name }}</td>
            </tr>
        @endforeach
    </table>
@else
    <p><span class="text-muted">No rank activity</span></p>
@endif


@can('update', $member)
    <hr>
    <p>
        <a href="#" class="btn-add-note btn btn-default" data-toggle="modal"
           data-target="#rank-form">Update Rank</a>
    </p>
@endcan