{{-- resources/views/kepala/surat_keluar/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Melihat Surat Keluar')
@section('page-title', 'Daftar Surat Keluar')

@section('styles')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Arsip Data Surat Keluar</h3>
        {{-- Tombol "Tambah" tidak ada untuk kepala --}}
    </div>
    <div class="card-body">
        <table id="main-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No. Surat</th>
                    <th>Tujuan</th>
                    <th>Perihal</th>
                    <th>Dibuat Oleh</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suratKeluarList as $surat)
                <tr>
                    <td>{{ $surat->nomor_surat_keluar }}</td>
                    <td>{{ $surat->tujuan }}</td>
                    <td>{{ $surat->perihal }}</td>
                    <td>{{ $surat->pengelola->name }}</td>
                    <td class="text-center">
                        {{-- HANYA ADA TOMBOL DETAIL --}}
                        <a href="{{ route('kepala.surat-keluar.show', $surat->id) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data surat keluar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
    {{-- Script untuk DataTables --}}
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#main-table').DataTable({"responsive": true, "lengthChange": true, "autoWidth": false, "order": []});
        });
    </script>
@endsection