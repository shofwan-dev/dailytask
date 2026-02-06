@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
<div class="min-h-screen px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 animate-fade-in">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/osuxyevn.json"
                        trigger="loop"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:40px;height:40px">
                    </lord-icon>
                    <h1 class="text-4xl font-bold text-white">My Tasks</h1>
                </div>
                <p class="text-purple-200">Halo, {{ Auth::user()->name }}!</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('dashboard') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition backdrop-blur-sm border border-white/30 flex items-center space-x-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/jxwksgwv.json"
                        trigger="hover"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <span>Dashboard</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition backdrop-blur-sm border border-white/30 flex items-center space-x-2">
                        <lord-icon
                            src="https://cdn.lordicon.com/moscwhoj.json"
                            trigger="hover"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:20px;height:20px">
                        </lord-icon>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Add Task Button -->
        <div class="mb-6 animate-fade-in" style="animation-delay: 0.1s;">
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center space-x-2 bg-white text-purple-600 font-semibold px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transition transform hover:scale-105">
                <lord-icon
                    src="https://cdn.lordicon.com/mecwbjnp.json"
                    trigger="hover"
                    colors="primary:#9333ea,secondary:#e9d5ff"
                    style="width:20px;height:20px">
                </lord-icon>
                <span>Tambah Task Baru</span>
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 animate-fade-in" style="animation-delay: 0.2s;">
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Tasks</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $tasks->count() }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg flex items-center justify-center">
                        <lord-icon
                            src="https://cdn.lordicon.com/osuxyevn.json"
                            trigger="hover"
                            colors="primary:#9333ea,secondary:#e9d5ff"
                            style="width:32px;height:32px">
                        </lord-icon>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pending</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $tasks->where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-lg flex items-center justify-center">
                        <lord-icon
                            src="https://cdn.lordicon.com/kbtmbyzy.json"
                            trigger="hover"
                            colors="primary:#ca8a04,secondary:#fef08a"
                            style="width:32px;height:32px">
                        </lord-icon>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Completed</p>
                        <p class="text-3xl font-bold text-green-600 mt-1">{{ $tasks->where('status', 'done')->count() }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg flex items-center justify-center">
                        <lord-icon
                            src="https://cdn.lordicon.com/egiwmiit.json"
                            trigger="hover"
                            colors="primary:#16a34a,secondary:#bbf7d0"
                            style="width:32px;height:32px">
                        </lord-icon>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks List -->
        <div class="space-y-4">
            <!-- Toolbar -->
            <div class="bg-white rounded-lg p-4 shadow-sm flex items-center justify-between animate-fade-in mb-4">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 w-5 h-5" onclick="toggleSelectAll()">
                    <span class="text-sm font-medium text-gray-700">Pilih Semua</span>
                </div>
                <button type="submit" form="bulkDeleteForm" id="bulkDeleteBtn" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition opacity-50 cursor-not-allowed flex items-center space-x-2" disabled>
                    <lord-icon
                        src="https://cdn.lordicon.com/kfzfxczd.json"
                        trigger="hover"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:18px;height:18px">
                    </lord-icon>
                    <span>Hapus Terpilih</span>
                </button>
            </div>
            
            <form id="bulkDeleteForm" action="{{ route('tasks.bulk_destroy') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus task yang dipilih?')">
                @csrf
            </form>
            @forelse($tasks as $index => $task)
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover animate-fade-in" style="animation-delay: {{ 0.3 + ($index * 0.05) }}s;">
                <div class="flex items-start space-x-4">
                    <!-- Selection Checkbox (Integrated) -->
                    <div class="flex-shrink-0 pt-1">
                        <input type="checkbox" name="selected_tasks[]" value="{{ $task->id }}" form="bulkDeleteForm" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 w-5 h-5 task-checkbox" onchange="updateBulkBtn()">
                    </div>

                    <!-- Task Content -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-semibold text-gray-800 {{ $task->status === 'done' ? 'line-through text-gray-400' : '' }}">
                            {{ $task->title }}
                        </h3>
                        
                        @if($task->description)
                        <p class="text-gray-600 mt-1 {{ $task->status === 'done' ? 'line-through text-gray-400' : '' }}">
                            {{ $task->description }}
                        </p>
                        @endif

                        <div class="flex flex-wrap items-center gap-3 mt-3">
                            <!-- Date -->
                            <span class="inline-flex items-center space-x-1 text-sm text-gray-500">
                                <lord-icon
                                    src="https://cdn.lordicon.com/kbtmbyzy.json"
                                    trigger="hover"
                                    colors="primary:#9ca3af,secondary:#d1d5db"
                                    style="width:20px;height:20px">
                                </lord-icon>
                                <span>{{ $task->due_date->format('d M Y') }}</span>
                            </span>

                            <!-- Time -->
                            <span class="inline-flex items-center space-x-1 text-sm text-gray-500">
                                <lord-icon
                                    src="https://cdn.lordicon.com/lupuorrc.json"
                                    trigger="hover"
                                    colors="primary:#9ca3af,secondary:#d1d5db"
                                    style="width:20px;height:20px">
                                </lord-icon>
                                <span>{{ \Carbon\Carbon::parse($task->due_time)->format('H:i') }}</span>
                            </span>

                            <!-- Status Badge -->
                            @if($task->status === 'pending')
                                @if($task->isOverdue())
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    ⚠️ Overdue
                                </span>
                                @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                    ⏳ Pending
                                </span>
                                @endif
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                ✅ Done
                            </span>
                            @endif

                            <!-- WhatsApp Notified -->
                            @if($task->wa_notified)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                📱 Notified
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex-shrink-0 flex items-center space-x-2">
                        <!-- Toggle Status Button -->
                        <button onclick="toggleTask({{ $task->id }})" class="p-2 rounded-lg hover:bg-gray-100 transition group" title="{{ $task->status === 'done' ? 'Tandai Pending' : 'Tandai Selesai' }}">
                            @if($task->status === 'done')
                            <lord-icon
                                src="https://cdn.lordicon.com/egiwmiit.json"
                                trigger="hover"
                                colors="primary:#16a34a,secondary:#bbf7d0"
                                style="width:24px;height:24px">
                            </lord-icon>
                            @else
                            <lord-icon
                                src="https://cdn.lordicon.com/egiwmiit.json"
                                trigger="hover"
                                colors="primary:#9ca3af,secondary:#d1d5db"
                                style="width:24px;height:24px">
                            </lord-icon>
                            @endif
                        </button>

                        <!-- Edit Button -->
                        <a href="{{ route('tasks.edit', $task) }}" class="p-2 rounded-lg hover:bg-blue-50 transition text-blue-500 hover:text-blue-700" title="Edit Task">
                            <lord-icon
                                src="https://cdn.lordicon.com/wuvorxbv.json"
                                trigger="hover"
                                colors="primary:#3b82f6,secondary:#bfdbfe"
                                style="width:24px;height:24px">
                            </lord-icon>
                        </a>

                        <!-- Delete Button -->
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Yakin ingin menghapus task ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transition p-2 rounded-lg hover:bg-red-50" title="Hapus Task">
                                <lord-icon
                                    src="https://cdn.lordicon.com/kfzfxczd.json"
                                    trigger="hover"
                                    colors="primary:#ef4444,secondary:#fecaca"
                                    style="width:24px;height:24px">
                                </lord-icon>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl shadow-lg p-12 text-center animate-fade-in">
                <div class="inline-block p-6 bg-purple-100 rounded-full mb-4">
                    <div class="flex items-center justify-center">
                        <lord-icon
                            src="https://cdn.lordicon.com/msoeawqm.json"
                            trigger="loop"
                            colors="primary:#9333ea,secondary:#e9d5ff"
                            style="width:64px;height:64px">
                        </lord-icon>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada task</h3>
                <p class="text-gray-600 mb-6">Mulai tambahkan task pertama Anda!</p>
                <a href="{{ route('tasks.create') }}" class="inline-flex items-center space-x-2 btn-primary text-white font-semibold px-6 py-3 rounded-lg shadow-lg">
                <lord-icon
                    src="https://cdn.lordicon.com/mecwbjnp.json"
                    trigger="hover"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:20px;height:20px">
                </lord-icon>
                    <span>Tambah Task</span>
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleTask(taskId) {
    fetch(`{{ url('tasks') }}/${taskId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal mengupdate status task');
    });
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.task-checkbox');
    
    checkboxes.forEach(cb => {
        cb.checked = selectAll.checked;
    });
    
    updateBulkBtn();
}

function updateBulkBtn() {
    const checkboxes = document.querySelectorAll('.task-checkbox:checked');
    const btn = document.getElementById('bulkDeleteBtn');
    
    if (checkboxes.length > 0) {
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');
    } else {
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
    }
    
    // Update Select All state logic
    const allCheckboxes = document.querySelectorAll('.task-checkbox');
    const selectAll = document.getElementById('selectAll');
    if (checkboxes.length === allCheckboxes.length && allCheckboxes.length > 0) {
        selectAll.checked = true;
        selectAll.indeterminate = false;
    } else if (checkboxes.length > 0) {
        selectAll.checked = false;
        selectAll.indeterminate = true;
    } else {
        selectAll.checked = false;
        selectAll.indeterminate = false;
    }
}
</script>
@endpush
@endsection
