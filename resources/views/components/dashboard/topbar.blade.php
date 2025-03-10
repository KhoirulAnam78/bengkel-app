<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="/assets/images/logo/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="/assets/images/logo/logo-dark.png" alt="" height="17">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="/assets/images/logo/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="/assets/images/logo/logo-light.png" alt="" height="17">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">

                @if (session()->has('main_user'))
                    <div class="ms-1 header-item d-none d-sm-flex">
                        <form action="{{ route('logoutAs') }}" method="POST">
                            @csrf
                            <input type="hidden" name="main_user" value="{{ session('main_user') }}">
                            <button type="submit" class="btn btn-primary btn-sm">Logout As
                                {{ auth()->user()->name }}</button>
                        </form>
                    </div>
                @endif

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <a href="{{ route('dashboard.mode') }}" id="darkMode"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle">
                        @if (session()->get('mode') == 'dark')
                            <i class="ri-sun-line"></i>
                        @else
                            <i class='bx bx-moon fs-22'></i>
                        @endif
                    </a>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->name }}</span>
                                <span
                                    class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{ auth()->user()->getRoleNames()[0] }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{ auth()->user()->name }}!</h6>
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('form-logout').submit()">
                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle" data-key="t-logout">Logout</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" id="form-logout">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
