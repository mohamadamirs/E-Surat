@extends('layouts.app')
@section('title', 'Disposisi Surat')
@section('page-title', 'Daftar Disposisi Surat  ')

{{-- Menambahkan Stylesheet untuk DataTables --}}
@section('styles')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Menunggu Validasi Anda</h3>
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

            {{-- Menggunakan struktur tabel yang sama seperti di halaman admin --}}
            <table id="main-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No. Surat Masuk</th>
                        <th>Perihal Surat</th>
                        <th>Pengirim Surat</th>
                        <th>Dikirim Oleh (Sekretaris)</th>
                        <th>Tanggal Disposisi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($disposisiList as $disposisi)
                        <tr>
                            <td>{{ $disposisi->suratMasuk->nomor_surat }}</td>
                            <td>{{ $disposisi->suratMasuk->perihal }}</td>
                            <td>{{ $disposisi->suratMasuk->pengirim }}</td>
                            <td>{{ $disposisi->sekretaris->name }}</td>
                            <td>{{ $disposisi->created_at->format('d M Y H:i') }}</td>
                            <td class="text-center">
                                {{-- KUNCI UTAMA: Hanya ada satu tombol aksi, yaitu "Detail" --}}
                                {{-- Link ini akan mengarahkan ke halaman detail surat masuk yang sama dengan yang dilihat sekretaris --}}
                                <a href="{{ route('kepala.validasi.show', $disposisi->id_surat_masuk) }}"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail & Validasi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            {{-- Ganti colspan sesuai jumlah kolom baru (6) --}}
                            <td colspan="6" class="text-center">Tidak ada disposisi yang menunggu persetujuan Anda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

{{-- Menambahkan Scripts untuk DataTables --}}
@section('scripts')
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    {{-- Script untuk inisialisasi DataTables --}}
    <script>
        $(document).ready(function() {
            $('#main-table').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "searching": true,
                "ordering": true,
                "order": [
                    [4, "desc"]
                ] // Mengurutkan berdasarkan kolom ke-5 (Tanggal Disposisi) dari yang terbaru
            });
        });
    </script>
@endsection
