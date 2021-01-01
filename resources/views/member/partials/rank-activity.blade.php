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
                <td>{{ strtoupper(str_replace(['rank_', '_member'], '', $activity->name)) }}</td>
                <td>{{ $activity->created_at->format('Y-m-d') }}</td>
                <td>{{ $activity->user->name }}</td>
            </tr>
        @endforeach
    </table>
@else
    <span class="text-muted">No rank activity</span>
@endif