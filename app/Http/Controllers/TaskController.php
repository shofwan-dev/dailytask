<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function index(Request $request)
    {
        $query = Auth::user()->tasks()
            ->with('project');

        // Filter by project
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $tasks = $query->orderBy('due_date', 'asc')
            ->orderBy('due_time', 'asc')
            ->get();

        $projects = Project::where('user_id', Auth::id())->orderBy('name')->get();

        return view('tasks.index', compact('tasks', 'projects'));
    }

    public function create(Request $request)
    {
        $projects = Project::where('user_id', Auth::id())->get();
        $selectedProjectId = $request->get('project_id');
        return view('tasks.create', compact('projects', 'selectedProjectId'));
    }

    public function show(Task $task)
    {
        // Check ownership
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        // Check ownership
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $projects = Project::where('user_id', Auth::id())->get();
        return view('tasks.edit', compact('task', 'projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'due_time' => 'required',
            'project_id' => 'nullable|exists:projects,id',
            'recurrence_type' => 'nullable|in:none,daily,weekly,monthly',
            'recurrence_end_date' => 'nullable|date|after:due_date',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';
        $recurrenceType = $validated['recurrence_type'] ?? 'none';
        $recurrenceEndDate = $validated['recurrence_end_date'] ?? null;
        
        // We will store the persistence type as 'none' for the database records so they act as individual tasks
        // But we can append a tag or description if needed. For now, we strictly follow "duplicate task".
        // To keep the "Badge" visible as requested before, we might want to keep the type.
        // However, to prevent double-counting logic elsewhere, we must ensure unrelated logic doesn't project these.
        // I will keep the type but disable the projection logic in other files.
        $validated['recurrence_type'] = $recurrenceType;

        // Create the base task
        $baseTask = Task::create($validated);
        
        // Generate duplicates if recurrence is set
        if ($recurrenceType !== 'none') {
            $startDate = \Carbon\Carbon::parse($validated['due_date']);
            $nextDate = $startDate->copy();

            // Tentukan end date: gunakan input user atau default
            if ($recurrenceEndDate) {
                $endDate = \Carbon\Carbon::parse($recurrenceEndDate);
            } else {
                // Default jika end date tidak diisi
                switch ($recurrenceType) {
                    case 'daily':
                        $endDate = $startDate->copy()->addDays(30);   // 30 hari
                        break;
                    case 'weekly':
                        $endDate = $startDate->copy()->addWeeks(12);  // 12 minggu
                        break;
                    case 'monthly':
                        $endDate = $startDate->copy()->addMonths(12); // 12 bulan
                        break;
                    default:
                        $endDate = $startDate->copy();
                        break;
                }
                // Simpan end date default ke base task
                $baseTask->update(['recurrence_end_date' => $endDate->format('Y-m-d')]);
            }
            
            while (true) {
                switch ($recurrenceType) {
                    case 'daily':
                        $nextDate->addDay();
                        break;
                    case 'weekly':
                        $nextDate->addWeek();
                        break;
                    case 'monthly':
                        $nextDate->addMonth();
                        break;
                    default:
                        break 2;
                }
                
                if ($nextDate->gt($endDate)) {
                    break;
                }
                
                // Create duplicate
                $newTaskData = $validated;
                $newTaskData['due_date'] = $nextDate->format('Y-m-d');
                $newTaskData['recurrence_type'] = $recurrenceType; // Keep type for UI badge
                $newTaskData['recurrence_end_date'] = $endDate->format('Y-m-d');
                Task::create($newTaskData);
            }
        }

        return redirect()->route('tasks.index')
            ->with('success', '✅ Task berhasil ditambahkan!');
    }

    public function update(Request $request, Task $task)
    {
        // Check ownership
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'due_time' => 'required',
            'status' => 'required|in:pending,done',
            'project_id' => 'nullable|exists:projects,id',
            'recurrence_type' => 'nullable|in:none,daily,weekly,monthly',
            'recurrence_end_date' => 'nullable|date|after:due_date',
        ]);

        // Reset wa_notified jika tanggal atau jam deadline berubah
        $dateChanged = $task->due_date->format('Y-m-d') !== $validated['due_date'];
        $timeChanged = $task->due_time !== $validated['due_time'];

        if ($dateChanged || $timeChanged) {
            $validated['wa_notified'] = false;
        }

        $task->update($validated);

        if ($task->status === 'done' && $task->recurrence_type !== 'none') {
            $this->createNextRecurrence($task);
        }

        return redirect()->route('tasks.index')
            ->with('success', '✅ Task berhasil diupdate!');
    }

    public function destroy(Task $task)
    {
        // Check ownership
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', '🗑️ Task berhasil dihapus!');
    }

    public function toggleStatus(Request $request, Task $task)
    {
        // Check ownership
        if ($task->user_id !== Auth::id()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            abort(403);
        }

        $newStatus = $task->status === 'pending' ? 'done' : 'pending';
        $task->status = $newStatus;
        
        // Set completed_at timestamp when marking as done
        if ($newStatus === 'done') {
            $task->completed_at = now();
        } else {
            $task->completed_at = null;
        }
        
        $task->save();

        // Recurrences are predefined, no need to create next task on completion

        // Handle AJAX request (from tasks.index)
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'status' => $task->status
            ]);
        }
        
        // Handle form submission (from tasks.show) - redirect to dashboard
        return redirect()->route('dashboard')
            ->with('success', $newStatus === 'done' ? '✅ Task ditandai selesai!' : '⏳ Task ditandai pending!');
    }

    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'selected_tasks' => 'required|array',
            'selected_tasks.*' => 'exists:tasks,id',
        ]);

        // Delete tasks belonging to user
        Task::whereIn('id', $validated['selected_tasks'])
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->route('tasks.index')
            ->with('success', '🗑️ Task terpilih berhasil dihapus!');
    }

    public function duplicate(Task $task)
    {
        // Check ownership
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')
                ->with('error', '❌ Unauthorized!');
        }

        // Create duplicate task
        $duplicateTask = $task->replicate();
        $duplicateTask->title = $task->title . ' (Copy)';
        $duplicateTask->status = 'pending';
        $duplicateTask->wa_notified = false;
        $duplicateTask->save();

        return redirect()->route('tasks.index')
            ->with('success', '📋 Task berhasil diduplikasi!');
    }

    private function createNextRecurrence(Task $task)
    {
        $nextDueDate = $task->due_date->copy();
        
        switch ($task->recurrence_type) {
            case 'daily':
                $nextDueDate->addDay();
                break;
            case 'weekly':
                $nextDueDate->addWeek();
                break;
            case 'monthly':
                $nextDueDate->addMonth();
                break;
            default:
                return;
        }

        // Check if we passed the recurrence end date
        if ($task->recurrence_end_date && $nextDueDate->gt($task->recurrence_end_date)) {
            return;
        }

        // Check if such task already exists to prevent duplicate spamming
        $exists = Task::where('user_id', $task->user_id)
            ->where('title', $task->title)
            ->where('due_date', $nextDueDate->format('Y-m-d'))
            ->where('due_time', $task->due_time)
            ->exists();

        if (!$exists) {
            $newTask = $task->replicate();
            $newTask->status = 'pending'; // Reset status
            $newTask->due_date = $nextDueDate; // Set next date
            $newTask->wa_notified = false; // Reset notification
            $newTask->save();
        }
    }
}
