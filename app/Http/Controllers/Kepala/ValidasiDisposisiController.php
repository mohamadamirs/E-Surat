<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use App\Services\Whatsapp; //notifikasi
use Illuminate\Support\Facades\Log; //import log untuk menampilkan error

class ValidasiDisposisiController extends Controller
{
    public function index()
    {
        $disposisiList = Disposisi::with('suratMasuk', 'sekretaris')
            ->where('id_kepala', auth()->id())
            ->where('status_validasi', 'Menunggu')
            ->latest()
            ->get();
        return view('kepala.validasi.index', compact('disposisiList'));
    }

    public function approve(Disposisi $disposisi)
    {
        if ($disposisi->id_kepala !== auth()->id()) {
            abort(403, 'Akses Ditolak.');
        }
        $disposisi->update(['status_validasi' => 'Disetujui', 'tanggal_validasi' => now()]);

        $this->notifikasiWhatsapp($disposisi, 'Disetujui');

        return redirect()->route('kepala.validasi.index')->with('success', 'Disposisi untuk surat ' . $disposisi->suratMasuk->nomor_surat . ' telah disetujui.');
    }

    public function reject(Disposisi $disposisi)
    {
        if ($disposisi->id_kepala !== auth()->id()) {
            abort(403, 'Akses Ditolak.');
        }
        $disposisi->update(['status_validasi' => 'Ditolak', 'tanggal_validasi' => now()]);

        $this->notifikasiWhatsapp($disposisi, 'Ditolak');

        return redirect()->route('kepala.validasi.index')->with('success', 'Disposisi untuk surat ' . $disposisi->suratMasuk->nomor_surat . ' telah ditolak.');
    }

    public function show(SuratMasuk $suratMasuk)
    {
        $isRelevant = $suratMasuk->disposisi()->where('id_kepala', auth()->id())->exists();
        if (!$isRelevant) {
            abort(403, 'Anda tidak memiliki disposisi untuk surat ini.');
        }
        $suratMasuk->load('pengelola', 'disposisi.sekretaris', 'disposisi.kepala');
        return view('kepala.validasi.show', compact('suratMasuk'));
    }

    public function revise(Request $request, Disposisi $disposisi)
    {
        if ($disposisi->id_kepala !== auth()->id()) {
            abort(403, 'Akses Ditolak.');
        }
        $validated = $request->validate(['catatan_revisi' => 'required|string|min:10']);
        $disposisi->update([
            'status_validasi' => 'Revisi',
            'catatan_revisi' => $validated['catatan_revisi'],
            'tanggal_validasi' => now(),
        ]);

        $this->notifikasiWhatsapp($disposisi, 'Revisi');

        return redirect()->route('kepala.validasi.show', $disposisi->id_surat_masuk)
            ->with('success', 'Instruksi revisi berhasil dikirim ke sekretaris.');
    }

    public function history()
    {
        $historyList = Disposisi::with('suratMasuk', 'sekretaris')
            ->where('id_kepala', auth()->id())
            ->whereIn('status_validasi', ['Disetujui', 'Ditolak', 'Revisi'])
            ->orderBy('tanggal_validasi', 'desc')->get();
        return view('kepala.riwayat.index', compact('historyList'));
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'exists:disposisi,id']);
        Disposisi::where('id_kepala', auth()->id())->whereIn('id', $request->ids)->delete();
        return redirect()->route('kepala.riwayat.index')->with('success', 'Data riwayat yang dipilih berhasil dihapus.');
    }


    /**
     * Helper method untuk mengirim notifikasi WhatsApp ke Sekretaris.
     */
    private function notifikasiWhatsapp(Disposisi $disposisi, string $status): void
    {
        // PERBAIKAN #2: Pindahkan 'try' ke dalam fungsi untuk membungkus logika
        try {
            $sekretaris = $disposisi->sekretaris;
            if ($sekretaris && $sekretaris->nomer_hp) {
                $whatsapp = new Whatsapp();

                $pesanAksi = "telah *{$status}* oleh *{$disposisi->kepala->name}*";

                $whatsapp->to($sekretaris->nomer_hp)
                    ->line("Yth. *" . $sekretaris->name . "*")
                    ->line()
                    ->line("Disposisi yang Anda berikan " . $pesanAksi)
                    ->separator()
                    ->line()
                    ->line("*No. Surat : " . $disposisi->suratMasuk->nomor_surat . "*")
                    ->line()
                    ->line("*Perihal : " . $disposisi->suratMasuk->perihal . "*");

                if ($status === 'Revisi' && $disposisi->catatan_revisi) {
                    $whatsapp->line()
                        ->bold("Catatan Revisi:")
                        ->italic($disposisi->catatan_revisi);
                }

                $whatsapp->separator()
                    ->line("Silakan periksa detailnya di sistem E-Surat. Terima kasih.")
                    ->line()
                    ->italic('Notifikasi Otomatis E-Surat');

                $whatsapp->send();
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi validasi WA: ' . $e->getMessage());
        }
    }
}
