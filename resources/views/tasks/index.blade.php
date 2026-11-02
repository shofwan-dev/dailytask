@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 animate-fade-in">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-white">My Tasks</h1>
            <p class="text-white/30 text-sm mt-1">Kelola semua task Anda</p>
        </div>
        <a href="{{ route('tasks.create') }}" class="btn-primary text-white font-semibold px-5 py-2.5 rounded-xl inline-flex items-center gap-2 text-sm w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Task
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-3 animate-fade-in" style="animation-delay: 0.05s;">
        <div class="stat-card">
            <p class="text-2xl font-bold text-white">{{ $tasks->count() }}</p>
            <p class="text-white/30 text-xs font-medium">Total</p>
        </div>
        <div class="stat-card">
            <p class="text-2xl font-bold text-amber-400">{{ $tasks->where('status', 'pending')->count() }}</p>
            <p class="text-white/30 text-xs font-medium">Pending</p>
        </div>
        <div class="stat-card">
            <p class="text-2xl font-bold text-emerald-400">{{ $tasks->where('status', 'done')->count() }}</p>
            <p class="text-white/30 text-xs font-medium">Selesai</p>
        </div>
    </div>

    {{-- Toolbar: Filter + Bulk Actions --}}
    <div class="glass-card p-3 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 animate-fade-in" style="animation-delay: 0.1s;">
        <div class="flex items-center gap-3 flex-wrap">
            <div class="flex items-center gap-2">
                <input type="checkbox" id="selectAll" class="checkbox-custom" onclick="toggleSelectAll()">
                <span class="text-white/40 text-xs font-medium">Pilih Semua</span>
            </div>

            <form method="GET" action="{{ route('tasks.index') }}">
                <select name="project_id" onchange="this.form.submit()" class="bg-white/5 border border-white/10 text-white/70 text-xs rounded-lg px-3 py-2 focus:ring-violet-500 focus:border-violet-500 cursor-pointer" style="background-color: rgba(255,255,255,0.03);">
                    <option value="" style="background: #1a1a3e;">Semua Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }} style="background: #1a1a3e;">
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <button type="submit" form="bulkDeleteForm" id="bulkDeleteBtn" class="text-red-400/50 hover:text-red-400 px-3 py-2 rounded-lg text-xs font-medium transition flex items-center gap-2 cursor-not-allowed opacity-50" disabled>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Hapus Terpilih
        </button>
    </div>
    
    <form id="bulkDeleteForm" action="{{ route('tasks.bulk_destroy') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus task yang dipilih?')">
        @csrf
    </form>

    {{-- Quick Add --}}
    <form method="POST" action="{{ route('tasks.store') }}" class="glass-card p-3 flex items-center gap-3 animate-fade-in" style="animation-delay: 0.12s;" id="quickAddForm">
        @csrf
        <div class="w-8 h-8 rounded-lg bg-violet-500/15 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
        </div>
        <input type="text" name="title" required class="flex-1 bg-transparent text-white text-sm outline-none placeholder:text-white/20" placeholder="Ketik task baru, tekan Enter...">
        <input type="hidden" name="due_date" value="{{ date('Y-m-d') }}">
        <input type="hidden" name="due_time" value="17:00">
        <input type="hidden" name="recurrence_type" value="none">
        <button type="submit" class="text-violet-400 hover:text-violet-300 text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-violet-500/10 transition hidden sm:block">
            Enter ↵
        </button>
        <button type="submit" class="sm:hidden w-8 h-8 rounded-lg bg-violet-500/20 hover:bg-violet-500/30 text-violet-300 flex items-center justify-center transition flex-shrink-0" title="Tambah Task">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
        </button>
    </form>

    {{-- Pending Tasks --}}
    <div class="space-y-2" id="pendingTasksList">
        <h2 class="text-sm font-bold text-white/40 uppercase tracking-widest flex items-center gap-2 mb-3 animate-fade-in" style="animation-delay: 0.15s;">
            <div class="w-2 h-2 rounded-full bg-amber-400"></div>
            Task Aktif
        </h2>
        
        @php $pendingTasks = $tasks->where('status', 'pending'); @endphp
        
        @forelse($pendingTasks as $index => $task)
        <div class="glass-card p-4 card-hover animate-fade-in task-card" style="animation-delay: {{ 0.15 + ($index * 0.03) }}s;" data-task-id="{{ $task->id }}" id="taskCard-{{ $task->id }}">
            <div class="flex items-start gap-3">
                {{-- Checkbox --}}
                <div class="flex-shrink-0 pt-0.5">
                    <input type="checkbox" name="selected_tasks[]" value="{{ $task->id }}" form="bulkDeleteForm" class="checkbox-custom task-checkbox" onchange="updateBulkBtn()">
                </div>

                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <h3 class="text-white font-medium text-sm break-words flex-1">{{ $task->title }}</h3>
                        
                        {{-- Toggle Button --}}
                        <button onclick="toggleTask({{ $task->id }}, this)" class="flex-shrink-0 w-7 h-7 rounded-lg bg-white/5 hover:bg-emerald-500/15 flex items-center justify-center text-white/20 hover:text-emerald-400 transition group" title="Tandai Selesai">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    @if($task->description)
                    <p class="text-white/30 text-xs mt-1 line-clamp-2 break-words">{{ $task->description }}</p>
                    @endif

                    <div class="flex flex-wrap items-center gap-2 mt-2.5">
                        {{-- Project Badge --}}
                        @if($task->project)
                        <a href="{{ route('projects.show', $task->project) }}" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-violet-500/10 text-violet-400 hover:bg-violet-500/20 transition">
                            📁 {{ $task->project->name }}
                        </a>
                        @endif

                        {{-- Date --}}
                        <span class="text-white/25 text-[11px] flex items-center gap-1">
                            📅 {{ $task->due_date->format('d M') }}
                        </span>

                        {{-- Time --}}
                        <span class="text-white/25 text-[11px]">
                            ⏰ {{ \Carbon\Carbon::parse($task->due_time)->format('H:i') }}
                        </span>

                        {{-- Recurring --}}
                        @if($task->recurrence_type !== 'none')
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-500/10 text-blue-400">
                            🔄 {{ ucfirst($task->recurrence_type) }}
                        </span>
                        @endif

                        {{-- Status --}}
                        @if($task->isOverdue())
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-500/10 text-red-400 animate-pulse">
                            ⚠️ Overdue
                        </span>
                        @else
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-500/10 text-amber-400">
                            ⏳ Pending
                        </span>
                        @endif

                        @if($task->wa_notified)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400">
                            📱
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-1 mt-3 pt-3 border-t border-white/5 justify-end">
                <a href="{{ route('tasks.show', $task) }}" class="btn-ghost px-2.5 py-1.5 rounded-lg text-[11px] font-medium flex items-center gap-1" title="Detail">
                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="hover" colors="primary:#9ca3af,secondary:#d1d5db" style="width:14px;height:14px"></lord-icon>
                    Detail
                </a>
                <a href="{{ route('tasks.edit', $task) }}" class="btn-ghost px-2.5 py-1.5 rounded-lg text-[11px] font-medium flex items-center gap-1" title="Edit">
                    <lord-icon src="https://cdn.lordicon.com/wuvorxbv.json" trigger="hover" colors="primary:#60a5fa,secondary:#93c5fd" style="width:14px;height:14px"></lord-icon>
                    Edit
                </a>
                <form method="POST" action="{{ route('tasks.duplicate', $task) }}" class="inline">
                    @csrf
                    <button type="submit" class="btn-ghost px-2.5 py-1.5 rounded-lg text-[11px] font-medium flex items-center gap-1" title="Duplikat">
                        <lord-icon src="https://cdn.lordicon.com/puvaffet.json" trigger="hover" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:14px;height:14px"></lord-icon>
                        Copy
                    </button>
                </form>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Yakin ingin menghapus task ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-2.5 py-1.5 rounded-lg text-[11px] font-medium flex items-center gap-1 text-red-400/50 hover:text-red-400 hover:bg-red-500/10 transition border border-transparent hover:border-red-500/15" title="Hapus">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="glass-card p-12 text-center animate-fade-in">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-violet-500/10 flex items-center justify-center">
                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:36px;height:36px"></lord-icon>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Belum ada task aktif</h3>
            <p class="text-white/30 text-sm mb-5">Semua task sudah selesai atau mulai tambahkan task baru!</p>
            <a href="{{ route('tasks.create') }}" class="btn-primary text-white font-semibold px-5 py-2.5 rounded-xl inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Task
            </a>
        </div>
        @endforelse
    </div>

    {{-- Completed Tasks --}}
    @php $completedTasks = $tasks->where('status', 'done'); @endphp
    
    @if($completedTasks->count() > 0)
    <div class="space-y-2 mt-6" id="completedTasksList">
        <h2 class="text-sm font-bold text-white/40 uppercase tracking-widest flex items-center gap-2 mb-3">
            <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
            Task Selesai
            <span class="text-white/20 text-xs font-normal">({{ $completedTasks->count() }})</span>
        </h2>
        
        @foreach($completedTasks as $index => $task)
        <div class="glass-card p-4 animate-fade-in task-card" style="animation-delay: {{ 0.15 + ($index * 0.03) }}s;" data-task-id="{{ $task->id }}" id="taskCard-{{ $task->id }}">
            <div class="flex items-start gap-3">
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <h3 class="text-white/30 font-medium text-sm break-words flex-1 line-through">{{ $task->title }}</h3>
                        
                        {{-- Toggle Button (undo) --}}
                        <button onclick="toggleTask({{ $task->id }}, this)" class="flex-shrink-0 w-7 h-7 rounded-lg bg-emerald-500/15 flex items-center justify-center text-emerald-400 hover:bg-amber-500/15 hover:text-amber-400 transition" title="Tandai Pending">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        @if($task->completed_at)
                        <span class="text-emerald-400/60 text-[11px] flex items-center gap-1">
                            ✅ {{ $task->completed_at->format('d M Y, H:i') }}
                        </span>
                        @endif
                        <span class="text-white/20 text-[11px]">
                            Target: {{ $task->due_date->format('d M Y') }}
                        </span>
                        @if($task->project)
                        <span class="text-violet-400/40 text-[10px]">
                            📁 {{ $task->project->name }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-1 mt-3 pt-3 border-t border-white/5 justify-end">
                <a href="{{ route('tasks.show', $task) }}" class="btn-ghost px-2.5 py-1.5 rounded-lg text-[11px] font-medium" title="Detail">Detail</a>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Yakin ingin menghapus task ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-2.5 py-1.5 rounded-lg text-[11px] font-medium text-red-400/40 hover:text-red-400 hover:bg-red-500/10 transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@push('scripts')
<script>
// Toggle task WITHOUT page reload
function toggleTask(taskId, btn) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    // Optimistic UI: immediately move card
    const card = document.getElementById('taskCard-' + taskId);
    if (card) {
        card.style.opacity = '0.5';
        card.style.transform = 'scale(0.98)';
        card.style.transition = 'all 0.3s ease';
    }
    
    fetch(`{{ url('tasks') }}/${taskId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network error');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Smooth transition: hide card then reload to reposition
            if (card) {
                card.style.opacity = '0';
                card.style.transform = 'translateX(50px) scale(0.95)';
                setTimeout(() => location.reload(), 300);
            }
        } else {
            // Revert
            if (card) {
                card.style.opacity = '1';
                card.style.transform = 'none';
            }
            showToast('Gagal mengupdate status task', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (card) {
            card.style.opacity = '1';
            card.style.transform = 'none';
        }
        showToast('Gagal mengupdate status task', 'error');
    });
}

function showToast(message, type = 'success') {
    const existing = document.getElementById('toastContainer');
    if (existing) existing.remove();
    
    const icon = type === 'success' ? '✅' : '❌';
    const borderClass = type === 'success' ? 'toast-success' : 'toast-error';
    
    const html = `
        <div class="toast-container animate-fade-in" id="toastContainer">
            <div class="toast ${borderClass}">
                <span>${icon}</span>
                <span class="text-white text-sm font-medium">${message}</span>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', html);
    setTimeout(() => {
        const el = document.getElementById('toastContainer');
        if (el) {
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 300);
        }
    }, 3000);
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.task-checkbox');
    checkboxes.forEach(cb => cb.checked = selectAll.checked);
    updateBulkBtn();
}

function updateBulkBtn() {
    const checkboxes = document.querySelectorAll('.task-checkbox:checked');
    const btn = document.getElementById('bulkDeleteBtn');
    
    if (checkboxes.length > 0) {
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');
        btn.classList.add('hover:bg-red-500/10');
    } else {
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        btn.classList.remove('hover:bg-red-500/10');
    }
    
    const allCheckboxes = document.querySelectorAll('.task-checkbox');
    const selectAll = document.getElementById('selectAll');
    if (checkboxes.length === allCheckboxes.length && allCheckboxes.length > 0) {
        selectAll.checked = true;
    } else {
        selectAll.checked = false;
    }
}
</script>
@endpush
@endsection
