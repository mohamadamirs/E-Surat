<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key ke tabel 'surat_masuk'
            $table->foreignId('id_surat_masuk')->constrained('surat_masuk')->onDelete('cascade');
            
            $table->text('catatan');
            
            // Kolom ENUM untuk status validasi
            $table->enum('status_validasi', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            
            // Foreign Key ke tabel 'users' untuk Sekretaris
            $table->foreignId('id_sekretaris')->constrained('users');
            
            // Foreign Key ke tabel 'users' untuk Pimpinan (bisa NULL)
            $table->foreignId('id_kepala')->nullable()->constrained('users');
            
            $table->dateTime('tanggal_validasi')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disposisi');
    }
};