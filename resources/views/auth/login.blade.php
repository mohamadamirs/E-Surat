<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Surat | Log in</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    
    {{-- <link rel="icon" id="favicon" href="URL_ANDA/favicon.svg" type="image/svg+xml"> --}}

    <style>
        /* Mengadaptasi gaya dari halaman Welcome */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
        }

        .login-box {
            animation: fadeIn 0.7s ease-in-out;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 15px 40px rgba(0, 73, 153, 0.1);
        }

        .login-card-body {
            padding: 2.5rem;
        }

        .login-logo img {
            width: 70px;
            height: auto;
            filter: drop-shadow(0 4px 10px rgba(0, 73, 153, 0.15));
            margin-bottom: 1rem;
        }

        .login-logo a {
            font-size: 1.75rem;
            font-weight: 800;
            color: #004999;
            letter-spacing: -1.5px;
        }

        .login-box-msg {
            color: #555;
            font-size: 1rem;
            margin-top: -1rem;
            margin-bottom: 2rem;
        }

        .btn-custom {
            border-radius: 0.5rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            padding: 0.75rem 0; /* Padding disesuaikan untuk btn-block */
            transition: all 0.2s ease-in-out;
            border: 2px solid transparent;
        }

        .btn-primary.btn-custom {
            background-color: #004999;
            border-color: #004999;
        }

        .btn-primary.btn-custom:hover {
            background-color: #003b7a;
            border-color: #003b7a;
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(0, 73, 153, 0.2);
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">

                <div class="login-logo text-center">
                    <img src="https://img.icons8.com/fluency/96/000000/mail.png" alt="E-Surat Logo">
                    <a href="/"><b>E-</b>Surat</a>
                </div>

                <p class="login-box-msg text-center">Selamat datang kembali</p>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{ old('email') }}" required autofocus>
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

                    <div class="input-group mb-3">
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password"
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

                    <div class="row mt-4">
                        <div class="col-8 d-flex align-items-center">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block btn-custom">Masuk</button>
                        </div>
                    </div>
                    </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
</body>
</html>