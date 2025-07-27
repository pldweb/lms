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

    <!-- Volt CSS -->
    <link type="text/css" href="{{asset('css/volt.css')}}" rel="stylesheet">

</head>
<body>


    <main class="content" style="margin: 0">
        @yield('content')
    </main>
    
</body>
</html>
