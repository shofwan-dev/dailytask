<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo user (or get existing)
        $user = User::firstOrCreate(
            ['email' => 'demo@dailytask.com'],
            [
                'name' => 'Demo User',
                'phone_number' => '628123456789',
                'password' => Hash::make('password'),
            ]
        );

        // Create sample tasks
        Task::create([
            'user_id' => $user->id,
            'title' => 'Submit Laporan Bulanan',
            'description' => 'Selesaikan dan submit laporan keuangan bulan Januari',
            'due_date' => now()->addDays(2)->format('Y-m-d'),
            'due_time' => '17:00:00',
            'status' => 'pending',
        ]);

        Task::create([
            'user_id' => $user->id,
            'title' => 'Meeting dengan Tim Marketing',
            'description' => 'Diskusi strategi kampanye Q1 2026',
            'due_date' => now()->addDays(1)->format('Y-m-d'),
            'due_time' => '14:00:00',
            'status' => 'pending',
        ]);

        Task::create([
            'user_id' => $user->id,
            'title' => 'Review Proposal Klien',
            'description' => null,
            'due_date' => now()->subHours(2)->format('Y-m-d'), // Overdue task
            'due_time' => now()->subHours(2)->format('H:i:s'),
            'status' => 'pending',
        ]);

        Task::create([
            'user_id' => $user->id,
            'title' => 'Update Website Company',
            'description' => 'Upload konten blog terbaru dan update portfolio',
            'due_date' => now()->format('Y-m-d'),
            'due_time' => '18:00:00',
            'status' => 'done',
        ]);

        Task::create([
            'user_id' => $user->id,
            'title' => 'Beli Perlengkapan Kantor',
            'description' => 'Kertas A4, tinta printer, dan alat tulis',
            'due_date' => now()->addDays(3)->format('Y-m-d'),
            'due_time' => '16:00:00',
            'status' => 'done',
        ]);
    }
}
