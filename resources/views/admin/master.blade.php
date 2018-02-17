<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    {{--<meta name="description" content="{{ $settings->meta_description }}">--}}
    {{--<meta name="keywords" content="{{ $settings->meta_keywords }}">--}}
    {{--<meta name="author" content="{{ $settings->meta_author }}">--}}
    {{--<meta name="contact" content="{{ $settings->site_email }}">--}}
    {{--<meta name="contactNetworkAddress"CONTENT="{{ $settings->site_email }}">--}}
    {{--<meta name="contactStreetAddress1"CONTENT="{{ $settings->site_address }}">--}}
    {{--<meta name="contactPhoneNumber" CONTENT="{{ $settings->site_phone2 }}">--}}
    {{--<meta name="contactPhoneNumber" CONTENT="{{ $settings->site_phone1 }}">--}}
    {{--<meta name="contactPhoneNumber1" CONTENT="{{ $settings->site_phone1 }}">--}}
    {{--<meta name="contactPhoneNumber2" CONTENT="{{ $settings->site_phone2 }}">--}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{--<title>{{ $settings->site_name}} | @yield('title')</title>--}}
    <title>e-Commerce</title>
<!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/admin/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('assets/admin/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/admin/dist/css/AdminLTE.min.css')}}">

    {{--@if (Config::get('app.locale') == 'en')--}}
    {{--<link rel="stylesheet" href="{{ asset('assets/admin/dist/css/AdminLTE.min.css') }}">--}}
    {{--@endif--}}
    {{--@if (Config::get('app.locale') == 'ar')--}}
    {{--<link rel="stylesheet" href="{{ asset('assets/admin/bootstrap/css/bootstrap-rtl.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ asset('assets/admin/dist/css/Style-AR-2.css') }}">--}}
    {{--@endif--}}


<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('assets/admin/dist/css/skins/_all-skins.min.css')}}">

    <!-- Morris chart -->
    <link rel="stylesheet" href="{{asset('assets/admin/bower_components/morris.js/morris.css')}}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/iCheck/flat/blue.css') }}">

    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset('assets/admin/bower_components/jvectormap/jquery-jvectormap.css')}}">

    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('assets/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">

    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- ٍSelect2  -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/select2.min.css') }}">


{{--           <!--  <link rel="stylesheet" href="{{ asset('assets/admin/bootstrap/css/bootstrap-rtl.css') }}">--}}
{{--            <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/Style-AR-2.css') }}"> -->--}}
{{--        <link rel="stylesheet" href="{{ asset('assets/admin/sweetalert.css') }}">--}}
@yield('styles')
{{--        <link rel="shortcut icon" href="{{ $settings->getLogo() }}">--}}


</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->

            {{--<span class="logo-lg"><b>{{ $settings->site_name }}</b></span>--}}
            <span class="logo-lg"><b>e-commerce</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{asset('storage/uploads/images/avatars/admin-avatar-default.png') }}"
                                 class="user-image" alt="User Image">
                            <span class="hidden-xs"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{ asset('storage/uploads/images/avatars/admin-avatar-default.png') }}" class="img-circle"
                                     alt="User Image">

                                <p>
                                    Muhammad Fayez - Admin
                                    <small>users_register: {{ Carbon\Carbon::now() }}</small>

                                    {{--                                            {{ trans('admin_global.users_name')}}: {{ $user->name }} - {{ $user->job }}--}}
                                    {{--<small>{{ trans('admin_global.users_register')}}: {{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</small>--}}
                                </p>
                            </li>
                            <!-- Menu Body -->

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat">logout</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

@include('admin.layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div>
                <h1>
                    <small>@yield('title')</small>
                </h1>
            </div>
            <div>
                @include('admin.layouts.alerts')
            </div>
        </section>
        @yield('content')
    </div>

@include('admin.layouts.footer')
@include('admin.layouts.settings')
<!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!--Modals-->
@yield('modals')
@yield('templates')
<!-- csrf form  -->
<form id="csrf">{!! csrf_field() !!}</form>

<!-- jQuery 3 -->
<script src="{{asset('assets/admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{asset('/assets/admin/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Bootstrap 3.3.7 -->
<script src="{{asset('/assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- Morris.js charts -->
<script src="{{asset('/assets/admin/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{asset('/assets/admin/bower_components/morris.js/morris.min.js')}}"></script>

<!-- Sparkline -->
<script src="{{asset('/assets/admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>

<!-- jvectormap -->
<script src="{{asset('/assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('/assets/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

<!-- jQuery Knob Chart -->
<script src="{{asset('/assets/admin/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>

<!-- daterangepicker -->
<script src="{{asset('/assets/admin/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('/assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

{{asset('/assets/admin/')}}
<!-- datepicker -->
<script src="{{asset('/assets/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('/assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>

<!-- Slimscroll -->
<script src="{{asset('/assets/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>

<!-- FastClick -->
<script src="{{asset('/assets/admin/bower_components/fastclick/lib/fastclick.js')}}"></script>

<!-- AdminLTE App -->
<script src="{{asset('/assets/admin/dist/js/adminlte.min.js')}}"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('/assets/admin/dist/js/pages/dashboard.js')}}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{asset('/assets/admin/dist/js/demo.js')}}"></script>

<script src="{{ asset('assets/admin/plugins/select2/select2.full.min.js') }}"></script>

<div id="common-modal" class="modal fade" role="dialog">

</div>
@include('admin.templates.delete-modal')
@include('admin.templates.loading')
@include('admin.templates.alerts')
<!-- End Modal-Template -->


@yield('scripts')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
{{--        <script src="{{ asset('assets/admin/sweetalert.min.js') }}"></script>--}}
<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay.min.js"></script>
{{--<script  src="{{ asset('assets/site/vendor/noty/js/noty/packaged/jquery.noty.packaged.min.js') }}"></script>--}}
{{--<script src="{{ asset('assets/admin/process.js') }}"></script>--}}
<script type="text/javascript">
    {{--$(document).ready(function () {--}}
    {{--"use strict";--}}
    {{--$("#googlemaps").gMap({--}}
    {{--latitude: {{ $settings->map_lat }},--}}
    {{--longitude: {{ $settings->map_lng }}--}}
    {{--});--}}
    {{--});--}}
</script>
</body>
</html>
