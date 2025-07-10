<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom baru setelah kolom 'role'
            // ENUM adalah pilihan yang baik untuk nilai yang terbatas
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('jenis_kelamin');
        });
    }
};