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
                    <form action="{{ route('member.rank.update', $member->getUrlParams()) }}" method="post">
                        {{ csrf_field() }}
                        <div class="panel-heading panel-b-accent">
                            <strong class="c-white">Rank</strong>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rank">New rank</label>
                                        <select name="rank" id="rank" class="form-control">
                                            @foreach ($ranks as $rank)
                                                <option value="{{ $rank->id }}">{{ $rank->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('created_at', 'Effective date') !!} <span
                                        class="text-accent">*</span>
                                    {{ Form::date('created_at', now(), ['class' => 'form-control', 'required' => 'required']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" name="historical" id="historical">
                                <label for="historical">Historical entry?</label>
                                <p class="help-text">Enabling this will leave the member's current rank intact.</p>
                            </div>

                        </div>

                        <div class="panel-footer">
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>

                    </form>


                </div>
            </div>
            <div class="col-md-6">
                @include('member.partials.rank-activity-table')
            </div>


        </div>


    </div>

@endsection
