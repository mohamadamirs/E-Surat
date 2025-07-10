<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat_keluar', 100);
            $table->date('tanggal_surat');
            $table->string('tujuan', 100);
            $table->text('perihal');
            $table->string('file_dokumen', 255);
            
            // Foreign Key ke tabel 'users'
            $table->foreignId('user_id_pengelola')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};