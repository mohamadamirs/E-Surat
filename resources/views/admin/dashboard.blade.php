@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Administrator')

@section('content')
    {{-- ====================================================================== --}}
    {{--              BAGIAN 1: RINGKASAN DATA KESELURUHAN SISTEM               --}}
    {{-- ====================================================================== --}}
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalPengguna }}</h3>
                    <p>Total Akun Pengguna</p>
                </div>
                <div class="icon"><i class="fas fa-users-cog"></i></div>
                <a href="{{ route('admin.dashboard') }}" class="small-box-footer">Kelola Pengguna <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalSuratMasuk }}</h3>
                    <p>Total Arsip Surat Masuk</p>
                </div>
                <div class="icon"><i class="fas fa-inbox"></i></div>
                <p class="small-box-footer">Arsip Surat Masuk</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalSuratKeluar }}</h3>
                    <p>Total Arsip Surat Keluar</p>
                </div>
                <div class="icon"><i class="fas fa-paper-plane"></i></div>
                <p class="small-box-footer">Arsip Surat Keluar</p>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- ====================================================================== --}}
        {{--             BAGIAN 2: PUSAT PENGELOLAAN PENGGUNA                     --}}
        {{-- ====================================================================== --}}
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-shield mr-1"></i>
                        Pusat Pengelolaan Pengguna
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        {{-- Rincian Peran Pengguna --}}
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $jumlahAdmin }}</h5>
                                        <span class="description-text">ADMINISTRATOR</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $jumlahKepala }}</h5>
                                        <span class="description-text">KEPALA</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $jumlahSekretaris }}</h5>
                                        <span class="description-text">SEKRETARIS</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Tombol Aksi Utama --}}
                        <div class="col-md-4 mt-3 mt-md-0">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-lg btn-primary btn-block">
                                <i class="fas fa-cogs mr-2"></i> Kelola Semua Akun
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- ====================================================================== --}}
        {{--          BAGIAN 3: TABEL PENGGUNA YANG BARU DITAMBAHKAN                --}}
        {{-- ====================================================================== --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-clock mr-1"></i> Aktivitas Pengguna Terbaru</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Nama Pengguna</th>
                                <th>Email</th>
                                <th>Peran</th>
                                <th>Waktu Bergabung</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penggunaTerbaru as $user)
                                <tr>
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
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center p-4">
                                        Belum ada pengguna baru yang ditambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
