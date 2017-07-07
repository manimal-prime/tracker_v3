@extends('application.base')
@section('content')

    @component ('application.components.division-heading')
        @slot ('icon')
            <a href="{{ route('division', $division->abbreviation) }}">
                <img src="{{ getDivisionIconPath($division->abbreviation) }}" />
            </a>
        @endslot
        @slot ('heading')
            {{ $platoon->name }}
        @endslot
        @slot ('subheading')
            {{ $division->name }} Division
        @endslot
    @endcomponent

    <div class="container-fluid">

        {!! Form::model($squad, ['method' => 'patch', 'route' => ['updateSquad', $division->abbreviation, $platoon, $squad]]) !!}
        @include('squad.forms.edit-squad-form')
        {!! Form::close() !!}

        @can('delete', $squad)
            <hr />
            {!! Form::model($squad, ['method' => 'delete', 'route' => ['deleteSquad', $division->abbreviation, $platoon, $squad]]) !!}
            @include('squad.forms.delete-squad-form')
            {!! Form::close() !!}
            <hr />
        @endcan

        @include ('squad.partials.feed')

    </div>

@stop


