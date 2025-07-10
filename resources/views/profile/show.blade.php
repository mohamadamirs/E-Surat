@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Pengguna')

@section('content')
<div class="row">
    {{-- Kolom Kiri: Detail Profil --}}
    <div class="col-md-5">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    @if (Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="profile-user-img img-fluid img-circle" style="width: 100px; height: 100px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/profile.svg') }}" alt="Default Profile Picture" class="profile-user-img img-fluid img-circle">
                    @endif
                </div>
                <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                <p class="text-muted text-center text-capitalize">Supervisor / {{ Auth::user()->role }} </p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right">{{ Auth::user()->email }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Bergabung Sejak</b> <a class="float-right">{{ Auth::user()->created_at->format('d M Y') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Panel Aksi --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pengaturan Akun</h3>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        @if (session('status') === 'profile-updated')
                            Informasi profil berhasil diperbarui.
                        @elseif (session('status') === 'password-updated')
                             Password berhasil diperbarui.
                        @endif
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif
                
                <p>Pengaturan untuk mengelola informasi akun Anda.</p>

                {{-- Tombol-tombol Aksi dengan data-url untuk AJAX --}}
                <button type="button" class="btn btn-primary btn-modal" data-url="{{ route('profile.partials.info') }}">
                    <i class="fas fa-edit mr-1"></i> Edit Informasi Profil
                </button>
                <button type="button" class="btn btn-warning btn-modal" data-url="{{ route('profile.partials.password') }}">
                    <i class="fas fa-key mr-1"></i> Ubah Password
                </button>
                <button type="button" class="btn btn-danger" id="open-delete-modal">
                    <i class="fas fa-trash mr-1"></i> Hapus Akun
                </button>
            </div>
        </div>
    </div>
</div>

{{-- 1. Modal Universal untuk memuat form via AJAX --}}
<div class="modal fade" id="main-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {{-- Konten akan dimuat di sini oleh JavaScript --}}
        </div>
    </div>
</div>

{{-- 2. Modal Khusus untuk Konfirmasi Hapus Akun --}}
<div class="modal fade" id="delete-confirm-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Akun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin? Setelah akun dihapus, semua data akan hilang selamanya.</p>
                <p class="text-danger">Masukkan password Anda untuk mengonfirmasi tindakan ini.</p>
                
                <form id="delete-user-form" action="{{ route('profile.destroy') }}" method="POST">
                    @csrf
                    @method('delete')
                    <div class="form-group">
                        <label for="password_delete" class="sr-only">Password</label>
                        <input type="password" name="password" id="password_delete" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="Password..." required>
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                {{-- Tombol ini akan men-submit form yang ada di modal-body --}}
                <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-user-form').submit();">Ya, Hapus Akun Saya</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Handler untuk tombol yang memuat konten via AJAX
    $('.btn-modal').on('click', function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        const modalContent = $('#main-modal .modal-content');
        
        // Kosongkan konten dan tampilkan modal
        modalContent.html('');
        $('#main-modal').modal('show');
        
        // Tampilkan loading spinner
        modalContent.html('<div class="modal-body text-center"><i class="fas fa-spinner fa-spin fa-3x"></i><p>Loading...</p></div>');
        
        // Ambil konten dari server
        $.get(url, function(response) {
            modalContent.html(response);
        }).fail(function() {
            modalContent.html('<div class="modal-body"><div class="alert alert-danger">Gagal memuat konten. Silakan coba lagi.</div></div>');
        });
    });

    // Handler untuk tombol pemicu modal hapus
    $('#open-delete-modal').on('click', function() {
        $('#delete-confirm-modal').modal('show');
    });

    // Jika ada error validasi saat hapus user, otomatis buka kembali modalnya
    @if($errors->userDeletion->isNotEmpty())
        $('#delete-confirm-modal').modal('show');
    @endif
});

// Script untuk menampilkan nama file di input file-upload
$('body').on('change', '.custom-file-input', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
});
</script>
@endpush