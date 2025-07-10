<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            // 1. Hapus foreign key yang lama terlebih dahulu
            $table->dropForeign(['id_sekretaris']);
            $table->dropForeign(['id_kepala']);

            // 2. Tambahkan kembali foreign key dengan aturan onDelete('cascade')
            $table->foreign('id_sekretaris')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete(); // Jika user sekretaris dihapus, disposisinya ikut terhapus

            $table->foreign('id_kepala')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete(); // Jika user kepala dihapus, disposisinya ikut terhapus
        });
    }

    public function down(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            // Logika untuk mengembalikan jika di-rollback
            $table->dropForeign(['id_sekretaris']);
            $table->dropForeign(['id_kepala']);

            $table->foreign('id_sekretaris')->references('id')->on('users');
            $table->foreign('id_kepala')->references('id')->on('users');
        });
    }
};