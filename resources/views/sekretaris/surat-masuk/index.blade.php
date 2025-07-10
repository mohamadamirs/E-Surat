@extends('layouts.app')
@section('title', 'Kelola Surat Masuk')
{{-- menambahkan style khusus dengan @push --}}
@push('styles')

    <style>
        #main-table {
            table-layout: fixed;
            width: 100%;
        }

        #main-table td,
        #main-table th {
            word-wrap: break-word;
        }
    </style>
@endpush

{{-- Bagian Konten Utama --}}
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Surat Masuk</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm btn-modal"
                    data-url="{{ route('sekretaris.surat-masuk.create') }}">
                    <i class="fas fa-plus"></i> Tambah Surat Masuk
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

            <table id="main-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No. Surat</th>
                        <th>Perihal</th>
                        <th>Pengirim</th>
                        <th>Tgl. Diterima</th>
                        <th>Pengelola</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- gunakan foreeach untuk melakukan pengulangan data --}}
                    @foreach ($suratMasukList as $surat)
                        <tr>
                            <td>{{ $surat->nomor_surat }}</td>
                            <td>{{ $surat->perihal }}</td>
                            <td>{{ $surat->pengirim }}</td>
                            <td>{{ \Carbon\Carbon::parse($surat->tanggal_diterima)->format('d M Y') }}</td>
                            <td>{{ $surat->pengelola->name }}</td>
                            <td>
                                <a href="{{ route('sekretaris.surat-masuk.show', $surat->id) }}"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>

                                @if (auth()->user()->role == 'sekretaris')
                                {{-- Tombol Edit memanggil modal AJAX --}}
                                <button type="button" class="btn btn-warning btn-sm btn-modal"
                                    data-url="{{ route('sekretaris.surat-masuk.edit', $surat->id) }}">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </button>

                                <button class="btn btn-danger btn-sm" onclick="deleteConfirmation({{ $surat->id }})">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                                {{-- FORM DELETE SURAT MASUK DISPLAY NONE --}}
                                <form id="delete-form-{{ $surat->id }}" action="{{ route('sekretaris.surat-masuk.destroy', $surat->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')

                                @endif  
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- "WADAH" MODAL KOSONG --}}
    <div class="modal fade" id="main-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                {{-- Konten form ada dis ini --}}
            </div>
        </div>
    </div>
@endsection

{{-- Bagian JavaScript --}}
@push('scripts')
    <script>
        @include('partials.main')
    </script>
@endpush
