<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    {{--<meta name="description" content="{{ $settings->meta_description }}">--}}
    {{--<meta name="keywords" content="{{ $settings->meta_keywords }}">--}}
    {{--<meta name="author" content="{{ $settings->meta_author }}">--}}
    {{--<meta name="contact" content="{{ $settings->site_email }}">--}}
    {{--<meta name="contactNetworkAddress" CONTENT="{{ $settings->site_email }}">--}}
    {{--<meta name="contactStreetAddress1" CONTENT="{{ $settings->site_address }}">--}}
    {{--<meta name="contactPhoneNumber" CONTENT="{{ $settings->site_phone2 }}">--}}
    {{--<meta name="contactPhoneNumber" CONTENT="{{ $settings->site_phone1 }}">--}}
    {{--<meta name="contactPhoneNumber1" CONTENT="{{ $settings->site_phone1 }}">--}}
    {{--<meta name="contactPhoneNumber2" CONTENT="{{ $settings->site_phone2 }}">--}}

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>eCommerce-grade | @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
          name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('assets/admin/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/AdminLTE.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/skins/skin-blue.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/iCheck/flat/blue.css') }}">
    <!-- Morris chart -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/admin/plugins/morris/morris.css') }}"> -->
    <!-- ٍSelect2  -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/select2.min.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/datepicker/datepicker3.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">


    {{--<!--  <link rel="stylesheet" href="{{ asset('assets/admin/bootstrap/css/bootstrap-rtl.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ asset('assets/admin/dist/css/Style-AR-2.css') }}"> -->--}}

    <!-- <link rel="stylesheet" href="{{ asset('assets/admin/sweetalert.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('assets/admin/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/bootstrap-select/css/bootstrap-select.min.css') }}">
    @yield('styles')
    <link rel="shortcut icon" href="">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    {{--<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>--}}
        <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <![endif]-->
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
                                <img src="{{ asset('storage/uploads/images/avatars/admin-avatar-default.png') }}"
                                     class="img-circle"
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
    @yield('content-header')
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
        {{--<div class="loading">--}}
        {{--<i class="fa fa-refresh fa-spin fa-2x fa-fw"></i><br/>--}}
        {{--<span>Loading</span>--}}
        {{--</div>--}}
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

<script src="{{ asset('assets/admin/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/jQueryUI/jQuery-ui.min.js') }}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<script src="{{ asset('assets/admin/bootstrap/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('assets/admin/plugins/raphael/raphael.min.js') }}"></script>
<!-- <script src="{{ asset('assets/admin/plugins/morris/morris.min.js') }}"></script> -->
<script src="{{ asset('assets/admin/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/knob/jquery.knob.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/select2/select2.full.min.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('assets/admin/bootstrap-select/js/bootstrap-select.min.js') }}"></script>

<script src="{{ asset('assets/admin/dist/js/app.min.js') }}"></script>


<!-- <script src="{{ asset('assets/admin/dist/js/pages/dashboard.js') }}"></script> -->
<!-- <script src="{{ asset('assets/admin/dist/js/demo.js') }}"></script> -->


{{--<!-- <script src="{{ asset('assets/admin/dist/js/jquery.nicescroll.js') }}"></script> -->--}}

<div id="common-modal" class="modal fade" role="dialog">

</div>
@include('admin.templates.loading')
@include('admin.templates.alerts')
<!-- End Modal-Template -->


@yield('scripts')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script src="{{ asset('assets/admin/project.js') }}"></script>
<!-- <script src="{{ asset('assets/admin/sweetalert.min.js') }}"></script> -->
<script src="{{ asset('assets/admin/toastr.min.js') }}"></script>
<script type="text/javascript">

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

</script>

</body>
</html>
