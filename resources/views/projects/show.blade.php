@extends('layouts.app')

@section('title', $project->name)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    {{-- Back & Header --}}
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 animate-fade-in">
        <div>
            <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 text-white/40 hover:text-white/70 text-sm transition mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Projects
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl md:text-3xl font-bold text-white leading-tight">{{ $project->name }}</h1>
                @if($project->status === 'completed')
                <span class="px-2.5 py-1 bg-emerald-500/20 text-emerald-400 rounded-lg text-[10px] font-bold uppercase tracking-wider border border-emerald-500/20">Selesai</span>
                @elseif($project->status === 'on_hold')
                <span class="px-2.5 py-1 bg-amber-500/20 text-amber-400 rounded-lg text-[10px] font-bold uppercase tracking-wider border border-amber-500/20">Ditunda</span>
                @else
                <span class="px-2.5 py-1 bg-violet-500/20 text-violet-300 rounded-lg text-[10px] font-bold uppercase tracking-wider border border-violet-500/20">Aktif</span>
                @endif
            </div>
            @if($project->description)
            <p class="text-white/50 text-sm mt-2 max-w-2xl">{{ $project->description }}</p>
            @endif
        </div>
        
        <div class="flex items-center gap-2">
            <a href="{{ route('projects.edit', $project) }}" class="btn-ghost px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                <lord-icon src="https://cdn.lordicon.com/wuvorxbv.json" trigger="hover" colors="primary:#9ca3af,secondary:#d1d5db" style="width:18px;height:18px"></lord-icon>
                Edit
            </a>
            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus project ini? Semua task didalamnya akan ikut terhapus.')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-ghost px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 text-red-400 hover:text-red-300 hover:bg-red-500/10">
                    <lord-icon src="https://cdn.lordicon.com/kfzfxczd.json" trigger="hover" colors="primary:#f87171,secondary:#fca5a5" style="width:18px;height:18px"></lord-icon>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 animate-fade-in" style="animation-delay: 0.1s;">
        <div class="glass-card p-5">
            <p class="text-white/30 text-xs font-medium uppercase tracking-widest mb-1">Total Task</p>
            <p class="text-3xl font-bold text-white">{{ $project->total_tasks }}</p>
        </div>
        <div class="glass-card p-5 border border-emerald-500/20" style="background: rgba(16, 185, 129, 0.03);">
            <p class="text-emerald-400/50 text-xs font-medium uppercase tracking-widest mb-1">Selesai</p>
            <p class="text-3xl font-bold text-emerald-400">{{ $project->completed_tasks }}</p>
        </div>
        <div class="glass-card p-5 border border-amber-500/20" style="background: rgba(245, 158, 11, 0.03);">
            <p class="text-amber-400/50 text-xs font-medium uppercase tracking-widest mb-1">Pending</p>
            <p class="text-3xl font-bold text-amber-400">{{ $project->pending_tasks }}</p>
        </div>
        <div class="glass-card p-5 border border-violet-500/20" style="background: rgba(139, 92, 246, 0.03);">
            <div class="flex items-center justify-between mb-1">
                <p class="text-violet-400/50 text-xs font-medium uppercase tracking-widest">Progress</p>
                <span class="text-sm font-bold text-violet-400">{{ $project->progress }}%</span>
            </div>
            <div class="w-full bg-white/5 rounded-full h-2 mt-4">
                <div class="bg-gradient-to-r from-violet-500 to-indigo-500 h-2 rounded-full transition-all duration-500" style="width: {{ $project->progress }}%"></div>
            </div>
        </div>
    </div>

    {{-- Tasks List --}}
    <div class="glass-card p-4 md:p-6 animate-fade-in" style="animation-delay: 0.2s;">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <lord-icon src="https://cdn.lordicon.com/bjgdeprq.json" trigger="hover" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:24px;height:24px"></lord-icon>
                Daftar Task
            </h2>
            <a href="{{ route('tasks.create') }}?project_id={{ $project->id }}" class="btn-primary text-white font-semibold px-4 py-2 rounded-xl inline-flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Task
            </a>
        </div>

        @if($project->tasks->isEmpty())
        <div class="text-center py-12 bg-white/5 rounded-2xl border border-white/5">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-violet-500/10 flex items-center justify-center">
                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:36px;height:36px"></lord-icon>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Belum ada task</h3>
            <p class="text-white/30 text-sm">Project ini belum memiliki task apapun.</p>
        </div>
        @else
        <div class="space-y-2">
            @foreach($project->tasks as $task)
            <div class="glass-card-light p-4 flex flex-col sm:flex-row sm:items-center gap-4 transition hover:bg-white/[0.08]" id="taskCard-{{ $task->id }}">
                <div class="flex-1 min-w-0">
                    <div class="flex items-start gap-3">
                        <button onclick="toggleTask({{ $task->id }})" class="mt-0.5 flex-shrink-0 w-6 h-6 rounded border {{ $task->status === 'done' ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-white/20 text-transparent hover:border-emerald-500' }} flex items-center justify-center transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                        <div>
                            <a href="{{ route('tasks.show', $task) }}" class="font-medium text-sm {{ $task->status === 'done' ? 'text-white/40 line-through' : 'text-white hover:text-violet-300 transition' }}">
                                {{ $task->title }}
                            </a>
                            <div class="flex items-center gap-3 mt-1.5 text-[11px]">
                                <span class="text-white/30 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $task->due_date->format('d M') }}, {{ \Carbon\Carbon::parse($task->due_time)->format('H:i') }}
                                </span>
                                
                                @if($task->status !== 'done' && $task->isOverdue())
                                <span class="text-red-400 font-medium">⚠️ Overdue</span>
                                @endif
                                
                                @if($task->wa_notified)
                                <span class="text-emerald-400 font-medium" title="Notifikasi WA terkirim">📱 Notified</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 sm:ml-auto pl-9 sm:pl-0">
                    <a href="{{ route('tasks.edit', $task) }}" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-blue-500/20 flex items-center justify-center text-white/50 hover:text-blue-400 transition" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Hapus task ini?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-red-500/20 flex items-center justify-center text-white/50 hover:text-red-400 transition" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function toggleTask(taskId) {
    const card = document.getElementById('taskCard-' + taskId);
    if (card) {
        card.style.opacity = '0.5';
    }
    
    fetch(`{{ url('tasks') }}/${taskId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (response.ok) {
            window.location.reload(); // Reload to update project progress calculation
        } else {
            alert('Gagal mengupdate status');
            if (card) card.style.opacity = '1';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (card) card.style.opacity = '1';
    });
}
</script>
@endpush
@endsection
