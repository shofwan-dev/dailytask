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
        
        // Get recent tasks (last 5)
        $recentTasks = Task::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard.index', compact('tasks', 'stats', 'filter', 'startDate', 'endDate', 'recentTasks'));
    }
}
