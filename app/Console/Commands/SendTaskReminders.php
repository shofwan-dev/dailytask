<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;

class SendTaskReminders extends Command
{
    protected $signature = 'tasks:send-reminders';
    protected $description = 'Send WhatsApp reminders for overdue tasks';

    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        parent::__construct();
        $this->whatsappService = $whatsappService;
    }

    public function handle()
    {
        $this->info('🔍 Checking for overdue tasks...');

        $tasks = Task::overdueAndNotNotified()
            ->with('user')
            ->get();

        if ($tasks->isEmpty()) {
            $this->info('✅ No overdue tasks found.');
            return 0;
        }

        $this->info("📤 Found {$tasks->count()} overdue task(s). Sending reminders...");

        $successCount = 0;
        $failCount = 0;

        foreach ($tasks as $task) {
            // Check if user has phone number
            if (!$task->user->phone_number) {
                $this->warn("⚠️  User {$task->user->name} doesn't have phone number. Skipping task: {$task->title}");
                continue;
            }

            $this->line("📨 Sending reminder to {$task->user->name} for task: {$task->title}");

            if ($this->whatsappService->sendTaskReminder($task)) {
                $task->update(['wa_notified' => true]);
                $successCount++;
                $this->info("✅ Reminder sent successfully!");
            } else {
                $failCount++;
                $this->error("❌ Failed to send reminder!");
            }
        }

        $this->newLine();
        $this->info("📊 Summary:");
        $this->info("   ✅ Success: {$successCount}");
        $this->info("   ❌ Failed: {$failCount}");

        return 0;
    }
}
