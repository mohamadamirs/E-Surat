<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat', 100);
            $table->date('tanggal_diterima');
            $table->string('pengirim', 100);
            $table->text('perihal');
            $table->string('file_dokumen', 255);
            
            // Foreign Key ke tabel 'users'
            // onDelete('cascade') berarti jika user dihapus, semua surat masuk yang dia kelola juga akan terhapus.
            $table->foreignId('user_id_pengelola')->constrained('users')->onDelete('cascade');
            
            $table->timestamps(); // otomatis membuat kolom created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};