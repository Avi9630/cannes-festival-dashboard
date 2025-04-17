<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box bg-logo">
        <!-- Dark Logo-->
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('cannes/CANNES.png') }}" alt="" class="img-fluid" style="height: 60px">
            {{-- style="width:110px" --}}
        </a>
        <!-- Light Logo-->
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav mt-4" id="navbar-nav">
                @if (Route::has('login'))
                    @auth

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/') }}">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">DASHBOARD</span>
                            </a>
                        </li>

                        @can('list-user')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarUser" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarUser">
                                    <i class="ri-user-2-line"></i> <span data-key="">USERS</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarUser">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('users.index') }}" class="nav-link" data-key="">LIST
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @can('list-role')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarRole" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarRole">
                                    <i class="ri-user-follow-line"></i> <span data-key="">ROLE</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarRole">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('roles.index') }}" class="nav-link" data-key="">LIST
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @can('list-permission')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#Permission" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="Permission">
                                    <i class="ri-lock-2-line"></i> <span data-key="">PERMISSION</span>
                                </a>
                                <div class="collapse menu-dropdown" id="Permission">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('permissions.index') }}" class="nav-link" data-key="">
                                                LIST </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @can('cannes-entries-list')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#nfaFeature" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="indianPanoroma">
                                    <i class="ri-flag-2-line"></i> <span data-key="">CANNES ENTRIES</span>
                                </a>
                                <div class="collapse menu-dropdown" id="nfaFeature">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('cannes-entries-list') }}" class="nav-link"
                                                data-key="">ALL</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('scored-entries') }}" class="nav-link"
                                                data-key="">SCORED ENTRIES By LEVEL1</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @can('cannes-selected-list')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#nfaNonFeature" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="indianPanoroma">
                                    <i class="ri-flag-2-line"></i> <span data-key="">CANNES SELECTED ENTRIES</span>
                                </a>
                                <div class="collapse menu-dropdown" id="nfaNonFeature">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('cannes-selected-list') }}" class="nav-link"
                                                data-key="">LIST</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @can('level2-permission')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#level2-permission" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="indianPanoroma">
                                    <i class="ri-flag-2-line"></i> <span data-key="">LEVEL2 ENTRIES</span>
                                </a>
                                <div class="collapse menu-dropdown" id="level2-permission">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('cannes-level2-list') }}" class="nav-link"
                                                data-key="">LIST</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        {{-- @can('nfa-best-book')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#nfaBestBook" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="indianPanoroma">
                                    <i class="ri-flag-2-line"></i> <span data-key="">BEST BOOK ON CINEMA</span>
                                </a>
                                <div class="collapse menu-dropdown" id="nfaBestBook">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('best-book-cinema') }}" class="nav-link"
                                                data-key="">LIST</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @can('nfa-best-film-critic')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#nfaBestFilmCritic" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="indianPanoroma">
                                    <i class="ri-flag-2-line"></i> <span data-key="">BEST FILM CRITIC</span>
                                </a>
                                <div class="collapse menu-dropdown" id="nfaBestFilmCritic">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('best-film-critic') }}" class="nav-link"
                                                data-key="">LIST</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan --}}
                    @else
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/') }}">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">DASHBOARD</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route('login') }}">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">LOGIN</span>
                            </a>
                        </li>
                    @endauth
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>

<div class="vertical-overlay"></div>
