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
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->index('nomor_surat'); // Karena Anda mungkin akan mencari berdasarkan nomor surat
            // Foreign key secara default tidak selalu di-index, jadi menambahkannya adalah praktik yang baik
            $table->index('user_id_pengelola');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            //
        });
    }
};
