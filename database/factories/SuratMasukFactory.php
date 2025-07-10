<?php

namespace Database\Factories;

use App\Models\User; // Penting: Import model User untuk mengambil Foreign Key
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SuratMasuk>
 */
class SuratMasukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil satu user secara acak untuk menjadi 'pengelola'.
        // Ini adalah cara sederhana, tetapi akan melakukan query setiap kali factory dipanggil.
        // Untuk seeding data dalam jumlah besar, ada cara yang lebih optimal (dijelaskan di bawah).
        $pengelola = User::inRandomOrder()->first();

        return [
            // Membuat nomor surat yang terlihat realistis
            // Contoh: IV/SM/2023/123
            'nomor_surat' => fake()->randomElement(['I', 'II', 'III', 'IV', 'V']) .
                             '/SM/' . fake()->year() . '/' . fake()->unique()->randomNumber(3, true),

            // Mengambil tanggal acak dalam 1 tahun terakhir
            'tanggal_diterima' => fake()->dateTimeBetween('-1 year', 'now'),

            // Mengambil nama perusahaan acak sebagai pengirim
            'pengirim' => fake()->company(),

            // Mengambil kalimat acak sebagai perihal
            'perihal' => fake()->sentence(6),

            // Membuat path file palsu. Kita tidak perlu membuat file aslinya.
            'file_dokumen' => 'dokumen/surat-masuk-dummy/' . Str::random(20) . '.pdf',

            // Menggunakan ID dari user pengelola yang sudah kita ambil secara acak
            'user_id_pengelola' => $pengelola->id,
        ];
    }
}