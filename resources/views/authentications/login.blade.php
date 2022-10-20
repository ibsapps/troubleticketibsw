<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{!! asset('assets/plugins/fontawesome-free/css/all.min.css') !!}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{!! asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{!! asset('assets/dist/css/adminlte.min.css') !!}">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="{{ url('/') }}" class="h2">
          <img src="{!! asset('assets/images/IBS.png') !!}" alt="IBS Logo" class="brand-image img-circle elevation-3" height="35" style="text-align: center;"> IBS</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg"><b>Sign in to start your session</b></p>
        @if(session()->has('Error'))
        <div class="alert alert-danger" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {{ session('Error') }}
        </div>
        @endif
        <form action="{{ url('/login') }}" method="POST">
          @csrf
          <div class="form-group">
            <input type="email" class="form-control" placeholder="Email" id="email" name="email" value="{{ old('email') }}" autofocus required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <!-- /.social-auth-links -->

        <!--<p class="lg-1">
          <a href="forgot-password.html">Forgot password ?</a>
        </p>
      </div>-->
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.login-box -->

</html>