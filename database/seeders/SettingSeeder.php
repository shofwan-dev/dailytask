<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Migrate WhatsApp settings from .env to database
        $settings = [
            'wa_api_key' => env('WA_API_KEY', ''),
            'wa_sender' => env('WA_SENDER', ''),
            'wa_base_url' => env('WA_BASE_URL', 'https://mpwa.mutekar.com'),
            'wa_recipient' => env('WA_RECIPIENT', ''),
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
