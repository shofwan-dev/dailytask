<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'title',
        'description',
        'due_date',
        'due_time',
        'status',
        'wa_notified',
        'recurrence_type',
        'recurrence_end_date',
    ];

    protected $casts = [
        'due_date' => 'date',
        'recurrence_end_date' => 'date',
        'wa_notified' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function isOverdue(): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }
        
        // Gabungkan due_date (Carbon object) dengan due_time (string)
        $dueDateTime = \Carbon\Carbon::parse(
            $this->due_date->toDateString() . ' ' . $this->due_time
        );
        
        return $dueDateTime->isPast();
    }

    public function scopeOverdueAndNotNotified($query)
    {
        // Ambil semua task pending yang belum di-notifikasi
        // Lalu filter di PHP karena datetime comparison lebih reliable
        $tasks = $query->where('status', 'pending')
            ->where('wa_notified', false)
            ->get();
        
        // Filter tasks yang benar-benar overdue
        $overdueTasks = $tasks->filter(function($task) {
            return $task->isOverdue();
        });
        
        // Return query builder dengan task IDs yang overdue
        if ($overdueTasks->isEmpty()) {
            return $query->whereRaw('1 = 0'); // Return empty query
        }
        
        return $query->whereIn('id', $overdueTasks->pluck('id'));
    }
    /**
     * Get the count of remaining recurrences.
     * 
     * @deprecated Recurrences are now generated as individual tasks in the database.
     * This method is kept for backward compatibility but returns 0 to prevent double counting.
     */
    public function getRemainingRecurrencesCount(): int
    {
        return 0;
    }
}
