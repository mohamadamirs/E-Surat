<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\User;
use App\Services\Whatsapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DisposisiController extends Controller
{
    public function store(Request $request, SuratMasuk $suratMasuk)
    {
        $validated = $request->validate([
            'catatan' => 'required|string',
            'id_kepala' => 'required|exists:users,id',
        ]);

        $disposisi = Disposisi::create([
            'id_surat_masuk' => $suratMasuk->id,
            'catatan' => $validated['catatan'],
            'id_kepala' => $validated['id_kepala'],
            'id_sekretaris' => auth()->id(),
            'status_validasi' => 'Menunggu',
        ]);

        try {
            $kepala = User::find($validated['id_kepala']);

            if ($kepala && $kepala->nomer_hp) {
                // Panggil helper function getSapaan() untuk mendapatkan sapaan yang benar
                $sapaan = $kepala->getSapaan(); // Hasilnya akan "Bapak" atau "Ibu"

                $whatsapp = new Whatsapp();
                $whatsapp->to($kepala->nomer_hp)
                    ->italic("Notifikasi Otomatis E-Surat")
                    ->line()
                    ->line("Yth. *" . $sapaan . " " . $kepala->name . "*")
                    ->line()
                    ->line("Anda memiliki 1 disposisi surat baru yang memerlukan validasi dengan detail sebagai berikut : ")
                    ->separator()
                    ->line()
                    ->bold("No. Surat : $suratMasuk->nomor_surat")
                    ->line()
                    ->bold("Perihal : $suratMasuk->perihal")
                    ->line()
                    ->bold("Dari : $suratMasuk->pengirim")
                    ->line()
                    ->bold("Catatan : $disposisi->catatan")
                    ->separator()
                    ->line("Mohon untuk segera ditindaklanjuti melalui sistem E-Surat. Terima kasih.");

                $whatsapp->send();
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengirim WhatsApp notifikasi disposisi: ' . $e->getMessage());
        }

        // Redirect kembali dengan pesan sukses
        return redirect()->route('sekretaris.surat-masuk.show', $suratMasuk->id)
            ->with('success', 'Disposisi berhasil ditambahkan dan notifikasi WhatsApp terkirim.');
    }
}
