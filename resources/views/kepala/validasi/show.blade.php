@extends('layouts.app')
@section('title', 'Detail & Validasi Surat')
@section('page-title', 'Detail & Validasi Disposisi')

@section('content')
<div class="row">
    {{-- Kolom Kiri: Detail Surat & Riwayat Disposisi --}}
    <div class="col-md-8">
        <!-- Card Detail Surat -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Informasi Surat</h3>
                <div class="card-tools">
                    <a href="{{ route('kepala.validasi.index') }}" class="btn btn-tool" title="Kembali ke Daftar Validasi">
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
                </ul>
                <a href="{{ asset('storage/' . $suratMasuk->file_dokumen) }}" target="_blank" class="btn btn-primary btn-block"><i class="fas fa-file-alt mr-2"></i><b>Lihat Dokumen Asli</b></a>
            </div>
        </div>

        <!-- Card Riwayat Disposisi -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Riwayat Disposisi Surat Ini</h3>
            </div>
            <div class="card-body">
                @forelse ($suratMasuk->disposisi as $item)
                    <div class="post clearfix">
                        <div class="user-block">
                            <span class="username ml-0">{{ $item->sekretaris->name }} <i class="fas fa-long-arrow-alt-right mx-2"></i> 
                                @if ($item->kepala) {{ $item->kepala->name }} @else <span class="text-muted">(Belum Ditentukan)</span> @endif
                            </span>
                            <span class="description ml-0">Dikirim pada - {{ $item->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <p class="mt-2">{{ $item->catatan }}</p>
                        <p>
                           Status: 
                           @if($item->status_validasi == 'Menunggu') <span class="badge badge-warning">Menunggu</span>
                           @elseif($item->status_validasi == 'Disetujui') <span class="badge badge-success">Disetujui</span>
                           @elseif($item->status_validasi == 'Ditolak') <span class="badge badge-danger">Ditolak</span>
                           @elseif($item->status_validasi == 'Revisi') <span class="badge badge-info">Perlu Revisi</span>
                           @endif
                        </p>
                    </div>
                @empty
                    <p class="text-center">Belum ada disposisi untuk surat ini.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Panel Aksi Validasi (INI VERSI YANG SUDAH DIGABUNG DAN BENAR) --}}
    <div class="col-md-4">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Aksi Validasi Anda</h3>
            </div>
            <div class="card-body text-center">
                {{-- Cari disposisi relevan yang menunggu validasi --}}
                @php
                    $disposisiUntukValidasi = $suratMasuk->disposisi->where('id_kepala', Auth::id())->where('status_validasi', 'Menunggu')->first();
                @endphp

                @if($disposisiUntukValidasi)
                    <p>Silakan setujui, tolak, atau minta revisi untuk disposisi ini.</p>
                    
                    {{-- Tombol Setujui --}}
                    <form action="{{ route('kepala.validasi.approve', $disposisiUntukValidasi->id) }}" method="POST" class="d-inline-block">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-success">Setujui</button>
                    </form>

                    {{-- Tombol Tolak --}}
                    <form action="{{ route('kepala.validasi.reject', $disposisiUntukValidasi->id) }}" method="POST" class="d-inline-block">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </form>
                    
                    {{-- Tombol Revisi (Memicu Modal) --}}
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#revisi-modal">Revisi</button>
                @else
                    <p class="text-muted">Anda sudah melakukan validasi untuk surat ini.</p>
                @endif
            </div>
        </div>
    </div>
</div> {{-- Penutup untuk <div class="row"> --}}

{{-- Modal untuk form revisi (Hanya dibuat jika ada disposisi yang bisa direvisi) --}}
@if(isset($disposisiUntukValidasi))
<div class="modal fade" id="revisi-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('kepala.validasi.revise', $disposisiUntukValidasi->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Form Instruksi Revisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tuliskan catatan atau instruksi perbaikan untuk sekretaris.</p>
                    <div class="form-group">
                        <label for="catatan_revisi">Catatan Revisi</label>
                        <textarea name="catatan_revisi" class="form-control @error('catatan_revisi') is-invalid @enderror" rows="5" required minlength="10">{{ old('catatan_revisi') }}</textarea>
                        @error('catatan_revisi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Kirim Instruksi Revisi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection {{-- Ini adalah @endsection yang benar untuk menutup @section('content') --}}


{{-- Bagian JavaScript --}}
@section('scripts')
{{-- PERBAIKAN: Struktur @if dipindahkan ke dalam @section --}}
<script>
    $(document).ready(function() {
        // Jika terjadi error validasi pada form revisi, buka kembali modalnya secara otomatis
        @if($errors->has('catatan_revisi'))
            $('#revisi-modal').modal('show');
        @endif
    });
</script>
@endsection