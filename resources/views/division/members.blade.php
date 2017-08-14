@extends('application.base')

@section('content')

    @component ('application.components.division-heading', [$division])
        @slot ('icon')
            <img src="{{ getDivisionIconPath($division->abbreviation) }}" class="division-icon-large" />
        @endslot
        @slot ('heading')
            <span class="hidden-xs">Division Members</span>
        @endslot
        @slot ('subheading')
            {{ $division->name }}
        @endslot
    @endcomponent

    <div class="container-fluid">

        {!! Breadcrumbs::render('members', $division) !!}

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-filled m-b-xl" id="{{ $division->abbreviation }}">
                    <div class="panel-heading">
                        {{ $division->name }} Division
                    </div>
                    <div class='panel-body border-bottom'>
                        <div id='playerFilter'></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover members-table">
                            <thead>
                            @include ('member.partials.member-header-row')
                            </thead>
                            <tbody>
                            @foreach ($members as $member)
                                @include ('member.partials.member-data-row')
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <small class="slight"><span class="text-accent"><i class="fa fa-asterisk"></i></span> - On Leave
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-filled">
                    <div class="panel-body">
                        <h1>
                            <i class="pe pe-7s-users pe-lg text-warning"></i> {{ $members->count() }}
                            <small class="slight">Members</small>
                        </h1>
                    </div>
                </div>
                <div class="panel panel-filled hidden-xs hidden-sm">
                    <div class="panel-heading">
                        Forum Activity
                    </div>
                    <div class="panel-body">
                        <canvas class="forum-activity-chart"
                                data-labels="{{ json_encode($forumActivityGraph['labels']) }}"
                                data-values="{{ json_encode($forumActivityGraph['values']) }}"
                                data-colors="{{ json_encode($forumActivityGraph['colors']) }}"></canvas>
                    </div>
                </div>
                <div class="panel panel-filled hidden-xs hidden-sm">
                    <div class="panel-heading">
                        TS Activity
                    </div>
                    <div class="panel-body">
                        <canvas class="ts-activity-chart" data-labels="{{ json_encode($tsActivityGraph['labels']) }}"
                                data-values="{{ json_encode($tsActivityGraph['values']) }}"
                                data-colors="{{ json_encode($tsActivityGraph['colors']) }}"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_scripts')
    <script src="{!! asset('/js/platoon.js?v=2.0') !!}"></script>
@stop