<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di E-Surat</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&display=swap" rel="stylesheet">

    <!-- CSS AdminLTE  -->
    <link href="{{ asset('adminlte/dist/css/adminlte.min.css') }}" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Favicon -->
    <link rel="icon" id="favicon" href="{{ asset('images/favicon.svg') }}" type="image/svg+xml">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
        }

        /* Kelas utama untuk bagian hero */
        .hero-section {
            /* Membuat section memenuhi tinggi layar */
            min-height: 100vh;
            /* Menengahkan konten menggunakan flexbox */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-title {
            font-size: 3.5rem;
            /* Ukuran judul lebih besar */
            font-weight: 800;
            /* Lebih tebal */
            color: #004999;
            /* Warna biru tua yang elegan */
        }

        h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #004999;

            margin-bottom: 2rem; 
        }

        .hero-subtitle {
            font-size: 1.15rem;
            color: #555;
            max-width: 600px;
            /* Batasi lebar subtitle agar mudah dibaca */
            margin-left: auto;
            margin-right: auto;
        }

        .feature-list span {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.7);
            padding: 8px 16px;
            border-radius: 20px;
            margin: 5px;
            font-size: 0.9rem;
            font-weight: 500;
            color: #333;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .btn-custom {
            border-radius: 0.5rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            padding: 0.75rem 2rem;
            transition: all 0.2s ease-in-out;
            border: 2px solid transparent;
        }

        .btn-custom.btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(0, 73, 153, 0.2);
        }

        .btn-custom.btn-outline-secondary:hover {
            background-color: #343a40;
            color: white;
            transform: translateY(-3px);
        }

        /* Style untuk logo */
        .logo-img {
            width: 80px;
            height: auto;
            filter: drop-shadow(0 4px 10px rgba(0, 73, 153, 0.15));
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
                letter-spacing: -1px;
            }

            .hero-subtitle {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    <div class="hero-section">

        <div class="container text-center px-4">

            <!-- Logo -->
            <img src="https://img.icons8.com/fluency/96/000000/mail.png" alt="E-Surat Logo" class="mb-4 logo-img">

            <!-- Judul Utama -->
            <h1 class="hero-title mb-3">Selamat Datang di E-Surat</h1>
            <h2>Smk karya Bhakti Brebes</h2>

            <!-- Deskripsi -->
            <p class="hero-subtitle mb-5">
                Platform digital untuk mengelola surat-menyurat dengan efisien, aman, dan modern.
            </p>

            <!-- Daftar Fitur -->
            <div class="feature-list mb-5">
                <span><i class="fas fa-inbox mr-2"></i>Surat Masuk & Keluar</span>
                <span><i class="fas fa-share-square mr-2"></i>Disposisi Digital</span>
                <span><i class="fas fa-search mr-2"></i>Pelacakan Arsip</span>
                <span><i class="fas fa-shield-alt mr-2"></i>Keamanan Data</span>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-center flex-wrap">
                <a href="{{ route('login') }}" class="btn btn-primary btn-custom mx-2 my-2">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk Aplikasi
                </a>
            </div>

            <!-- Footer kecil -->
            <div class="mt-5 pt-4">
                <p class="text-muted small">Dikembangkan oleh <b class="text-dark">Software Enthusiast</b></p>
            </div>

        </div>
    </div>

    <!-- Script -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
