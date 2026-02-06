<?php

namespace App\Http\Controllers;

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

    public function index()
    {
        $tasks = Auth::user()->tasks()
            ->orderBy('due_date')
            ->orderBy('due_time')
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function edit(Task $task)
    {
        // Check ownership
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        return view('tasks.edit', compact('task'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'due_time' => 'required',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        Task::create($validated);

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
        ]);

        $task->update($validated);

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

    public function toggleStatus(Task $task)
    {
        // Check ownership
        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->status = $task->status === 'pending' ? 'done' : 'pending';
        $task->save();

        return response()->json([
            'success' => true,
            'status' => $task->status
        ]);
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
}
