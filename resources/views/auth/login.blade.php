<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/flat/blue.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
  
  <link rel="stylesheet" href="{{ asset('plugins/sweetAlert2/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2/select2-bootstrap4.min.css') }}">  

  <!-- Google Font: Source Sans Pro -->
  {{--  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">  --}}
  {{--  <link href="https://fonts.googleapis.com/css?family=Athiti&display=swap" rel="stylesheet">  --}}
  <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <style>
      .swal2-container{
        z-index: 9999;
      }
      .preloader{
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        border-radius: .25rem;
        align-items: center;
        background: rgba(255,255,255,.7);
        display: flex;
        justify-content: center;
        z-index: 9998;
      }
  </style>
</head>
<body class="hold-transition login-page">

    <div class="login-box">
        <div class="login-logo">
            <h3>SWEET HOME CLEANFOOD</h3>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form action="{{ route('auth.login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        @if ($errors->has('username'))
                            <label class="control-label" for="inputError"><i class="far fa-times-circle"></i> {{ $errors->first('username') }}</label>
                        @endif
                        <div class="input-group mb-3">
                            <input type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" id="username" name="username" placeholder="Username" value="{{ old('username') }}" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        @if ($errors->has('password'))
                            <label class="control-label" for="inputError"><i class="far fa-times-circle"></i> {{ $errors->first('password') }}</label>
                        @endif
                        <div class="input-group mb-3">
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="Password" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            Remember Me
                        </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                    </div>
                </form>
                <p class="mt-3">
                    {{--  <a href="#">I forgot my password</a>  --}}
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

</body>

</html>