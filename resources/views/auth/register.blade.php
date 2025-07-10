<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Surat | Registrasi</title>

    <!-- Google Font: Source Sans Pro -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}"> --}}
    <!-- icheck bootstrap -->
    {{-- <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
     <!-- Favicon -->
    <link rel="icon" id="favicon" href="{{ asset('images/favicon.svg') }}" type="image/svg+xml">
    <style>
        .register-page {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
    </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="/" class="h1"><b>E-</b>Surat</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Daftar untuk membuat akun baru</p>

            <form action="{{ route('register') }}" method="post">
                @csrf

                <!-- Input Nama Lengkap -->
                <div class="input-group mb-3">
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Nama Lengkap"
                           value="{{ old('name') }}"
                           required
                           autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Input Email -->
                <div class="input-group mb-3">
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email"
                           value="{{ old('email') }}"
                           required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Input Password -->
                <div class="input-group mb-3">
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password"
                           required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Input Konfirmasi Password -->
                <div class="input-group mb-3">
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Ulangi Password"
                           required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        {{-- Bisa ditambahkan checkbox untuk 'Terms & Conditions' di sini jika perlu --}}
                        {{-- <div class="icheck-primary">
                          <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                          <label for="agreeTerms">
                           Saya setuju dengan <a href="#">ketentuan</a>
                          </label>
                        </div> --}}
                    </div>
                    <!-- /.col -->
                </div>
                
                <div class="mt-3 mb-3">
                     <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                </div>
                
            </form>

            <div class="text-center">
                 <a href="{{ route('login') }}" class="text-center">Saya sudah punya akun</a>
            </div>
           
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>