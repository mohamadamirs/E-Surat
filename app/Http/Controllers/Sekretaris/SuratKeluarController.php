<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar; // Ganti modelnya
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    /**
     * READ: Menampilkan daftar surat keluar.
     */
    public function index()
    {
        $suratKeluarList = SuratKeluar::with('pengelola')->latest()->get();
        return view('sekretaris.surat-keluar.index', compact('suratKeluarList'));
    }

    /**
     * CREATE (AJAX): Mengembalikan form kosong untuk modal.
     */
    public function create()
    {
        return view('sekretaris.surat-keluar.create');
    }

    /**
     * STORE: Menyimpan surat keluar baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_surat_keluar' => 'required|string|max:100',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string|max:100',
            'perihal' => 'required|string',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $path = $request->file('file_dokumen')->store('dokumen/surat-keluar', 'public');
        $validatedData['file_dokumen'] = $path;
        $validatedData['user_id_pengelola'] = auth()->id();

        SuratKeluar::create($validatedData);

        return redirect()->route('sekretaris.surat-keluar.index')->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    /**
     * EDIT (AJAX): Mengembalikan form yang sudah terisi untuk modal.
     */
    public function edit(SuratKeluar $suratKeluar)
    {
        return view('sekretaris.surat-keluar.edit', compact('suratKeluar'));
    }

    /**
     * UPDATE: Memperbarui data surat keluar.
     */
    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $validatedData = $request->validate([
            'nomor_surat_keluar' => 'required|string|max:100',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required|string|max:100',
            'perihal' => 'required|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file_dokumen')) {
            if ($suratKeluar->file_dokumen) {
                Storage::disk('public')->delete($suratKeluar->file_dokumen);
            }
            $path = $request->file('file_dokumen')->store('dokumen/surat-keluar', 'public');
            $validatedData['file_dokumen'] = $path;
        }

        $suratKeluar->update($validatedData);

        return redirect()->route('sekretaris.surat-keluar.index')->with('success', 'Data surat keluar berhasil diperbarui.');
    }

    /**
     * DELETE: Menghapus data surat keluar.
     */
    public function destroy(SuratKeluar $suratKeluar)
    {
        if ($suratKeluar->file_dokumen) {
            Storage::disk('public')->delete($suratKeluar->file_dokumen);
        }
        $suratKeluar->delete();
        return redirect()->route('sekretaris.surat-keluar.index')->with('success', 'Surat keluar berhasil dihapus.');
    }
}