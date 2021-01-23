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

    <div class="dropdown" style="display: inline-block;">
        <button class="btn btn-default dropdown-toggle" type="button" id="tools" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true">
            <i class="fa fa-wrench text-accent"></i> Update rank
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="tools">


            <li>
                <a href="http://127.0.0.1:44678/divisions/sot/part-timers">
                    <i class="fa fa-plus text-success"></i> Promote
                </a>
            </li>

            <li>
                <a href="http://127.0.0.1:44678/divisions/sot/structure">
                    <i class="fa fa-minus text-danger"></i> Demote
                </a>
            </li>
            <li role="separator" class="divider"></li>
            <li>
                <a href="#" data-toggle="modal" data-target="#rank-form">Custom <i
                        class="fa fa-ellipsis-h"></i></a>
            </li>
        </ul>
    </div>
@endcan