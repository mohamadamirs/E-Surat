@extends('layouts.app')

{{-- Judul Halaman --}}
@section('title', 'Kelola Pengguna')
@section('page-title', 'Daftar Pengguna')

{{-- Menambahkan stylesheet kustom untuk halaman ini --}}
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.css" />
    <style>
        .iti {
            width: 100%;
        }

        .iti .form-control {
            width: 100%;
        }
    </style>
@endpush

{{-- Konten Utama --}}
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tabel Data Pengguna</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm btn-modal" data-url="{{ route('admin.users.create') }}">
                    <i class="fas fa-plus"></i> Tambah Pengguna
                </button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif

            <table id="main-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Nomer Hp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->role == 'admin')
                                    <span class="badge badge-danger">Admin</span>
                                @elseif ($user->role == 'kepala')
                                    <span class="badge badge-success">Kepala</span>
                                @else
                                    <span class="badge badge-info">Sekretaris</span>
                                @endif
                            </td>
                            <td>{{ $user->nomer_hp }}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm btn-modal"
                                    data-url="{{ route('admin.users.edit', $user->id) }}">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteConfirmation({{ $user->id }})">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                                <form id="delete-form-{{ $user->id }}"
                                    action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    {{-- Struktur Modal Universal (gunakan modal-lg) --}}
    <div class="modal fade" id="main-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                {{-- Konten AJAX akan dimuat di sini --}}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Memuat library intl-tel-input --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    <script>
        // Fungsi untuk inisialisasi intl-tel-input
        function initializeIntlTelInput(selector) {
            const input = document.querySelector(selector);
            if (input) {
                window.iti = window.intlTelInput(input, {
                    separateDialCode: true,
                    preferredCountries: ["id"],
                    initialCountry: "id",
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
                });
            }
        }

            $(document).ready(function() {
                // Inisialisasi DataTables dengan pagination bawaan DataTables
                $("#main-table").DataTable({
                    "paging": true,
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "order": [],
                });
            // Event handler untuk memicu Modal
            $('body').on('click', '.btn-modal', function(e) {
                e.preventDefault();
                const url = $(this).data('url');
                $('#main-modal .modal-content').load(url, function(response, status, xhr) {
                    if (status == "success") {
                        $('#main-modal').modal('show');
                        initializeIntlTelInput("#mobile_code");
                    } else {
                        alert("Gagal memuat konten. Silakan coba lagi.");
                    }
                });
            });
            // Event listener untuk submit form DI DALAM modal
            $('body').on('submit', '#main-modal form', function() {
                if (window.iti) {
                    const fullNumber = window.iti.getNumber(); // Hasil: "+62..."
                    const numberWithoutPlus = fullNumber.replace('+', ''); // Hasil: "62..."
                    $("#nomer_hp").val(numberWithoutPlus); // Simpan nomor bersih
                }
                return true;
            });
        });
        // Fungsi untuk Konfirmasi Hapus
        function deleteConfirmation(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endpush
