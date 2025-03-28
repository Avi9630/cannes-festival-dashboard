<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'NFA-DASHBOARD') }} - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('admin-iffi/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('admin-iffi/css/icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-iffi/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-iffi/css/css.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div id="layout-wrapper">
        @include('layouts.header')
        @include('layouts.sidebar')
        <div class="main-content">
            <div class="page-content">
                @yield('content')
            </div>
            @include('layouts.footer')
        </div>
    </div>
</body>

</html>
