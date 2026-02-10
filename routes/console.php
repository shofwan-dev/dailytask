<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule task reminders every 10 minutes
Schedule::command('tasks:send-reminders')
    ->everyTenMinutes()
    ->withoutOverlapping()
    ->runInBackground();

// Schedule daily task notifications at 8 AM
Schedule::command('tasks:send-daily-notifications')
    ->dailyAt('08:00')
    ->withoutOverlapping()
    ->runInBackground();
