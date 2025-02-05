<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-left">
        <!-- <a href="/" class="logo">User Management</a> -->
    </div>

    <div class="navbar-menu ">
        @can('master-control')
            <div class="drop-down">
                <button class="dropbtn">
                    @lang('general.nav.master_control')
                    &nbsp; <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    @can('category-access')
                        <a href="{{ route('category.index') }}">@lang('general.nav.category')</a>
                    @endcan
                        <a href="{{ route('vehical.index') }}">vehical</a>
                </div>
            </div>
        @endcan
    </div>

<div class="navbar-right">
    <div class="online">
        <img src="{{ asset('images/user-1.png') }}" class="nav-profile-img dropdown" onclick="toggleMenu()">
    </div>

    <div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
            <div class="user-info">
                <img src="{{ asset('images/user-1.png') }}">
                {{ Auth::user()->name ?? '' }}
            </div>
            <hr>
            <a href="{{ url('/logout') }}" class="sub-menu-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <img src="{{ asset('images/logout.png') }}">
                <p>Logout</p> {{-- Logout --}}
            </a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</div>
</nav>
<!-- Navbar -->
