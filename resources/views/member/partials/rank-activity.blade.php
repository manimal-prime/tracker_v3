<div class="tabs-container">
    <ul class="nav nav-tabs">
        <li class="active"><a class="nav-link active" data-toggle="tab" href="#tab-3"
                              aria-expanded="true"> <i
                    class="fa fa-user-plus"></i> Rank History</a></li>
        <li><a class="nav-link" data-toggle="tab" href="#tab-4" aria-expanded="false"> <i
                    class="fa fa-heart"></i> Division History</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-3" class="tab-pane active">
            <div class="panel-body">
                @include('member.partials.rank-activity-table')
            </div>
        </div>
        <div id="tab-4" class="tab-pane">
            <div class="panel-body">
                <p><span class="text-muted">No division activity</span></p>
            </div>
        </div>
    </div>
</div>