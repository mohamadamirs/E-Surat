<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class ValidasiDisposisiController extends Controller
{
    public function index()
    {
        // Ambil disposisi yang:
        // 1. Ditujukan untuk kepala yang sedang login (auth()->id())
        // 2. Statusnya masih 'Menunggu'
        $disposisiList = Disposisi::with('suratMasuk', 'sekretaris') // Eager load untuk efisiensi
            ->where('id_kepala', auth()->id())
            ->where('status_validasi', 'Menunggu')
            ->latest()
            ->get();

        return view('kepala.validasi.index', compact('disposisiList'));
    }

    /**
     * Menyetujui sebuah disposisi.
     */
    public function approve(Disposisi $disposisi)
    {
        // Keamanan: Pastikan hanya kepala yang dituju yang bisa menyetujui
        if ($disposisi->id_kepala !== auth()->id()) {
            abort(403, 'Akses Ditolak.');
        }

        $disposisi->update([
            'status_validasi' => 'Disetujui',
            'tanggal_validasi' => now(),
        ]);

        return redirect()->route('kepala.validasi.index')->with('success', 'Disposisi untuk surat ' . $disposisi->suratMasuk->nomor_surat . ' telah disetujui.');
    }

    /**
     * Menolak sebuah disposisi.
     */
    public function reject(Disposisi $disposisi)
    {
        // Keamanan: Pastikan hanya kepala yang dituju yang bisa menolak
        if ($disposisi->id_kepala !== auth()->id()) {
            abort(403, 'Akses Ditolak.');
        }

        $disposisi->update([
            'status_validasi' => 'Ditolak',
            'tanggal_validasi' => now(),
        ]);

        return redirect()->route('kepala.validasi.index')->with('success', 'Disposisi untuk surat ' . $disposisi->suratMasuk->nomor_surat . ' telah ditolak.');
    }
    public function show(SuratMasuk $suratMasuk)
    {
        // Keamanan: Pastikan kepala ini memang menerima disposisi untuk surat ini
        // Ini mencegah kepala melihat detail surat yang tidak relevan baginya.
        $isRelevant = $suratMasuk->disposisi()->where('id_kepala', auth()->id())->exists();

        if (!$isRelevant) {
            abort(403, 'Anda tidak memiliki disposisi untuk surat ini.');
        }

        // Muat semua relasi yang dibutuhkan untuk ditampilkan di view
        $suratMasuk->load('pengelola', 'disposisi.sekretaris', 'disposisi.kepala');

        // Menggunakan view khusus untuk kepala
        return view('kepala.validasi.show', compact('suratMasuk'));
    }
    public function revise(Request $request, Disposisi $disposisi)
    {
        // Keamanan
        if ($disposisi->id_kepala !== auth()->id()) {
            abort(403, 'Akses Ditolak.');
        }

        // Validasi input catatan revisi
        $validated = $request->validate([
            'catatan_revisi' => 'required|string|min:10',
        ]);

        $disposisi->update([
            'status_validasi' => 'Revisi',
            'catatan_revisi' => $validated['catatan_revisi'],
            'tanggal_validasi' => now(), // Kita anggap revisi juga sebuah bentuk validasi
        ]);

        return redirect()->route('kepala.validasi.show', $disposisi->id_surat_masuk)
            ->with('success', 'Instruksi revisi berhasil dikirim ke sekretaris.');
    }
    public function history()
    {
        // Ambil disposisi yang:
        //  Ditujukan untuk kepala yang sedang login
        //  Statusnya BUKAN lagi 'Menunggu'
        $historyList = Disposisi::with('suratMasuk', 'sekretaris') // Eager load
            ->where('id_kepala', auth()->id())
            ->whereIn('status_validasi', ['Disetujui', 'Ditolak', 'Revisi']) // Kondisi status
            ->orderBy('tanggal_validasi', 'desc') // Urutkan dari yang terbaru divalidasi
            ->get();

        return view('kepala.riwayat.index', compact('historyList'));
    }
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:disposisi,id', // Pastikan setiap ID ada di tabel disposisi
        ]);

        // Keamanan & Hapus Data:
        // Hapus hanya disposisi yang ID-nya ada di dalam array request
        // DAN milik kepala yang sedang login.
        // Ini mencegah user menghapus data milik orang lain.
        Disposisi::where('id_kepala', auth()->id())
                 ->whereIn('id', $request->ids)
                 ->delete();

        // 3. Redirect kembali dengan pesan sukses.
        return redirect()->route('kepala.riwayat.index')
                         ->with('success', 'Data riwayat yang dipilih berhasil dihapus.');
    }
}
