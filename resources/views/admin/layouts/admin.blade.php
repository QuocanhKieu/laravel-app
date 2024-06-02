<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('admins/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admins/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/semantic.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.0/css/all.css">


    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        .loginButton, .logoutButton {
            padding: 2px;
        }
    </style>
    @yield('this-css')
</head>
<body class="hold-transition sidebar-mini ">
<div class="wrapper">

    <!-- Navbar -->
    @include('admin.partials.header')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('admin.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    @yield('content')
{{--    @yield() là để chờ section--}}
{{--    @include() là lấy vào luôn--}}
    <!-- /.content-wrapper -->



    <!-- Control Sidebar -->
{{--    <aside class="control-sidebar control-sidebar-dark">--}}
{{--        <!-- Control sidebar content goes here -->--}}
{{--        <div class="p-3">--}}
{{--            <h5>Title</h5>--}}
{{--            <p>Sidebar content</p>--}}
{{--        </div>--}}
{{--    </aside>--}}
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    @include('admin.partials.footer')
    @if (session('error'))
        <script>
            // Show alert with the error message
            alert("{{ session('error') }}");
        </script>
    @endif
    @if (session('success'))
        <script>
            // Show alert with the error message
            alert("{{ session('success') }}");
        </script>
    @endif
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('admins/js/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('admins/js/bootstrap.bundle.min.js')}}"></script>


<!-- AdminLTE App -->
<script src="{{asset('admins/js/adminlte.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
@yield('this-js')
</body>
</html>
