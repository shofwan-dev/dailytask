<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING ALL TASKS ===\n";
echo "Current time: " . now()->format('Y-m-d H:i:s') . "\n\n";

$tasks = \App\Models\Task::orderBy('created_at', 'desc')->get();

echo "Total tasks: " . $tasks->count() . "\n\n";

foreach ($tasks as $task) {
    $dueDateTime = \Carbon\Carbon::parse($task->due_date->toDateString() . ' ' . $task->due_time);
    $isOverdue = $task->isOverdue();
    
    echo "Task #{$task->id}: {$task->title}\n";
    echo "  User: {$task->user->name} (ID: {$task->user_id})\n";
    echo "  Due: {$dueDateTime->format('Y-m-d H:i:s')}\n";
    echo "  Status: {$task->status}\n";
    echo "  WA Notified: " . ($task->wa_notified ? 'YES' : 'NO') . "\n";
    echo "  Is Overdue: " . ($isOverdue ? 'YES ✅' : 'NO ❌') . "\n";
    echo "  Created: {$task->created_at->format('Y-m-d H:i:s')}\n";
    echo "  ---\n";
}

echo "\n=== CHECKING OVERDUE TASKS (NOT NOTIFIED) ===\n";
$overdueTasks = \App\Models\Task::where('status', 'pending')
    ->where('wa_notified', false)
    ->get()
    ->filter(function($task) {
        return $task->isOverdue();
    });

echo "Total overdue tasks (not notified): " . $overdueTasks->count() . "\n";
foreach ($overdueTasks as $task) {
    echo "  - Task #{$task->id}: {$task->title}\n";
}
