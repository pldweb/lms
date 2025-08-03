<!DOCTYPE html>
<html>
<head>
    <title>LMS SMP 20 Jakarta - @yield('title')</title>

    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="keywords')}}">
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
    
    <link rel="shortcut icon" href="{{asset('img/favicon/smp20-icon.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/file-upload.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/plyr.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('admin/css/full-calendar.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/editor-quill.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/apexcharts.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/calendar.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/jquery-jvectormap-2.0.5.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/main.css')}}">

    <script src="{{asset('admin/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>

    @stack('styles')
</head>
<body>

    <div id="main-content">
        @yield('content')
    </div>

    <!-- Jquery -->
    <script src="{{asset('admin/js/boostrap.bundle.min.js')}}"></script>
    <script src="{{asset('admin/js/phosphor-icon.js')}}"></script>
    <script src="{{asset('admin/js/file-upload.js')}}"></script>
    <script src="{{asset('admin/js/plyr.js')}}"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="{{asset('admin/js/full-calendar.js')}}"></script>
    <script src="{{asset('admin/js/jquery-ui.js')}}"></script>
    <script src="{{asset('admin/js/editor-quill.js')}}"></script>
    <script src="{{asset('admin/js/apexcharts.min.js')}}"></script>
    <script src="{{asset('admin/js/calendar.js')}}"></script>
    <script src="{{asset('admin/js/jquery-jvectormap-2.0.5.min.js')}}"></script>
    <script src="{{asset('admin/js/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- main js -->
    <script src="{{asset('admin/js/main.js')}}"></script>
   
</body>
</html>
