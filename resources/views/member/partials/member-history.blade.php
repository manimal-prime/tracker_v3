<h4>Member History</h4>
<hr>
<div class="tabs-container">
    <ul class="nav nav-tabs">
        <li class="active"><a class="nav-link active" data-toggle="tab" href="#rank-tab" aria-expanded="true">Rank</a>
        </li>
        <li><a class="nav-link" data-toggle="tab" href="#position-tab" aria-expanded="false">Position</a></li>
        <li><a class="nav-link" data-toggle="tab" href="#division-tab" aria-expanded="false">Division</a></li>
    </ul>
    <div class="tab-content">
        <div id="rank-tab" class="tab-pane active">
            <div class="panel-body">
                @include('member.partials.rank-activity-table')
            </div>
        </div>
        <div id="position-tab" class="tab-pane">
            <div class="panel-body">
                <p><span class="text-muted">No position activity</span></p>
            </div>
        </div>
        <div id="division-tab" class="tab-pane">
            <div class="panel-body">
                <p><span class="text-muted">No division activity</span></p>
            </div>
        </div>
    </div>
</div>