@extends('layouts.app')
@section('title', 'Detail Surat Masuk')
@section('page-title', 'Detail Surat Masuk')

@section('content')
<div class="row">
    {{-- Kolom Kiri detail Surat & Riwayat Disposisi --}}
    <div class="col-md-8">
        <!-- Card Detail Surat -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Informasi Surat</h3>
                {{-- Menambahkan tombol kembali untuk UX yang lebih baik --}}
                <div class="card-tools">
                    <a href="{{ route('sekretaris.surat-masuk.index') }}" class="btn btn-tool" title="Kembali ke Daftar">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item"><b>Nomor Surat</b> <span class="float-right">{{ $suratMasuk->nomor_surat }}</span></li>
                    <li class="list-group-item"><b>Perihal</b> <span class="float-right">{{ $suratMasuk->perihal }}</span></li>
                    <li class="list-group-item"><b>Pengirim</b> <span class="float-right">{{ $suratMasuk->pengirim }}</span></li>
                    <li class="list-group-item"><b>Tanggal Diterima</b> <span class="float-right">{{ \Carbon\Carbon::parse($suratMasuk->tanggal_diterima)->format('d M Y') }}</span></li>
                    <li class="list-group-item"><b>Dikelola oleh</b> <span class="float-right">{{ $suratMasuk->pengelola->name }}</span></li>
                </ul>
                <a href="{{ asset('storage/' . $suratMasuk->file_dokumen) }}" target="_blank" class="btn btn-primary btn-block"><i class="fas fa-file-alt mr-2"></i><b>Lihat Dokumen Surat</b></a>
            </div>
        </div>

        <!-- Card Riwayat Disposisi -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Riwayat Disposisi</h3>
            </div>
            <div class="card-body">
                @forelse ($suratMasuk->disposisi as $item)
                    <div class="post clearfix">
                        <div class="user-block">
                            <span class="username ml-0">
                                {{ $item->sekretaris->name }} <i class="fas fa-long-arrow-alt-right mx-2"></i>
                                @if($item->kepala) {{ $item->kepala->name }} @else <span class="text-muted">(Belum ada)</span> @endif
                            </span>
                            <span class="description ml-0">Dikirim pada - {{ $item->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <p class="mt-2">{{ $item->catatan }}</p>
                        <p>
                            Status:
                            @if ($item->status_validasi == 'Menunggu') <span class="badge badge-warning">Menunggu</span>
                            @elseif($item->status_validasi == 'Disetujui') <span class="badge badge-success">Disetujui</span>
                            @elseif($item->status_validasi == 'Ditolak') <span class="badge badge-danger">Ditolak</span>
                            @elseif($item->status_validasi == 'Revisi') <span class="badge badge-info">Perlu Revisi</span>
                            @endif
                        </p>
                        @if ($item->catatan_revisi)
                            <div class="alert alert-info mt-2">
                                <strong>Catatan Revisi dari {{ $item->kepala->name }}:</strong><br>
                                {{ $item->catatan_revisi }}
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-center">Belum ada disposisi untuk surat ini.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Form Tambah Disposisi (Sekarang HANYA untuk Sekretaris) --}}
    {{-- PERBAIKAN #1: Mengubah kondisi agar hanya sekretaris yang bisa melihat form ini --}}
    @if(Auth::user()->role == 'sekretaris')
    <div class="col-md-4">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Tambah Disposisi Baru</h3>
            </div>
            {{-- PERBAIKAN #2: Mengubah action route menjadi 'sekretaris.disposisi.store' --}}
            <form action="{{ route('sekretaris.disposisi.store', $suratMasuk->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="id_kepala">Teruskan Kepada (Kepala)</label>
                        {{-- PERBAIKAN #3: Mengubah nama input menjadi 'id_kepala' agar cocok dengan controller --}}
                        <select name="id_kepala" id="id_kepala" class="form-control @error('id_kepala') is-invalid @enderror" required>
                            <option value="">-- Pilih Kepala --</option>
                            @foreach ($kepalaList as $kepala)
                                <option value="{{ $kepala->id }}" {{ old('id_kepala') == $kepala->id ? 'selected' : '' }}>{{ $kepala->name }}</option>
                            @endforeach
                        </select>
                        @error('id_kepala') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="catatan">Catatan / Instruksi</label>
                        <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="5" required>{{ old('catatan') }}</textarea>
                        @error('catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info btn-block">Kirim Disposisi</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection