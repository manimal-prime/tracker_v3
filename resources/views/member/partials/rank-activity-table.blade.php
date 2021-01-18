@if($rankActivity->count())
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Rank</th>
            <th>Date</th>
            <th>Updated By</th>
        </tr>
        </thead>
        @foreach ($rankActivity as $activity)
            <tr>
                <td>{{ $activity->rank->name }}</td>
                <td>{{ $activity->created_at->format('Y-m-d') }}</td>
                <td>{{ $activity->admin->name }}</td>
            </tr>
        @endforeach
    </table>
@else
    <p><span class="text-muted">No rank activity</span></p>
@endif