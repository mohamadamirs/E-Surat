<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisi';

    protected $fillable = [
        'id_surat_masuk',
        'catatan',
        'status_validasi',
        'id_sekretaris',
        'id_kepala',
        'tanggal_validasi',
        'catatan_revisi',
    ];

    // SATU Disposisi terhubung ke SATU Surat Masuk
    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'id_surat_masuk');
    }

    // SATU Disposisi dibuat oleh SATU User (Sekretaris)
    public function sekretaris()
    {
        return $this->belongsTo(User::class, 'id_sekretaris');
    }

    // SATU Disposisi divalidasi oleh SATU User (Pimpinan)
    public function kepala()
    {
        return $this->belongsTo(User::class, 'id_kepala');
    }
}