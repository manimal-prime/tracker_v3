@extends('application.base-tracker')

@section('content')

    @component ('application.components.division-heading')
        @slot ('icon')
            @if ($division)
                <img src="{{ getDivisionIconPath($division->abbreviation) }}"
                     class="division-icon-large"/>
            @else
                <img src="{{ asset('images/logo_v2.svg') }}" width="50px" style="opacity: .2;"/>
            @endif
        @endslot
        @slot ('heading')
            {!! $member->present()->rankName !!}
            @include('member.partials.member-actions-button', ['member' => $member])
        @endslot
        @slot ('subheading')
            @if ($member->isPending())
                <span class="text-accent"><i class="fa fa-hourglass"></i>  Pending member</span>
            @elseif ($member->division_id == 0)
                <span class="text-muted"><i class="fa fa-user-times"></i> Ex-AOD</span>
            @else
                {{ $member->position->name ?? "No Position" }}
            @endif
        @endslot
    @endcomponent

    <div class="container-fluid">

        {!! Breadcrumbs::render('member-recruits', $member, $division) !!}

        @if (count($member->recruits))
            <h4>
                <i class="fa fa-user-plus text-primary"></i>
                Recruiting History
            </h4>
            <hr/>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Member</th>
                    <th>Join Date</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($member->recruits as $recruit)
                    <tr>
                        <td>
                            {{ $recruit->present()->rankName }}
                            <span class="pull-right">
                    <a href="{{ route('member', $recruit->getUrlParams()) }}">
                        <i class="fa fa-search"></i>
                    </a>
                </span>
                        </td>
                        <td>{{ $recruit->join_date }}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        @endif


    </div>


@endsection
