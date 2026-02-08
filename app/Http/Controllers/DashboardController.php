<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $filter = $request->get('filter', 'today'); // today, month, custom
        
        $startDate = null;
        $endDate = null;
        
        // Set date range based on filter
        switch ($filter) {
            case 'today':
                $startDate = Carbon::today();
                $endDate = Carbon::today()->endOfDay();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'custom':
                $startDate = $request->get('start_date') 
                    ? Carbon::parse($request->get('start_date'))->startOfDay()
                    : Carbon::today();
                $endDate = $request->get('end_date') 
                    ? Carbon::parse($request->get('end_date'))->endOfDay()
                    : Carbon::today()->endOfDay();
                break;
        }
        
        // Get tasks within date range for the VIEW (e.g. for recent tasks list if filtered)
        // But for the TOP STATS CARDS, we usually want TOTAL stats across all time, or at least consistent with what the user expects.
        // The user complained that Task Index (which shows ALL tasks usually) has 4, but Dashboard has 2.
        // Dashboard by default has a filter 'today'.
        
        // Let's separate the query for stats vs the query for the filtered list if needed.
        // However, usually dashboard stats show "Today's Status" or "Total Status". 
        // Based on the layout "Total Tasks", "Pending", "Completed", it implies GLOBAL stats, not just today's.
        
        // 1. Global Stats (All time)
        $allUserTasks = Task::where('user_id', $user->id)->get();
        
        $stats = [
            'total' => $allUserTasks->count(),
            'pending' => $allUserTasks->where('status', 'pending')->count(),
            'done' => $allUserTasks->where('status', 'done')->count(),
            'overdue' => $allUserTasks->filter(function($task) {
                return $task->isOverdue();
            })->count(),
        ];
        
        // 2. Filtered Tasks (for any list or chart below that respects the date filter)
        $tasksQuery = Task::where('user_id', $user->id)
            ->whereBetween('due_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
        
        $tasks = $tasksQuery->get();
        
        // Get recent tasks (last 10 for calendar view or list) -> This one usually ignores the date filter to show latest additions/deadlines
        // Or if you want it to respect the filter, use $tasksQuery.
        // Current implementation:
        $recentTasks = Task::where('user_id', $user->id)
            ->orderBy('due_date', 'desc')
            ->orderBy('due_time', 'desc')
            ->limit(10)
            ->get();
        
        // Prepare calendar data for current month
        $currentMonth = Carbon::now();
        $calendarStartDate = $currentMonth->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $calendarEndDate = $currentMonth->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);
        
        // Get all tasks for calendar month view
        // Since recurring tasks are now generated in DB, we just query by date range
        $calendarEventTasks = Task::where('user_id', $user->id)
            ->whereBetween('due_date', [$calendarStartDate->format('Y-m-d'), $calendarEndDate->format('Y-m-d')])
            ->get();
        
        // Create final collection of tasks grouped by date for the calendar list view
        $calendarTasks = $calendarEventTasks->groupBy(function($task) {
                return $task->due_date->format('Y-m-d');
            });
        
        // Prepare events for FullCalendar as a JSON string to avoid Blade syntax errors
        $calendarEvents = $calendarEventTasks->map(function($task) {
            $isOverdue = $task->status !== 'done' && $task->due_date->copy()->setTimeFromTimeString($task->due_time)->isPast();
            
            return [
                'id' => (string)$task->id,
                'title' => $task->title,
                'start' => $task->due_date->format('Y-m-d') . 'T' . $task->due_time,
                'backgroundColor' => $task->status === 'done' ? '#10b981' : ($isOverdue ? '#ef4444' : '#eab308'),
                'borderColor' => $task->status === 'done' ? '#059669' : ($isOverdue ? '#dc2626' : '#ca8a04'),
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'status' => $task->status,
                    'description' => $task->description ?? '',
                    'wa_notified' => (bool)$task->wa_notified,
                    'due_date' => $task->due_date->format('Y-m-d'),
                    'due_time' => $task->due_time,
                    'is_virtual' => false, // Task is real now
                    'is_overdue' => $isOverdue
                ]
            ];
        });
        
        // Build calendar grid
        $calendarWeeks = [];
        $currentDate = $calendarStartDate->copy();
        
        while ($currentDate <= $calendarEndDate) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $dateKey = $currentDate->format('Y-m-d');
                $week[] = [
                    'date' => $currentDate->copy(),
                    'tasks' => $calendarTasks->get($dateKey, collect()),
                    'isCurrentMonth' => $currentDate->month === $currentMonth->month,
                    'isToday' => $currentDate->isToday(),
                ];
                $currentDate->addDay();
            }
            $calendarWeeks[] = $week;
        }
        
        // Get project statistics
        $projects = Project::where('user_id', $user->id)
            ->with('tasks') // Eager load for accessors
            ->latest()
            ->limit(5)
            ->get();
        
        $projectStats = [
            'total' => Project::where('user_id', $user->id)->count(),
            'active' => Project::where('user_id', $user->id)->where('status', 'active')->count(),
            'completed' => Project::where('user_id', $user->id)->where('status', 'completed')->count(),
        ];
        
        return view('dashboard.index', compact(
            'stats', 
            'recentTasks', 
            'currentMonth', 
            'calendarWeeks', 
            'calendarTasks',
            'calendarEvents',
            'projects',
            'projectStats',
            'tasks', 
            'filter', 
            'startDate', 
            'endDate'
        ));
    }
}
