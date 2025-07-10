<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk; // Jangan lupa import modelnya
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class SuratMasukController extends Controller
{
    /**
     * READ: Menampilkan halaman utama dengan daftar surat masuk.
     */
    public function index(Request $request)
    {
        // Ambil data surat masuk, beserta data pengelolanya (user)
        // diurutkan dari yang terbaru
        $suratMasukList = SuratMasuk::with('pengelola')->latest()->get();
        return view('sekretaris.surat-masuk.index', compact('suratMasukList'));
    }

    public function show(SuratMasuk $suratMasuk)
    {
        // Ambil data surat masuk beserta relasinya (disposisi dan pengelola)
        // Ini akan mencegah N+1 query problem dan lebih efisien
        $suratMasuk->load('pengelola', 'disposisi.sekretaris', 'disposisi.kepala');

        // Ambil daftar user yang memiliki role 'pimpinan' untuk dropdown
        $kepalaList = User::where('role', 'kepala')->get();

        return view('sekretaris.surat-masuk.show', compact('suratMasuk', 'kepalaList'));
    }


    /**
     * CREATE (AJAX): Mengembalikan potongan HTML form KOSONG untuk modal.
     */
    public function create()
    {
        return view('sekretaris.surat-masuk.create');
    }

    /**
     * STORE: Memproses dan menyimpan data surat masuk baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'tanggal_diterima' => 'required|date',
            'pengirim' => 'required|string|max:100',
            'perihal' => 'required|string',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx|max:5120', // Maks 5MB
        ]);

        // Handle File Upload
        $path = $request->file('file_dokumen')->store('dokumen/surat-masuk', 'public');
        $validatedData['file_dokumen'] = $path;

        // Tambahkan ID user yang sedang login sebagai pengelola
        $validatedData['user_id_pengelola'] = auth()->id();

        SuratMasuk::create($validatedData);

        return redirect()->route('sekretaris.surat-masuk.index')->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    /**
     * EDIT (AJAX): Mengembalikan potongan HTML form yang SUDAH TERISI untuk modal.
     */
    public function edit(SuratMasuk $suratMasuk)
    {
        return view('sekretaris.surat-masuk.edit', compact('suratMasuk'));
    }

    /**
     * UPDATE: Memproses dan memperbarui data surat masuk.
     */
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        
        // 'nullable' berarti field ini boleh kosong saat update.
        $validatedData = $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'tanggal_diterima' => 'required|date',
            'pengirim' => 'required|string|max:100',
            'perihal' => 'required|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // Maks 5MB
        ]);
        // Hanya proses file jika ada file baru yang di-upload.
        if ($request->hasFile('file_dokumen')) {
            //   Hapus file lama dari storage untuk menghemat ruang.
            //    Tambahkan pengecekan jika file lama memang ada.
            if ($suratMasuk->file_dokumen) {
                Storage::disk('public')->delete($suratMasuk->file_dokumen);
            }

            // Simpan file baru dan dapatkan path-nya.
            $path = $request->file('file_dokumen')->store('dokumen/surat-masuk', 'public');

            // Masukkan path file baru ke dalam data yang akan di-update.
            $validatedData['file_dokumen'] = $path;
        }

        $suratMasuk->update($validatedData);

        return redirect()->route('sekretaris.surat-masuk.index')->with('success', 'Data surat masuk berhasil diperbarui.');
    }

    /**
     * DELETE: Menghapus data surat masuk beserta filenya.
     */
    public function destroy(SuratMasuk $suratMasuk)
    {
        try {
            // Hapus file dokumen dari storage jika ada
            if ($suratMasuk->file_dokumen) {
                Storage::disk('public')->delete($suratMasuk->file_dokumen);
            }

            // Hapus semua disposisi yang terkait dengan surat ini terlebih dahulu.
            // Jika Anda sudah mengatur cascadeOnDelete di migration, baris ini tidak wajib tapi tetap aman.
            $suratMasuk->disposisi()->delete();

            // Setelah semua relasi "anak" dihapus, baru hapus data "induk".
            $suratMasuk->delete();

            return redirect()->route('sekretaris.surat-masuk.index')
                ->with('success', 'Surat masuk dan semua data terkait berhasil dihapus.');
        } catch (\Exception $e) {
            // Jika terjadi error, kembali dengan pesan error
            return redirect()->route('sekretaris.surat-masuk.index')
                ->with('error', 'Gagal menghapus surat masuk: ' . $e->getMessage());
        }
    }
}
