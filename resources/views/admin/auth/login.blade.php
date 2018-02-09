<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> {{ $settings->site_name}} | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('assets/admin/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/iCheck/square/blue.css') }}">
    <!-- Arabic style over Write-->
    <link rel="stylesheet" href="{{ asset('assets/admin/bootstrap/css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/Style-AR-2.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Please Login </p>
            <form action="{{url('admin/auth/login')}}" method="post">
                 @include('admin.layouts.alerts')
                <div class="form-group has-feedback {{ $errors->has('username')? 'has-error' : ''}}">
                    {!! csrf_field() !!}

                    <input type="text" name="username" class="form-control" value="{{ count($errors) ? Request::old('username') : '' }}" placeholder="username or email" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                     @if ($errors->has('username'))
                        <span class="help-block">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password')? 'has-error' : ''}}">
                    <input type="password" name="password" class="form-control" placeholder="password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      @if ($errors->has('password'))
                        <span class="help-block">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember"> remember me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

             <a href="{{url('admin/auth/recover-password')}}">Forget Password؟</a><br>


        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 2.2.0 -->
    <script src="{{ asset('assets/admin/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{{ asset('assets/admin/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('assets/admin/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
    </script>
</body>
</html>
