<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar; // Pastikan model di-import
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    /**
     * Menampilkan daftar semua surat keluar.
     */
    public function index()
    {
        // Gunakan Eager Loading 'with('pengelola')' agar lebih cepat 
        $suratKeluarList = SuratKeluar::with('pengelola')->latest()->get();

        // me retutrn view ke halaman index kepala
        return view('kepala.surat-keluar.index', compact('suratKeluarList'));
    }

    public function show(SuratKeluar $suratKeluar)
    {
        // Cukup tampilkan view dengan data surat yang sudah diambil oleh Route Model Binding
        return view('kepala.surat-keluar.show', compact('suratKeluar'));
    }
}