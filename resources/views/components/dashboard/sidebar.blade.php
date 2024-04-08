@php
    use App\Models\MenuGroup;
    use App\Models\Setting;
    $menus = MenuGroup::query()
        ->with('items', function ($query) {
            return $query->where('status', true)->orderBy('posision');
        })
        ->where('status', true)
        ->orderBy('posision')
        ->get();
    $name = Setting::where('name', 'app_name')->first();
    if ($name) {
        $app_name = $name->data;
    }
    $logo = Setting::where('name', 'logo')->first();
    if ($logo) {
        $app_logo = json_decode($logo->data);
    }
@endphp
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ url('/') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('storage/' . $app_logo->path) }}" alt="" height="{{ $app_logo->size }}">
                <h5 class="text-white">{{ $app_name }}</h5>
            </span>
            <span class="logo-lg">
                <!-- <img src="/assets/images/logo/logo-dark.png" alt="" height="17"> -->
                <img src="{{ asset('storage/' . $app_logo->path) }}" alt="" height="{{ $app_logo->size }}">
                <h5 class="text-white">{{ $app_name }}</h5>
                {{-- Template --}}
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ url('/') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('storage/' . $app_logo->path) }}" alt="" height="{{ $app_logo->size }}">
                <h5 class="text-white">{{ $app_name }}</h5>
            </span>
            <span class="logo-lg">
                <!-- <img src="/assets/images/logo/logo-light.png" alt="" height="17"> -->
                <img src="{{ asset('storage/' . $app_logo->path) }}" alt="" height="{{ $app_logo->size }}">
                <h5 class="text-white">{{ $app_name }}</h5>
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
                <li class="nav-item mt-2">
                    <a class="nav-link {{ request()->routeIs('dashboard.index') ? ' active' : '' }}"
                        href="{{ route('dashboard.index') }}">
                        {{-- <i class=""></i>  --}}
                        <span data-key="t-landing">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('setting.index') ? ' active' : '' }}"
                        href="{{ route('setting.index') }}">
                        {{-- <i class=""></i>  --}}
                        <span data-key="t-landing">Pengaturan Aplikasi</span>
                    </a>
                </li>

                @foreach ($menus as $menu)
                    @can($menu->permission_name)
                        {{-- <li class="menu-title"><span data-key="t-menu">{{ $menu->name }}</span></li> --}}
                        {{-- <li class="menu-title"><span data-key="t-menu">{{ $menu->name }}</span></li> --}}
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ in_array(request()->route()->action['as'], $menu->items->pluck('route')->toArray()) ? 'collapsed active' : '' }}"
                                href="#{{ 'Id' . str_replace([' ', '(', ')'], '', $menu->name) }}"
                                data-bs-toggle="collapse" role="button" aria-expanded="false"
                                aria-controls="{{ 'Id' . str_replace([' ', '(', ')'], '', $menu->name) }}">
                                <span data-key="t-dashboards">{{ $menu->name }}</span>
                            </a>
                            <div class="collapse menu-dropdown {{ in_array(request()->route()->action['as'], $menu->items->pluck('route')->toArray()) ? 'show' : '' }}"
                                id="{{ 'Id' . str_replace([' ', '(', ')'], '', $menu->name) }}">
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
                {{-- @foreach ($menus as $menu)
                    @can($menu->permission_name)
                        <li class="menu-title"><span data-key="t-menu">{{ $menu->name }}</span></li>

                        @foreach ($menu->items as $item)
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
                        @endforeach
                        <!-- end foreach items -->
                    @endcan
                    <!-- end can menu -->
                @endforeach --}}
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
