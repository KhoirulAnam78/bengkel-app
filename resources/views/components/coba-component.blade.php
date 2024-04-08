<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ url('/') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/homepage/img/logounja-bg.png') }}" alt="" height="50">
                <h5 class="text-white">Kerjasama</h5>
            </span>
            <span class="logo-lg">
                <!-- <img src="/assets/images/logo/logo-dark.png" alt="" height="17"> -->
                <img src="{{ asset('assets/homepage/img/logounja-bg.png') }}" alt="" height="50">
                <h5 class="text-white">Kerjasama</h5>
                {{-- Template --}}
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ url('/') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/homepage/img/logounja-bg.png') }}" alt="" height="52">
                <h5 class="text-white">Kerjasama</h5>
            </span>
            <span class="logo-lg">
                <!-- <img src="/assets/images/logo/logo-light.png" alt="" height="17"> -->
                <img src="{{ asset('assets/homepage/img/logounja-bg.png') }}" alt="" height="50">
                <h5 class="text-white">Kerjasama</h5>
                {{-- Template --}}
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                {{-- <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link collapsed active" href="#sidebarDashboards" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                    <div class="collapse menu-dropdown show" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="dashboard-analytics.html" class="nav-link" data-key="t-analytics"> Analytics
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-crm.html" class="nav-link" data-key="t-crm"> CRM </a>
                            </li>
                            <li class="nav-item">
                                <a href="index.html" class="nav-link active" data-key="t-ecommerce"> Ecommerce </a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-crypto.html" class="nav-link" data-key="t-crypto"> Crypto </a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-projects.html" class="nav-link" data-key="t-projects"> Projects </a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-nft.html" class="nav-link" data-key="t-nft"> NFT</a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-job.html" class="nav-link" data-key="t-job">Job</a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu --> --}}

                @foreach ($menus as $menu)
                    @can($menu->permission_name)
                        {{-- <li class="menu-title"><span data-key="t-menu">{{ $menu->name }}</span></li> --}}
                        {{-- <li class="menu-title"><span data-key="t-menu">{{ $menu->name }}</span></li> --}}
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ in_array(request()->route()->action['as'],$menu->items->pluck('route')->toArray()) ? 'collapsed active' : '' }}" href="#{{ 'Id'.$menu->name }}"
                                data-bs-toggle="collapse" role="button" aria-expanded="false"
                                aria-controls="{{ 'Id'.$menu->name }}">
                                <span data-key="t-dashboards">{{ $menu->name }}</span>
                            </a>
                            <div class="collapse menu-dropdown {{ in_array(request()->route()->action['as'],$menu->items->pluck('route')->toArray()) ? 'show' : '' }}" id="{{ 'Id'.$menu->name }}">
                                <ul class="nav nav-sm flex-column">
                                    @foreach ($menu->items as $item)
                                        @can($item->permission_name)
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs($item->route) ? ' active' : '' }}"
                                                    href="{{ route($item->route) }}">
                                                    <i class="{{ $item->icon }}"></i> <span
                                                        data-key="t-landing">{{ $item->name }}</span>
                                                </a>
                                            </li>
                                        @endcan
                                        <!-- end can item -->
                                    @endforeach
                                    {{-- <li class="nav-item">
                                        <a href="dashboard-analytics.html" class="nav-link" data-key="t-analytics">
                                            Analytics </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </li>

                        {{-- @foreach ($menu->items as $item)
                            @can($item->permission_name)
                            
                                <li class="nav-item">
                                    <a class="nav-link menu-link{{ request()->routeIs($item->route) ? ' active' : '' }}"
                                        href="{{ route($item->route) }}">
                                        <i class="{{ $item->icon }}"></i> <span
                                            data-key="t-landing">{{ $item->name }}</span>
                                    </a>
                                </li>
                            @endcan
                            <!-- end can item -->
                        @endforeach --}}
                        <!-- end foreach items -->
                    @endcan
                    <!-- end can menu -->
                @endforeach
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
