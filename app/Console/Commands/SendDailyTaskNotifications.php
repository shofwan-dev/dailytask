<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendDailyTaskNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-daily-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily task notifications to users at 8 AM';

    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        parent::__construct();
        $this->whatsappService = $whatsappService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        
        // Get recipient from settings (same as reminder)
        $recipient = \App\Models\Setting::get('wa_recipient', '');
        
        if (empty($recipient)) {
            $this->warn('⚠ WhatsApp recipient not configured in settings');
            $this->info('Please configure "Nomor Penerima Notifikasi" in WhatsApp settings');
            return Command::FAILURE;
        }
        
        // Get all users who have tasks today
        $users = User::whereHas('tasks', function($query) use ($today) {
            $query->where('due_date', $today)
                  ->where('status', 'pending');
        })->get();

        if ($users->isEmpty()) {
            $this->info('✅ No tasks scheduled for today');
            return Command::SUCCESS;
        }

        $totalTasks = 0;
        $message = "☀️ *Selamat Pagi!*\n\n";
        $message .= "📅 *Task Hari Ini* (" . $today->format('d F Y') . ")\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━\n\n";

        foreach ($users as $user) {
            // Get user's tasks for today
            $tasks = Task::where('user_id', $user->id)
                ->where('due_date', $today)
                ->where('status', 'pending')
                ->orderBy('due_time', 'asc')
                ->get();

            if ($tasks->isEmpty()) {
                continue;
            }

            // Add user section
            $message .= "👤 *{$user->name}*\n";
            
            foreach ($tasks as $index => $task) {
                $taskNumber = $index + 1;
                $time = Carbon::parse($task->due_time)->format('H:i');
                $message .= "   {$taskNumber}. *{$task->title}*\n";
                $message .= "      ⏰ {$time} WIB\n";
                
                if ($task->project) {
                    $message .= "      📁 {$task->project->name}\n";
                }
                
                if ($task->description) {
                    $description = strlen($task->description) > 50 
                        ? substr($task->description, 0, 50) . '...' 
                        : $task->description;
                    $message .= "      📝 {$description}\n";
                }
                
                $totalTasks++;
            }
            
            $message .= "\n";
        }

        $message .= "━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "Total: *{$totalTasks} task*\n\n";
        $message .= "Semangat menyelesaikan task hari ini! 💪";

        // Send WhatsApp notification to configured recipient
        try {
            $this->whatsappService->sendMessage($recipient, $message, 'DailyTask App');
            $this->info("✓ Daily notification sent to {$recipient}");
            $this->info("  Users: {$users->count()}");
            $this->info("  Tasks: {$totalTasks}");
        } catch (\Exception $e) {
            $this->error("✗ Failed to send notification: " . $e->getMessage());
            return Command::FAILURE;
        }

        $this->info("\n━━━━━━━━━━━━━━━━━━━━");
        $this->info("Daily notification sent successfully");
        
        return Command::SUCCESS;
    }
}
