<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UPT SIT Register</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css?v=3.2.0') }}">
</head>

<body class="hold-transition login-page">

  @include('sweetalert::alert')

  <div class="login-box">
    <div class="login-logo">
      <a href="{{ url('/') }}"><b>IT</b>BHAMADA</a>
    </div>
    @if (session('error'))
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5>
          <i class="icon fas fa-ban"></i> Gagal!
        </h5>
        @foreach (session('error') as $error)
          - {{ $error }} <br>
        @endforeach
      </div>
    @endif
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Isi form dengan benar</p>
        <form action="{{ url('register') }}" method="post" autocomplete="off">
          @csrf
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap"
              value="{{ old('nama') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Jabatan"
              value="{{ old('jabatan') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="email" name="email" placeholder="Email Institusi"
              value="{{ old('email') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-2">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password"
              value="{{ old('password') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="form-check mb-5">
            <input type="checkbox" class="form-check-input" id="password_show" onclick="show()">
            <label class="form-check-label" for="password_show">Lihat Password</label>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        </form>
        <div class="text-center mt-2">
          <a href="{{ url('login') }}" class="text-center">Sudah punya akun? Masuk</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    var password = document.getElementById('password');
    var password_show = document.getElementById('password_show');

    function show() {
      if (password.type === 'password') {
        password.type = 'text';
      } else {
        password.type = 'password';
      }
    }
  </script>

  <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('adminlte/dist/js/adminlte.min.js?v=3.2.0') }}"></script>
</body>

</html>
