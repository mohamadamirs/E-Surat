@extends('layouts.app')
@section('title', 'Kelola Surat Keluar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Surat Keluar</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm btn-modal"
                    data-url="{{ route('sekretaris.surat-keluar.create') }}">
                    <i class="fas fa-plus"></i> Tambah Surat Keluar
                </button>
            </div>
        </div>
        <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <table id="main-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No. Surat</th>
                    <th>Tujuan</th>
                    <th>Perihal</th>
                    <th>Dokumen</th>
                    @if(auth()->user->role == 'sekretaris')
                    <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($suratKeluarList as $surat)
                <tr>
                    <td>{{ $surat->nomor_surat_keluar }}</td>
                    <td>{{ $surat->tujuan }}</td>
                    <td>{{ $surat->perihal }}</td>
                    <td class="text-center">
                        {{-- upload dokumen --}}
                        <a href="{{ asset('storage/' . $surat->file_dokumen) }}" target="_blank" class="btn btn-light btn-sm">
                            <i class="fas fa-file-pdf text-danger"></i> Lihat
                        </a>
                    </td>
                    <td>
                        {{-- Tombol Edit dan Hapus --}}
                        <button type="button" class="btn btn-warning btn-sm btn-modal" data-url="{{ route('sekretaris.surat-keluar.edit', $surat->id) }}">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteConfirmation({{ $surat->id }})">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                        <form id="delete-form-{{ $surat->id }}" action="{{ route('sekretaris.surat-keluar.destroy', $surat->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
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
                {{-- Konten form akan dimuat di sini oleh AJAX --}}
            </div>
        </div>
    </div>
@endsection

{{-- Bagian JavaScript --}}
@push('scripts')
<script>
    // Memanggil semua logika dari file partial
    @include('partials.main')
</script>
@endpush