<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="bg-header-dark">
        <div class="content-header bg-white-10">
            <!-- Logo -->
            <a class="link-fx font-w600 font-size-lg text-white" href="/">
                            <span class="smini-visible">
                                <span class="text-white-75">{{config('app.name')}}</span>
                            </span>
                <span class="smini-hidden">
                                <span class="text-white-75">{{config('app.name')}}</span>
                            </span>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>
                <!-- Toggle Sidebar Style -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <!-- Class Toggle, functionality initialized in Helpers.coreToggleClass() -->
                <a class="js-class-toggle text-white-75" data-target="#sidebar-style-toggler"
                   data-class="fa-toggle-off fa-toggle-on" data-toggle="layout" data-action="sidebar_style_toggle"
                   href="javascript:void(0)">
                    <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                </a>
                <!-- END Toggle Sidebar Style -->

                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <a class="d-lg-none text-white ml-2" data-toggle="layout" data-action="sidebar_close"
                   href="javascript:void(0)">
                    <i class="fa fa-times-circle"></i>
                </a>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Side Navigation -->
    <div class="content-side content-side-full">
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
                <a class="nav-main-link{{ request()->is('company') ? ' active' : '' }}" href="{{url('company')}}">
                    <i class="nav-main-link-icon fa fa-building"></i>
                    <span class="nav-main-link-name">Bedrijven</span>
                    {{--                    <span class="nav-main-link-badge badge badge-pill badge-success">5</span>--}}
                </a>
            </li>
            {{--            <li class="nav-main-item">--}}
            {{--                <a class="nav-main-link{{ request()->is('repair') ? ' active' : '' }}" href="{{url('repair')}}">--}}
            {{--                    <i class="nav-main-link-icon si si-wrench"></i>--}}
            {{--                    <span class="nav-main-link-name">Repair</span>--}}
            {{--                    <span class="nav-main-link-badge badge badge-pill badge-success">5</span>--}}
            {{--                </a>--}}
            {{--            </li>--}}
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
                            <span class="nav-main-link-badge badge badge-pill badge-primary">5</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('repair') ? ' active' : '' }}" href="{{url('repair')}}">
                            <i class="nav-main-link-icon fa fa-wrench"></i>
                            <span class="nav-main-link-name">Reparaties</span>
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
        </ul>
    </div>
    <!-- END Side Navigation -->
</nav>
