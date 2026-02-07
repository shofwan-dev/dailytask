<?php

namespace App\Http\Controllers;

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
        
        // Get tasks within date range
        $tasksQuery = Task::where('user_id', $user->id)
            ->whereBetween('due_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
        
        $tasks = $tasksQuery->get();
        
        // Calculate statistics
        $stats = [
            'total' => $tasks->count(),
            'pending' => $tasks->where('status', 'pending')->count(),
            'done' => $tasks->where('status', 'done')->count(),
            'overdue' => $tasks->filter(function($task) {
                return $task->isOverdue();
            })->count(),
        ];
        
        // Get recent tasks (last 10 for calendar view)
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
        $calendarTasks = Task::where('user_id', $user->id)
            ->whereBetween('due_date', [$calendarStartDate->format('Y-m-d'), $calendarEndDate->format('Y-m-d')])
            ->get()
            ->groupBy(function($task) {
                return $task->due_date->format('Y-m-d');
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
        
        return view('dashboard.index', compact('tasks', 'stats', 'filter', 'startDate', 'endDate', 'recentTasks', 'calendarWeeks', 'currentMonth', 'calendarTasks'));
    }
}
