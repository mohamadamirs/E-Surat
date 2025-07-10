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
        Schema::table('users', function (Blueprint $table) {
            // Mengubah kolom nomer_hp agar bisa bernilai NULL
            // Sintaks ->change() mengharuskan Anda menginstal package 'doctrine/dbal'
            $table->string('nomer_hp')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Mengembalikan kolom menjadi NOT NULL jika di-rollback
            $table->string('nomer_hp')->nullable(false)->change();
        });
    }
};