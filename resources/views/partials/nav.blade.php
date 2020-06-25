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
{{--                <a class="js-class-toggle text-white-75" data-target="#sidebar-style-toggler"--}}
{{--                   data-class="fa-toggle-off fa-toggle-on" data-toggle="layout" data-action="sidebar_style_toggle"--}}
{{--                   href="javascript:void(0)">--}}
{{--                    <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>--}}
{{--                </a>--}}
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
        @guest
        @else
            @if(auth()->user()->isOwner())
                @include('partials.types.owner')
            @elseif (auth()->user()->isMechanic())
                @include('partials.types.mechanic')
            @else
                @include('partials.types.location_manager')
            @endif
        @endguest
    </div>
    <!-- END Side Navigation -->
</nav>
