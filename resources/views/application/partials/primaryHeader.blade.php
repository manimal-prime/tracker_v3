<div class="container-fluid">
    <div class="navbar-header">
        <div id="mobile-menu">
            <div class="left-nav-toggle">
                <a href="#">
                    <i class="stroke-hamburgermenu"></i>
                </a>
            </div>
        </div>
        <a class="navbar-brand" href="{{ route('home') }}">
            AOD TRACKER
            <span>v3</span>
        </a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <div class="left-nav-toggle">
            <a href="#">
                <i class="stroke-hamburgermenu"></i>
            </a>
        </div>
        <form class="navbar-form navbar-left">
            <input type="text" class="form-control" id="member-search"
                   placeholder="Search for a player..."/>
            <div id='member-search-results' class='scroll'></div>
            <span id="searchclear" class="fa fa-times-circle fa-2x text-muted pull-right"></span>
        </form>
    </div>
</div>