<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="icon" href="img/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/homepage/css/bootstrap.min.css') }}">
    <!-- animate CSS -->
    <link rel="stylesheet" href="{{ asset('assets/homepage/css/animate.css') }}">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="{{ asset('assets/homepage/css/owl.carousel.min.css') }}">
    <!-- themify CSS -->
    <link rel="stylesheet"
        href="{{ asset('assets/homepage/css/themify-icons.css"') }}>
    <!-- flaticon CSS -->
    <link rel="stylesheet"
        href="{{ asset('assets/homepage/css/flaticon.css') }}">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/homepage/css/magnific-popup.css') }}">
    <!-- swiper CSS -->
    <link rel="stylesheet" href="{{ asset('assets/homepage/css/slick.css') }}">
    <!-- style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/homepage/css/style.css') }}">
</head>

<body>
    @include('layouts.homepage.header')

    @yield('content')

    @include('layouts.homepage.footer')

    <!-- jquery plugins here-->
    <!-- jquery -->
    <script src="{{ asset('assets/homepage/js/jquery-1.12.1.min.js') }}"></script>
    <!-- popper js -->
    <script src="{{ asset('assets/homepage/js/popper.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('assets/homepage/js/bootstrap.min.js') }}"></script>
    <!-- easing js -->
    <script src="{{ asset('assets/homepage/js/jquery.magnific-popup.js') }}"></script>
    <!-- swiper js -->
    <script src="{{ asset('assets/homepage/js/swiper.min.js') }}"></script>
    <!-- isotope js -->
    <script src="{{ asset('assets/homepage/js/isotope.pkgd.min.js') }}"></script>
    <!-- particles js -->
    <script src="{{ asset('assets/homepage/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/homepage/js/jquery.nice-select.min.js') }}"></script>
    <!-- swiper js -->
    <script src="{{ asset('assets/homepage/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/homepage/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/homepage/js/waypoints.min.js') }}"></script>
    <!-- custom js -->
    <script src="{{ asset('assets/homepage/js/custom.js') }}"></script>
</body>

</html>
