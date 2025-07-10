<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            // 1. Hapus foreign key constraint yang lama
            $table->dropForeign(['id_surat_masuk']);

            // 2. Tambahkan kembali foreign key dengan aturan baru: cascadeOnDelete()
            $table->foreign('id_surat_masuk')
                  ->references('id')
                  ->on('surat_masuk')
                  ->cascadeOnDelete(); // INI BAGIAN PENTINGNYA
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            // Logika untuk mengembalikan jika di-rollback
            $table->dropForeign(['id_surat_masuk']);
            
            $table->foreign('id_surat_masuk')
                  ->references('id')
                  ->on('surat_masuk');
        });
    }
};