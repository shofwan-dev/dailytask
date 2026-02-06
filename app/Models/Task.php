<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'due_date',
        'due_time',
        'status',
        'wa_notified',
    ];

    protected $casts = [
        'due_date' => 'date',
        'wa_notified' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
}
