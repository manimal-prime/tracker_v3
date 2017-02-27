<ul class="nav luna-nav">

    <li class="{{ set_active('home') }}">
        <a href="{{ route('home') }}">Dashboard</a>
    </li>

    <li class="{{ set_active('statistics') }}">
        <a href="{{ route('statistics') }}">Statistics</a>
    </li>

    <li class="{{ set_active('help') }}">
        <a href="{{ route('help') }}">Documentation</a>
    </li>

    <li>
        <a href="#user-cp" data-toggle="collapse" aria-expanded="false">
            User CP<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
        </a>

        <ul id="user-cp" class="nav nav-second collapse">
            <li><a href="{{ route('member', Auth::user()->member->clan_id) }}">{{ Auth::user()->name }}</a></li>
            <li><a href="usage.html">Settings</a></li>
            <li><a href="activity.html">Forum Profile</a></li>
            <li><a href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </li>
        </ul>
    </li>

    <li>
        <a href="#tools" data-toggle="collapse" aria-expanded="false">
            Tools<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
        </a>
        <ul id="tools" class="nav nav-second collapse">
            {{--class="{{ set_active('home') }}"--}}
            <li><a href="#">Thing</a></li>
            <li><a href="#">Thing</a></li>
            <li><a href="#">Thing</a></li>
            <li><a href="#">Thing</a></li>
            <li><a href="#">Thing</a></li>
        </ul>
    </li>
</ul>