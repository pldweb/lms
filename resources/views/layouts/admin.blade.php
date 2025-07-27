<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>LMS SMP 20 Jakarta</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="Author" content="Muhammad Rivaldi Fanani">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO -->
    <link rel="shortcut icon" href="{{asset('img/favicon/smp20-icon.png')}}" type="image/x-icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Sweet Alert -->
    <link type="text/css" href="{{asset('vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

    <!-- Notyf -->
    <link type="text/css" href="{{asset('vendor/notyf/notyf.min.css')}}" rel="stylesheet">

    <!-- Volt CSS -->
    <link type="text/css" href="{{asset('css/volt.css')}}" rel="stylesheet">

    <!-- Admin CSS -->
    <link type="text/css" href="{{asset('css/admin.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">

    <!-- Include Choices JavaScript (latest) -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

</head>
<body>

    @include('components.top-navbar')
    @include('components.sidebar')
    
    <main class="content">
        @include('components.navbar')
        @yield('content')
    </main>
    
    @include('components.modal')
    
    <!-- Core -->
    <script src="{{asset("vendor/@popperjs/core/dist/umd/popper.min.js")}}"></script>
    <script src="{{asset("vendor/bootstrap/dist/js/bootstrap.min.js")}}"></script>
    
    <!-- Vendor JS -->
    <script src="{{asset("vendor/onscreen/dist/on-screen.umd.min.js")}}"></script>
    
    <!-- Slider -->
    <script src="{{asset("vendor/nouislider/dist/nouislider.min.js")}}"></script>
    
    <!-- Smooth scroll -->
    <script src="{{asset("vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js")}}"></script>
    
    <!-- Charts -->
    <script src="{{asset("vendor/chartist/dist/chartist.min.js")}}"></script>
    <script src="{{asset("vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js")}}"></script>
    
    <!-- Datepicker -->
    <script src="{{asset("vendor/vanillajs-datepicker/dist/js/datepicker.min.js")}}"></script>
    
    <!-- Sweet Alerts 2 -->
    <script src="{{asset("vendor/sweetalert2/dist/sweetalert2.all.min.js")}}"></script>
    
    <!-- Moment JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    
    
    <!-- Vanilla JS Datepicker -->
        <script src="{{asset("vendor/vanillajs-datepicker/dist/js/datepicker.min.js")}}"></script>
    
    <!-- Notyf -->
    <script src="{{asset("vendor/notyf/notyf.min.js")}}"></script>
    
    <!-- Simplebar -->
    <script src="{{asset("vendor/simplebar/dist/simplebar.min.js")}}"></script>
    
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    
    <script>
    
        $(document).ready(function (){
            spinner();
            // new WOW().init();
        })
        var spinner = function () {
            setTimeout(function () {
                if ($('#spinner').length > 0) {
                    $('#spinner').removeClass('show');
                }
            }, 1);
        };
    
        // Sticky Navbar
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('.sticky-top').css('top', '0px');
            } else {
                $('.sticky-top').css('top', '-100px');
            }
        });
    
        $('#dashboard-title').text('{{$title}}')
    </script>
    
    <!-- Volt JS -->
    <script src="{{asset("js/volt.js")}}"></script>
</body>
</html>
