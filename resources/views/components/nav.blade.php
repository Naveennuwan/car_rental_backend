<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-left">
        <a href="/" class="logo">User Management</a>
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
</nav>
<!-- Navbar -->
