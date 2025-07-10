<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\SuratMasuk;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(1000)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'nomer_hp' => '98213767',
            'password' => Hash::make('290827-admin'),
        ]);
        User::create([
            'name' => 'Hana',
            'email' => 'hana@gmail.com',
            'role' => 'sekretaris',
            'nomer_hp' => '808980988',
            'password' => Hash::make('290827-sekretaris'),
        ]);
         User::create([
            'name' => 'Amir',
            'email' => 'amir@gmail.com',
            'role' => 'kepala',
            'nomer_hp' => '87987252',
            'password' => Hash::make('290827-kepala'),
        ]);

        //  SuratMasuk::factory()->count(50)->create();
    }
}
