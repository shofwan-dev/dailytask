<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CREATING TEST TASK ===\n";
echo "Current time: " . now()->format('Y-m-d H:i:s') . "\n\n";

$user = \App\Models\User::first();

if (!$user) {
    echo "❌ No user found! Please create a user first.\n";
    exit(1);
}

// Buat task dengan deadline 1 jam yang lalu (pasti overdue)
$task = \App\Models\Task::create([
    'user_id' => $user->id,
    'title' => 'Test Notifikasi Overdue - ' . now()->format('H:i:s'),
    'description' => 'Testing WhatsApp reminder system',
    'due_date' => now()->subHour()->toDateString(),
    'due_time' => now()->subHour()->format('H:i'),
    'status' => 'pending',
    'wa_notified' => false
]);

echo "✅ Test task created successfully!\n";
echo "Task ID: {$task->id}\n";
echo "Title: {$task->title}\n";
echo "Due: {$task->due_date} {$task->due_time}\n";
echo "Status: {$task->status}\n";
echo "WA Notified: " . ($task->wa_notified ? 'YES' : 'NO') . "\n";
echo "\nNow run: php artisan tasks:send-reminders\n";
