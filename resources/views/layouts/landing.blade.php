<!DOCTYPE html>
<html>
<head>
    <title>LMS SMP 20 Jakarta - @yield('title')</title>

    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="Author" content="Muhammad Rivaldi Fanani">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO -->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="INDEX,FOLLOW">

    <link rel="shortcut icon" href="{{asset('img/favicon/smp20-icon.png')}}" type="image/x-icon">
    
    <!-- Styling -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{asset('landing/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/magnific-popup.min.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/slick.min.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/master.css')}}">

    @stack('styles')
</head>
<body>

    @include('landing.components.header')

    <div class="popup-search-box d-none d-lg-block  ">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#">
            <input type="text" class="border-theme" placeholder="Apa yang sedang kamu cari?">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div>

    <div class="content-master">
        @yield('content')
    </div>

    @include('landing.components.footer')

    <!-- Jquery -->
    <script src="{{asset('landing/js/vendor/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('landing/js/slick.min.js')}}"></script>
    <script src="{{asset('landing/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('landing/js/wow.min.js')}}"></script>
    <script src="{{asset('landing/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('landing/js/main.js')}}"></script>

</body>
</html>
