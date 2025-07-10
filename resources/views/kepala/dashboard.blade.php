@extends('layouts.app')

@section('title', 'Dashboard Kepala')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    {{-- Info Box --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $menungguValidasi }}</h3>
                <p>Menunggu Validasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('kepala.validasi.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $disetujui }}</h3>
                <p>Disposisi Disetujui</p>
            </div>
            <div class="icon">
                <i class="fas fa-check"></i>
            </div>
            <a href="{{ route('kepala.riwayat.index') }}" class="small-box-footer">Lihat Riwayat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $ditolak }}</h3>
                <p>Disposisi Ditolak</p>
            </div>
            <div class="icon">
                <i class="fas fa-times"></i>
            </div>
            <a href="{{ route('kepala.riwayat.index') }}" class="small-box-footer">Lihat Riwayat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $revisi }}</h3>
                <p>Disposisi Direvisi</p>
            </div>
            <div class="icon">
                <i class="fas fa-edit"></i>
            </div>
            <a href="{{ route('kepala.riwayat.index') }}" class="small-box-footer">Lihat Riwayat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    {{-- Kolom Kiri: Daftar Disposisi Mendesak --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Disposisi Terbaru Menunggu Validasi</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>No. Surat</th>
                                <th>Perihal</th>
                                <th>Dari (Sekretaris)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($disposisiMendesak as $item)
                            <tr>
                                <td>{{ $item->suratMasuk->nomor_surat }}</td>
                                <td>{{ Str::limit($item->suratMasuk->perihal, 35) }}</td>
                                <td><span class="badge badge-secondary">{{ $item->sekretaris->name }}</span></td>
                                <td>
                                    <a href="{{ route('kepala.validasi.show', $item->id_surat_masuk) }}" class="btn btn-sm btn-info">Detail & Validasi</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    <i class="fas fa-check-circle text-success my-2"></i><br>
                                    Pekerjaan bagus! Tidak ada disposisi yang menunggu.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                <a href="{{ route('kepala.validasi.index') }}" class="btn btn-primary float-right">Lihat Semua Persetujuan</a>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Aktivitas Validasi Terakhir --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Aktivitas Validasi Terakhir Anda</h3>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    @forelse ($aktivitasTerakhir as $item)
                    <li class="item">
                        <div class="product-info">
                            <a href="{{ route('kepala.validasi.show', $item->id_surat_masuk) }}" class="product-title">
                                No. Surat: {{ $item->suratMasuk->nomor_surat }}
                                @if($item->status_validasi == 'Disetujui') <span class="badge badge-success float-right">Disetujui</span>
                                @elseif($item->status_validasi == 'Ditolak') <span class="badge badge-danger float-right">Ditolak</span>
                                @elseif($item->status_validasi == 'Revisi') <span class="badge badge-info float-right">Revisi</span>
                                @endif
                            </a>
                            <span class="product-description">
                                Divalidasi pada {{ $item->tanggal_validasi ? \Carbon\Carbon::parse($item->tanggal_validasi)->diffForHumans() : '-' }}
                            </span>
                        </div>
                    </li>
                    @empty
                    <li class="item text-center">Belum ada riwayat aktivitas.</li>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('kepala.riwayat.index') }}" class="uppercase">Lihat Semua Riwayat</a>
            </div>
        </div>
    </div>
</div>
@endsection