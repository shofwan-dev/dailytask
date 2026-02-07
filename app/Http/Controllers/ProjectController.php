<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())
            ->withCount('tasks')
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,completed,on_hold',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $validated['user_id'] = Auth::id();

        Project::create($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dibuat!');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        // Ensure user owns this project
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        $project->load(['tasks' => function ($query) {
            $query->latest();
        }]);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        // Ensure user owns this project
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        // Ensure user owns this project
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,completed,on_hold',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil diupdate!');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        // Ensure user owns this project
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dihapus!');
    }

    /**
     * Duplicate the specified project with its tasks.
     */
    public function duplicate(Project $project)
    {
        // Ensure user owns this project
        if ($project->user_id !== Auth::id()) {
            return redirect()->route('projects.index')
                ->with('error', '❌ Unauthorized!');
        }

        // Create duplicate project
        $duplicateProject = $project->replicate();
        $duplicateProject->name = $project->name . ' (Copy)';
        $duplicateProject->status = 'active'; // Reset to active
        $duplicateProject->save();

        // Duplicate all tasks from the original project
        $tasks = $project->tasks;
        foreach ($tasks as $task) {
            $duplicateTask = $task->replicate();
            $duplicateTask->project_id = $duplicateProject->id;
            $duplicateTask->status = 'pending'; // Reset to pending
            $duplicateTask->wa_notified = false; // Reset notification status
            $duplicateTask->save();
        }

        return redirect()->route('projects.show', $duplicateProject)
            ->with('success', '📋 Project berhasil diduplikasi beserta ' . $tasks->count() . ' task!');
    }
}
