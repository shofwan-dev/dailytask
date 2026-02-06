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
        
        // Debug: Show current time
        $this->line('⏰ Current time: ' . now()->format('Y-m-d H:i:s'));
        
        // Debug: Show all pending tasks
        $allPending = Task::where('status', 'pending')->where('wa_notified', false)->get();
        $this->line("📋 Total pending tasks (not notified): {$allPending->count()}");
        
        if ($allPending->isNotEmpty()) {
            foreach ($allPending as $task) {
                $dueDateTime = \Carbon\Carbon::parse($task->due_date->toDateString() . ' ' . $task->due_time);
                $isOverdue = $task->isOverdue();
                $this->line("   - Task #{$task->id}: {$task->title}");
                $this->line("     Due: {$dueDateTime->format('Y-m-d H:i:s')} | Overdue: " . ($isOverdue ? 'YES ✅' : 'NO ❌'));
            }
        }

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
