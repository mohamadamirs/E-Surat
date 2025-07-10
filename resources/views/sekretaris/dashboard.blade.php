@extends('layouts.app')

@section('title', 'Dashboard Sekretaris')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    {{-- Info Box --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $jumlahSuratMasuk }}</h3>
                <p>Total Surat Masuk</p>
            </div>
            <div class="icon">
                <i class="fas fa-inbox"></i>
            </div>
            <a href="{{ route('sekretaris.surat-masuk.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $jumlahSuratKeluar }}</h3>
                <p>Total Surat Keluar</p>
            </div>
            <div class="icon">
                <i class="fas fa-paper-plane"></i>
            </div>
            <a href="{{ route('sekretaris.surat-keluar.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $jumlahDisposisiMenunggu }}</h3>
                <p>Disposisi Menunggu Validasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="#" class="small-box-footer">.</a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $jumlahDisposisiDivalidasi }}</h3>
                <p>Disposisi Sudah Divalidasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-double"></i>
            </div>
            <a href="#" class="small-box-footer">.</a>
        </div>
    </div>
</div>

<div class="row">
    {{-- Kolom Kiri: Surat Masuk Terbaru & Shortcut --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Surat Masuk Terbaru</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>No. Surat</th>
                                <th>Pengirim</th>
                                <th>Perihal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($suratMasukTerbaru as $surat)
                            <tr>
                                <td><a href="{{ route('sekretaris.surat-masuk.show', $surat->id) }}">{{ $surat->nomor_surat }}</a></td>
                                <td>{{ $surat->pengirim }}</td>
                                <td>{{ Str::limit($surat->perihal, 40) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada surat masuk baru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                <button type="button" class="btn btn-primary float-left btn-modal" data-url="{{ route('sekretaris.surat-masuk.create') }}"><i class="fas fa-plus"></i> Tambah Surat Masuk</button>
                <a href="{{ route('sekretaris.surat-masuk.index') }}" class="btn btn-secondary float-right">Lihat Semua Surat Masuk</a>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Disposisi Terakhir --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Aktivitas Disposisi Terakhir</h3>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    @forelse ($disposisiTerbaru as $item)
                    <li class="item">
                        <div class="product-info">
                            <a href="{{ route('sekretaris.surat-masuk.show', $item->id_surat_masuk) }}" class="product-title">
                                No. Surat: {{ $item->suratMasuk->nomor_surat }}
                                @if($item->status_validasi == 'Menunggu') <span class="badge badge-warning float-right">Menunggu</span>
                                @elseif($item->status_validasi == 'Disetujui') <span class="badge badge-success float-right">Disetujui</span>
                                @elseif($item->status_validasi == 'Ditolak') <span class="badge badge-danger float-right">Ditolak</span>
                                @elseif($item->status_validasi == 'Revisi') <span class="badge badge-info float-right">Revisi</span>
                                @endif
                            </a>
                            <span class="product-description">
                                Diteruskan ke {{ $item->kepala->name }} pada {{ $item->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </li>
                    @empty
                    <li class="item text-center">Belum ada aktivitas disposisi.</li>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="javascript:void(0)" class="uppercase">Lihat Semua Aktivitas</a>
            </div>
        </div>
    </div>
</div>

{{-- Modal untuk tombol "Tambah Surat Masuk" --}}
<div class="modal fade" id="main-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Script untuk memuat modal AJAX
    $(document).ready(function() {
        $('body').on('click', '.btn-modal', function() {
            const url = $(this).data('url');
            $('#main-modal .modal-content').load(url, function() {
                $('#main-modal').modal('show');
            });
        });

        $('body').on('change', '.custom-file-input', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>
@endsection