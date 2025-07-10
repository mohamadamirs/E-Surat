<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk Info Box
        $totalPengguna = User::count();
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        
        // Data untuk Rincian Peran
        $jumlahAdmin = User::where('role', 'admin')->count();
        $jumlahKepala = User::where('role', 'kepala')->count();
        $jumlahSekretaris = User::where('role', 'sekretaris')->count();

        // Data untuk Tabel Pengguna Terbaru
        $penggunaTerbaru = User::latest()->take(8)->get();

        // Kirim semua data ke view
        return view('admin.dashboard', compact(
            'totalPengguna',
            'totalSuratMasuk',
            'totalSuratKeluar',
            'jumlahAdmin',
            'jumlahKepala',
            'jumlahSekretaris',
            'penggunaTerbaru'
        ));
    }
}