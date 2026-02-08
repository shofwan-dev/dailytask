<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get project progress percentage based on completed tasks
     */
    /**
     * Get project progress percentage based on completed tasks
     */
    public function getProgressAttribute(): int
    {
        $tasks = $this->tasks;
        $totalTasks = $tasks->count();
        
        if ($totalTasks === 0) {
            return 0;
        }
        
        $completedTasks = $tasks->where('status', 'done')->count();
        
        return (int) round(($completedTasks / $totalTasks) * 100);
    }

    /**
     * Get total tasks count
     */
    public function getTotalTasksAttribute(): int
    {
        return $this->tasks()->count();
    }

    /**
     * Get completed tasks count
     */
    public function getCompletedTasksAttribute(): int
    {
        return $this->tasks()->where('status', 'done')->count();
    }

    /**
     * Get pending tasks count
     */
    public function getPendingTasksAttribute(): int
    {
        return $this->tasks()->where('status', 'pending')->count();
    }
}
