{{-- resources/views/kepala/surat_keluar/show.blade.php --}}
@extends('layouts.app')
@section('title', 'Detail Surat Keluar')
@section('page-title', 'Detail Surat Keluar')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Informasi Surat</h3>
        <div class="card-tools">
            <a href="{{ route('kepala.surat-keluar.index') }}" class="btn btn-tool" title="Kembali ke Daftar">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item"><b>Nomor Surat</b> <span class="float-right">{{ $suratKeluar->nomor_surat_keluar }}</span></li>
            <li class="list-group-item"><b>Tujuan Surat</b> <span class="float-right">{{ $suratKeluar->tujuan }}</span></li>
            <li class="list-group-item"><b>Perihal</b> <span class="float-right">{{ $suratKeluar->perihal }}</span></li>
            <li class="list-group-item"><b>Tanggal Surat</b> <span class="float-right">{{ \Carbon\Carbon::parse($suratKeluar->tanggal_surat)->format('d M Y') }}</span></li>
            <li class="list-group-item"><b>Dibuat oleh</b> <span class="float-right">{{ $suratKeluar->pengelola->name }}</span></li>
        </ul>
        <a href="{{ asset('storage/' . $suratKeluar->file_dokumen) }}" target="_blank" class="btn btn-primary btn-block"><i class="fas fa-file-alt mr-2"></i><b>Lihat Dokumen</b></a>
    </div>
</div>
@endsection