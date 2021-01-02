<div class="row">

    <div class="col-md-12">
        <div class="panel panel-filled">

            <div class="panel-body">

                <div class="row">
                    <div class="col-md-2 col-xs-6 text-center">
                        <h2 class="no-margins">
                            {{ $member->last_activity->diffInDays() }}
                        </h2>
                        <small class="text-uppercase">
                            {{ \Str::plural('day', $member->last_activity->diffInDays()) }} since <span class="c-white">last forum activity</span>
                        </small>
                    </div>

                    <div class="col-md-2 col-xs-6 text-center">
                        <h2 class="no-margins">
                            @if ($member->isPending)
                                <span class="text-muted">UNAVAILABLE</span>
                            @elseif ($member->tsInvalid)
                                TS MISCONFIGURATION
                            @else
                                {{ Carbon::parse($member->last_ts_activity)->diffInDays() }}
                            @endif
                        </h2>
                        <small class="text-uppercase">
                            {{ \Str::plural('day', Carbon::parse($member->last_ts_activity)->diffInDays()) }}
                            since <span class="c-white">last TS activity</span>
                        </small>
                    </div>

                    <div class="col-md-2 col-xs-12 text-center">
                        <h2 class="no-margins">
                            <a href="{{ route('member.recruits', $member->getUrlParams()) }}">{{ $member->recruits->count() }}</a>
                        </h2>
                        <small class="text-uppercase">
                            <span class="c-white">recruits</span>
                        </small>
                    </div>

                    <div class="col-md-3 col-xs-12 text-center">
                        <h2 class="no-margins">
                            {{ $lastRankChange }}
                        </h2>
                        <small class="text-uppercase">
                            last <span class="c-white">rank change</span>
                        </small>
                    </div>

                    <div class="col-md-3 col-xs-12 text-center">

                        <h2 class="no-margins">
                            {{ $member->join_date }}
                        </h2>
                        <small class="text-uppercase">member <span class="c-white">join date</span></small>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">

    @if ($member->discord)
        @component('application.components.data-block', ['isUppercase' => false])
            @slot('data'){!! $member->discord !!}@endslot
            @slot('title') Discord <span class="c-white">Tag</span> @endslot
        @endcomponent
    @endif

    @component('application.components.link-block')
        @slot('link')
            https://www.clanaod.net/forums/search.php?do=finduser&amp;userid={{ $member->clan_id }}&amp;
            contenttype=vBForum_Post&amp;showposts=1
        @endslot
        @slot('data') {{ $member->posts }} @endslot
        @slot('title') forum <span class="c-white">post count</span> @endslot
    @endcomponent

    @if ($member->recruiter && $member->recruiter_id !== 0)
        @component('application.components.link-block')
            @slot('link'){{ route('member', $member->recruiter->getUrlParams()) }}@endslot
            @slot('data'){{ $member->recruiter->present()->rankName }}@endslot
            @slot('title') clan <span class="c-white">recruiter</span> @endslot
        @endcomponent
    @endif
</div>

@if ($member->rank_id >= 9)
    <h4><i class="fa fa-user-shield text-danger"></i> Leadership Info</h4>
    <hr/>

    <div class="row">
        @component('application.components.data-block')
            @slot('data') {{ $member->last_trained_at ? $member->last_trained_at->format('Y-m-d') : '--' }} @endslot
            @slot('title') Last <span class="c-white">Rank Training</span> @endslot
        @endcomponent

        @if( $member->trainer)
            @component('application.components.link-block')
                @slot('link'){{ route('member', $member->trainer->getUrlParams()) }}@endslot
                @slot('data') {{$member->trainer->name }} @endslot
                @slot('title') Last <span class="c-white">Trained By</span> @endslot
            @endcomponent
        @endif

        @if($member->xo_at)
            @component('application.components.data-block')
                @slot('data') {{ $member->xo_at ? $member->xo_at->format('Y-m-d') : '--' }} @endslot
                @slot('title') <span class="c-white">XO Since</span> @endslot
            @endcomponent
        @endif

        @if ($member->co_at)
            @component('application.components.data-block')
                @slot('data') {{ $member->co_at ? $member->co_at->format('Y-m-d') : '--' }} @endslot
                @slot('title') <span class="c-white">CO Since</span> @endslot
            @endcomponent
        @endif
    </div>
@endif

