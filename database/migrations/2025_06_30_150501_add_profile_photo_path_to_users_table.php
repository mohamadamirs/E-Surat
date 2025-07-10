<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

        public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Tambahkan kolom ini setelah kolom 'role' atau 'password'
        $table->string('profile_photo_path', 2048)->nullable()->after('role');
    });
}
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
