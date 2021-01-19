@extends('application.base-tracker')
@section('content')

    @component ('application.components.division-heading')
        @slot ('icon')
            @if ($division)
                <img src="{{ getDivisionIconPath($division->abbreviation) }}"/>
            @else
                <img class="division-icon-large" src="{{ asset('images/logo_v2.svg') }}"/>
            @endif
        @endslot
        @slot ('heading')
            {!! $member->present()->rankName !!}
        @endslot
        @slot ('subheading')
            {{ $member->position->name ?? "No Position" }}
        @endslot
    @endcomponent

    <div class="container-fluid">
        @include ('application.partials.back-breadcrumb', ['page' => 'profile', 'link' => route('member', $member->getUrlParams())])

        @include('application.partials.errors')


        <h4><i class="fa fa-user-plus text-accent"></i> Update Member Rank</h4>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-filled">



                </div>
            </div>
            <div class="col-md-6">
                @include('member.partials.rank-activity-table')
            </div>


        </div>


    </div>

@endsection
