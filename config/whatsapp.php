<?php
// config/whatsapp.php

return [
    /*
    |--------------------------------------------------------------------------
    | Kredensial untuk API WhatsApp
    |--------------------------------------------------------------------------
    |
    | Nilai-nilai ini diambil dari file .env Anda. Ini adalah cara yang aman
    | untuk mengelola API key dan kredensial lainnya.
    |
    */

    'api_key' => env('WA_API_KEY'),

    'sender' => env('WA_SENDER_NUMBER'),

    'base_url' => env('WA_API_URL', 'https://organisasiabk.my.id'), // Dengan nilai default
];  