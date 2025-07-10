<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;
    
    protected $table = 'surat_keluar';

    protected $fillable = [
        'nomor_surat_keluar',
        'tanggal_surat',
        'tujuan',
        'perihal',
        'file_dokumen',
        'user_id_pengelola',
    ];

    // SATU Surat Keluar dimiliki oleh SATU User Pengelola
    public function pengelola()
    {
        return $this->belongsTo(User::class, 'user_id_pengelola');
    }
}