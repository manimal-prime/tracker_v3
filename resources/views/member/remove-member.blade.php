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


        <div class="panel panel-filled">

            {!! Form::model($member, ['method' => 'delete', 'route' => ['deleteMember', $member->clan_id]]) !!}
            @include('member.forms.remove-member-form')
            {!! Form::close() !!}

        </div>


    </div>

@endsection

@section('footer_scripts')
    <script src="{!! asset('/js/manage-member.js?v=4.4') !!}"></script>
@endsection
