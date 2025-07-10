<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk Info Box
        $jumlahSuratMasuk = SuratMasuk::count();
        $jumlahSuratKeluar = SuratKeluar::count();
        $jumlahDisposisiMenunggu = Disposisi::where('status_validasi', 'Menunggu')->count();
        $jumlahDisposisiDivalidasi = Disposisi::whereIn('status_validasi', ['Disetujui', 'Ditolak', 'Revisi'])->count();

        // Data untuk Tabel Surat Masuk Terbaru
        $suratMasukTerbaru = SuratMasuk::with('pengelola')->latest()->take(5)->get();

        // Data untuk Tabel Disposisi Terbaru
        $disposisiTerbaru = Disposisi::with('suratMasuk', 'kepala')->latest()->take(5)->get();
        
        // Kirim semua data ke view
        return view('sekretaris.dashboard', compact(
            'jumlahSuratMasuk',
            'jumlahSuratKeluar',
            'jumlahDisposisiMenunggu',
            'jumlahDisposisiDivalidasi',
            'suratMasukTerbaru',
            'disposisiTerbaru'
        ));
    }
}