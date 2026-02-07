@extends('layouts.app')

@section('title', $project->name)

@section('content')
<div class="min-h-screen px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-8 animate-fade-in">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/fhtaantg.json"
                        trigger="loop"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:40px;height:40px">
                    </lord-icon>
                    <h1 class="text-3xl md:text-4xl font-bold text-white">{{ $project->name }}</h1>
                </div>
                @if($project->description)
                <p class="text-purple-200">{{ $project->description }}</p>
                @endif
            </div>
            <div class="flex flex-wrap gap-2 md:gap-3">
                <a href="{{ route('projects.edit', $project) }}" class="bg-white text-purple-600 hover:bg-purple-50 px-4 py-2 rounded-lg transition font-semibold flex items-center space-x-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/wuvorxbv.json"
                        trigger="hover"
                        colors="primary:#9333ea,secondary:#9333ea"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <span>Edit</span>
                </a>
                <a href="{{ route('projects.index') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition backdrop-blur-sm border border-white/30 flex items-center space-x-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/wmwqvixz.json"
                        trigger="hover"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <span>Kembali</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-6 mb-8 animate-fade-in" style="animation-delay: 0.1s;">
            <!-- Status -->
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Status</p>
                        @if($project->status === 'completed')
                        <p class="text-xl font-bold text-green-600 mt-1">Selesai</p>
                        @elseif($project->status === 'on_hold')
                        <p class="text-xl font-bold text-yellow-600 mt-1">Ditunda</p>
                        @else
                        <p class="text-xl font-bold text-purple-600 mt-1">Aktif</p>
                        @endif
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <lord-icon
                            src="https://cdn.lordicon.com/fhtaantg.json"
                            trigger="hover"
                            colors="primary:#9333ea,secondary:#e9d5ff"
                            style="width:32px;height:32px">
                        </lord-icon>
                    </div>
                </div>
            </div>

            <!-- Total Tasks -->
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Tasks</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $project->total_tasks }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <lord-icon
                            src="https://cdn.lordicon.com/osuxyevn.json"
                            trigger="hover"
                            colors="primary:#9333ea,secondary:#e9d5ff"
                            style="width:32px;height:32px">
                        </lord-icon>
                    </div>
                </div>
            </div>

            <!-- Completed -->
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Selesai</p>
                        <p class="text-3xl font-bold text-green-600 mt-1">{{ $project->completed_tasks }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <lord-icon
                            src="https://cdn.lordicon.com/egiwmiit.json"
                            trigger="hover"
                            colors="primary:#16a34a,secondary:#bbf7d0"
                            style="width:32px;height:32px">
                        </lord-icon>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pending</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $project->pending_tasks }}</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <lord-icon
                            src="https://cdn.lordicon.com/kbtmbyzy.json"
                            trigger="hover"
                            colors="primary:#ca8a04,secondary:#fef08a"
                            style="width:32px;height:32px">
                        </lord-icon>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="bg-white rounded-xl p-6 shadow-lg mb-8 animate-fade-in" style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Progress Project</h2>
                <span class="text-2xl font-bold text-purple-600">{{ $project->progress }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 h-4 rounded-full transition-all duration-500 flex items-center justify-end pr-2" style="width: {{ $project->progress }}%">
                    @if($project->progress > 10)
                    <span class="text-white text-xs font-bold">{{ $project->progress }}%</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tasks List -->
        <div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in" style="animation-delay: 0.3s;">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800">Tasks</h2>
                <a href="{{ route('tasks.create') }}?project_id={{ $project->id }}" class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition font-semibold flex items-center space-x-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/mecwbjnp.json"
                        trigger="hover"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <span>Tambah Task</span>
                </a>
            </div>

            @if($project->tasks->isEmpty())
            <div class="text-center py-12">
                <lord-icon
                    src="https://cdn.lordicon.com/osuxyevn.json"
                    trigger="loop"
                    colors="primary:#9333ea,secondary:#e9d5ff"
                    style="width:64px;height:64px;margin:0 auto">
                </lord-icon>
                <h3 class="text-lg font-bold text-gray-800 mt-4 mb-2">Belum Ada Task</h3>
                <p class="text-gray-600 mb-4">Mulai dengan menambahkan task pertama untuk project ini</p>
                <a href="{{ route('tasks.create') }}?project_id={{ $project->id }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transition">
                    <lord-icon
                        src="https://cdn.lordicon.com/mecwbjnp.json"
                        trigger="hover"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <span>Tambah Task</span>
                </a>
            </div>
            @else
            <div class="space-y-3">
                @foreach($project->tasks as $task)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="font-semibold text-gray-800">{{ $task->title }}</h3>
                                @if($task->status === 'done')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">✓ Selesai</span>
                                @elseif($task->isOverdue())
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">⚠️ Terlambat</span>
                                @else
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">⏳ Pending</span>
                                @endif
                            </div>
                            @if($task->description)
                            <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $task->description }}</p>
                            @endif
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span>📅 {{ $task->due_date->format('d M Y') }}</span>
                                <span>🕐 {{ $task->due_time }}</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <!-- Edit Button -->
                            <a href="{{ route('tasks.edit', $task) }}" class="bg-blue-100 hover:bg-blue-200 text-blue-600 px-3 py-2 rounded-lg transition" title="Edit Task">
                                <lord-icon
                                    src="https://cdn.lordicon.com/wuvorxbv.json"
                                    trigger="hover"
                                    colors="primary:#2563eb,secondary:#2563eb"
                                    style="width:20px;height:20px">
                                </lord-icon>
                            </a>

                            <!-- Toggle Status Button (AJAX) -->
                            <button onclick="toggleTask({{ $task->id }})" class="bg-{{ $task->status === 'done' ? 'yellow' : 'green' }}-100 hover:bg-{{ $task->status === 'done' ? 'yellow' : 'green' }}-200 text-{{ $task->status === 'done' ? 'yellow' : 'green' }}-700 px-3 py-2 rounded-lg transition" title="{{ $task->status === 'done' ? 'Tandai Pending' : 'Tandai Selesai' }}">
                                @if($task->status === 'done')
                                <lord-icon
                                    src="https://cdn.lordicon.com/kbtmbyzy.json"
                                    trigger="hover"
                                    colors="primary:#ca8a04,secondary:#ca8a04"
                                    style="width:20px;height:20px">
                                </lord-icon>
                                @else
                                <lord-icon
                                    src="https://cdn.lordicon.com/egiwmiit.json"
                                    trigger="hover"
                                    colors="primary:#16a34a,secondary:#16a34a"
                                    style="width:20px;height:20px">
                                </lord-icon>
                                @endif
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus task ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-600 px-3 py-2 rounded-lg transition" title="Hapus Task">
                                    <lord-icon
                                        src="https://cdn.lordicon.com/kfzfxczd.json"
                                        trigger="hover"
                                        colors="primary:#dc2626,secondary:#dc2626"
                                        style="width:20px;height:20px">
                                    </lord-icon>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleTask(taskId) {
    // Show loading state visually if needed, but for now we just wait specifically
    
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
            // Reload page to refresh stats and order
             window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate status task');
    });
}
</script>
@endpush
