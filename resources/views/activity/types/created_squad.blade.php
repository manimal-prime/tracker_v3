{{ $event->user->name }} created platoon {{ $event->subject->name }} &mdash; {{ $event->created_at->diffForHumans() }}