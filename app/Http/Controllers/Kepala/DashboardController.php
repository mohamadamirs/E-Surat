<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        // 1. Data untuk Info Box
        $menungguValidasi = Disposisi::where('id_kepala', $userId)->where('status_validasi', 'Menunggu')->count();
        $disetujui = Disposisi::where('id_kepala', $userId)->where('status_validasi', 'Disetujui')->count();
        $ditolak = Disposisi::where('id_kepala', $userId)->where('status_validasi', 'Ditolak')->count();
        $revisi = Disposisi::where('id_kepala', $userId)->where('status_validasi', 'Revisi')->count();
        // 2. Data untuk Tabel Disposisi Mendesak
        $disposisiMendesak = Disposisi::with('suratMasuk', 'sekretaris')
            ->where('id_kepala', $userId)
            ->where('status_validasi', 'Menunggu')
            ->latest()
            ->take(5)
            ->get();
        // 3. Data untuk Aktivitas Validasi Terakhir
        $aktivitasTerakhir = Disposisi::with('suratMasuk', 'sekretaris')
            ->where('id_kepala', $userId)
            ->whereIn('status_validasi', ['Disetujui', 'Ditolak', 'Revisi'])
            ->orderBy('tanggal_validasi', 'desc')
            ->take(5)
            ->get();
        return view('kepala.dashboard', compact(
            'menungguValidasi',
            'disetujui',
            'ditolak',
            'revisi',
            'disposisiMendesak',
            'aktivitasTerakhir'
        ));
    }
}