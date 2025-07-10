<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk'; // Eksplisit mendefinisikan nama tabel

    protected $fillable = [
        'nomor_surat',
        'tanggal_diterima',
        'pengirim',
        'perihal',
        'file_dokumen',
        'user_id_pengelola',
    ];

    // SATU Surat Masuk dimiliki oleh SATU User Pengelola
    public function pengelola()
    {
        return $this->belongsTo(User::class, 'user_id_pengelola');
    }
    
    // SATU Surat Masuk bisa memiliki BANYAK Disposisi
    public function disposisi()
    {
        return $this->hasMany(Disposisi::class, 'id_surat_masuk');
    }
}