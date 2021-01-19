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

            <form action="{{ route('member.position.update', $member) }}" method="post">
                {{ csrf_field() }}
                <div class="panel-body">
                    <h4><i class="fa fa-wrench text-accent"></i> Position</h4>

                    <p>Position denotes responsibility withing a specific division or in the overall clan.
                        Setting a position here does not grant access of any kind.</p>

                    <select name="position" id="position" class="form-control">
                        @foreach (\App\Models\Position::all() as $position)
                            <option value="{{ $position->id }}"
                                    selected="{{ $member->position_id }}">{{ $position->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="panel-footer">
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>

            </form>

        </div>


    </div>

@endsection

@section('footer_scripts')
    <script src="{!! asset('/js/manage-member.js?v=4.4') !!}"></script>
@endsection
