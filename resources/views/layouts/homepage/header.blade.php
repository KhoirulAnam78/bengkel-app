<!--::header part start::-->
<header class="main_menu home_menu">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="/" style="color:orangered"> <img src="{{ asset('assets/homepage/img/logounja-bg.png') }}"
                            alt="logo" width="50px"> Kerjasama Unja </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="ti-menu"></span>
                    </button>

                    <div class="collapse navbar-collapse main-menu-item justify-content-end"
                        id="navbarSupportedContent">
                        <ul class="navbar-nav align-items-center" >
                            <li class="nav-item">
                                <a class="nav-link" href="">Home</a>
                            </li>
                            <li class="nav-item text-nowrap">
                                <a class="nav-link" href="">Bentuk Kerjasama</a>
                            </li>
                            <li class="nav-item text-nowrap">
                                <a class="nav-link" href="">Mitra Kerjasama</a>
                            </li>
                            <li class="nav-item text-nowrap">
                                <a class="nav-link" href="">Kegiatan Kerjasama</a>
                            </li>
                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pages
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="project.html">project</a>
                                    <a class="dropdown-item" href="project_details.html">project details</a>
                                    <a class="dropdown-item" href="single-blog.html">Single blog</a>
                                    <a class="dropdown-item" href="elements.html">Elements</a>
                                </div>
                            </li> --}}
                            <li class="nav-item text-nowrap">
                                <a class="nav-link" href="contact.html">Data Kerjasama</a>
                            </li>
                            @if (Route::has('login'))
                                <li class="d-none d-lg-block">
                                    @auth
                                    <a class="btn_1 text-nowrap m-0" href="{{ route('dashboard.index') }}">Dashboard</a>
                                    @else
                                    <a class="btn_1 m-0" href="{{ route('login') }}">Login</a>
                                    @endauth
                                </li>
                            @endif
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- Header part end-->
