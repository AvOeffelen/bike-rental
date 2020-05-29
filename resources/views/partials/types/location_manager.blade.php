<ul class="nav-main">
    <li class="nav-main-item">
        <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="/dashboard">
            <i class="nav-main-link-icon si si-cursor"></i>
            <span class="nav-main-link-name">Dashboard</span>
            {{--                    <span class="nav-main-link-badge badge badge-pill badge-success">5</span>--}}
        </a>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link{{ request()->is('location') ? ' active' : '' }}" href="{{url('location')}}">
            <i class="nav-main-link-icon fa fa-building"></i>
            <span class="nav-main-link-name">Locaties</span>
            {{--                    <span class="nav-main-link-badge badge badge-pill badge-success">5</span>--}}
        </a>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
           aria-expanded="false" href="#">
            <i class="nav-main-link-icon fa fa-bicycle"></i>
            <span class="nav-main-link-name">Fietsen</span>
        </a>
        <ul class="nav-main-submenu">
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('bicycles') ? ' active' : '' }}"
                   href="{{url('bicycles')}}">
                    <i class="nav-main-link-icon fa fa-list"></i>
                    <span class="nav-main-link-name">Overzicht</span>
                    {{--                            <span class="nav-main-link-badge badge badge-pill badge-primary">5</span>--}}
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('bicycle/timeline') ? ' active' : '' }}"
                   href="{{url('bicycle/timeline')}}">
                    <i class="nav-main-link-icon fa fa-wrench"></i>
                    <span class="nav-main-link-name">Fiets historie</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-main-item">
        <a class="nav-main-link{{ request()->is('users') ? ' active' : '' }}" href="{{url('users')}}">
            <i class="nav-main-link-icon fa fa-user"></i>
            <span class="nav-main-link-name">Gebruikers</span>
            {{--                    <span class="nav-main-link-badge badge badge-pill badge-success">5</span>--}}
        </a>
    </li>
</ul>
