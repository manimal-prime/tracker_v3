@extends('application.base-tracker')

@section('content')

    @component ('application.components.division-heading', ['division' => $division])
        @slot ('heading')
            {{ $division->name }} Division
        @endslot
        @slot ('subheading')
            {{ $division->description }}
        @endslot
    @endcomponent

    <div class="container-fluid">

        {!! Breadcrumbs::render('manage-division', $division) !!}

        @include('application.partials.errors')

        {{-- Edit profile nav --}}
        <div class="tabs-container">

            <ul class="nav nav-tabs">
                <li class="divisions active">
                    <a data-toggle="tab" href="#general-settings">
                        <i class="fa fa-sliders fa-lg"></i> <span class="hidden-xs hidden-sm">General</span>
                    </a>
                </li>
                <li class="censuses">
                    <a data-toggle="tab" href="#census">
                        <i class="fa fa-line-chart fa-lg"></i> <span class="hidden-xs hidden-sm">Census</span>
                    </a>
                </li>
                <li>
                    <a href="#recruiting-settings" data-toggle="tab">
                        <i class="fa fa-user-plus fa-lg"></i> <span class="hidden-xs hidden-sm">Recruiting</span>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#locality-settings">
                        <i class="fa fa-language fa-lg"></i> <span class="hidden-xs hidden-sm">Locality</span>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#discord-settings">
                        <i class="fab fa-discord"></i> <span class="hidden-xs hidden-sm">Discord</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="general-settings" class="tab-pane active">
                    <div class="panel-body">
                        @include('division.forms.general-settings')
                    </div>
                </div>

                <div id="census" class="tab-pane">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="panel-body">
                                @include('division.forms.census')
                            </div>
                        </div>
                        <div class="col-md-3 hidden-xs hidden-sm">
                            <div class="panel">
                                @include('division.forms.descriptions.census')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="recruiting-settings">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="panel-body">
                                @include('division.forms.recruiting')
                            </div>
                        </div>
                        <div class="col-md-3 hidden-xs hidden-sm">
                            <div class="panel">
                                @include('division.forms.descriptions.recruiting')
                            </div>
                        </div>
                    </div>
                </div>

                <div id="locality-settings" class="tab-pane">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="panel-body">
                                @include('division.forms.locality')
                            </div>
                        </div>
                        <div class="col-md-3 hidden-xs hidden-sm">
                            <div class="panel">
                                @include('division.forms.descriptions.locality')
                            </div>
                        </div>
                    </div>
                </div>

                <div id="discord-settings" class="tab-pane">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="panel-body">
                                @include('division.forms.discord')
                            </div>
                        </div>
                        <div class="col-md-3 hidden-xs hidden-sm">
                            <div class="panel">
                                @include ('division.forms.descriptions.discord')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection