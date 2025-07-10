<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            // 1. Mengubah kolom ENUM untuk menambahkan status 'Revisi'
            // Sintaks ini spesifik untuk MySQL
            $table->enum('status_validasi', ['Menunggu', 'Disetujui', 'Ditolak', 'Revisi'])
                  ->default('Menunggu')->change();

            // 2. Menambahkan kolom baru untuk catatan revisi dari kepala
            $table->text('catatan_revisi')->nullable()->after('catatan');
        });
    }

    public function down(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            // Logika untuk mengembalikan perubahan jika di-rollback
            $table->enum('status_validasi', ['Menunggu', 'Disetujui', 'Ditolak'])
                  ->default('Menunggu')->change();
            $table->dropColumn('catatan_revisi');
        });
    }
};