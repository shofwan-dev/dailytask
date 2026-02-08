@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="min-h-screen px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8 animate-fade-in">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/fhtaantg.json"
                        trigger="loop"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:40px;height:40px">
                    </lord-icon>
                    <h1 class="text-3xl md:text-4xl font-bold text-white">Projects</h1>
                </div>
                <p class="text-purple-200">Kelola semua project Anda</p>
            </div>
            <div class="flex flex-wrap gap-2 md:gap-3">
                <a href="{{ route('projects.create') }}" class="bg-white text-purple-600 hover:bg-purple-50 px-4 py-2 rounded-lg transition font-semibold flex items-center space-x-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/mecwbjnp.json"
                        trigger="loop"
                        colors="primary:#9333ea,secondary:#9333ea"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <span>Tambah Project</span>
                </a>
                <a href="{{ route('dashboard') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition backdrop-blur-sm border border-white/30 flex items-center space-x-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/wmwqvixz.json"
                        trigger="loop"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <span>Dashboard</span>
                </a>
            </div>
        </div>

        <!-- Projects Grid -->
        @if($projects->isEmpty())
        <div class="bg-white rounded-xl p-12 text-center shadow-lg animate-fade-in">
            <lord-icon
                src="https://cdn.lordicon.com/fhtaantg.json"
                trigger="loop"
                colors="primary:#9333ea,secondary:#e9d5ff"
                style="width:80px;height:80px;margin:0 auto">
            </lord-icon>
            <h3 class="text-xl font-bold text-gray-800 mt-4 mb-2">Belum Ada Project</h3>
            <p class="text-gray-600 mb-6">Mulai dengan membuat project pertama Anda</p>
            <a href="{{ route('projects.create') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transition">
                <lord-icon
                    src="https://cdn.lordicon.com/mecwbjnp.json"
                    trigger="loop"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:20px;height:20px">
                </lord-icon>
                <span>Buat Project Baru</span>
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fade-in">
            @foreach($projects as $project)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <!-- Project Header -->
                <div class="p-6 {{ $project->status === 'completed' ? 'bg-green-50' : ($project->status === 'on_hold' ? 'bg-yellow-50' : 'bg-purple-50') }}">
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="text-xl font-bold text-gray-800 flex-1 pr-2">{{ $project->name }}</h3>
                        @if($project->status === 'completed')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Selesai</span>
                        @elseif($project->status === 'on_hold')
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Ditunda</span>
                        @else
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">Aktif</span>
                        @endif
                    </div>
                    @if($project->description)
                    <p class="text-gray-600 text-sm line-clamp-2">{{ $project->description }}</p>
                    @endif
                </div>

                <!-- Progress Bar -->
                <div class="px-6 py-4 bg-gray-50">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-700">Progress</span>
                        <span class="text-sm font-bold text-purple-600">{{ $project->progress }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $project->progress }}%"></div>
                    </div>
                </div>

                <!-- Stats - Horizontal Layout -->
                <div class="px-6 py-4 border-t border-gray-100">
                    <div class="flex items-center justify-between gap-3">
                        <!-- Total Tasks -->
                        <div class="flex items-center space-x-2">
                            <lord-icon
                                src="https://cdn.lordicon.com/osuxyevn.json"
                                trigger="hover"
                                colors="primary:#6b7280,secondary:#9ca3af"
                                style="width:20px;height:20px">
                            </lord-icon>
                            <div>
                                <p class="text-lg font-bold text-gray-800">{{ $project->total_tasks }}</p>
                                <p class="text-xs text-gray-500">Total</p>
                            </div>
                        </div>

                        <!-- Completed -->
                        <div class="flex items-center space-x-2">
                            <lord-icon
                                src="https://cdn.lordicon.com/egiwmiit.json"
                                trigger="hover"
                                colors="primary:#16a34a,secondary:#bbf7d0"
                                style="width:20px;height:20px">
                            </lord-icon>
                            <div>
                                <p class="text-lg font-bold text-green-600">{{ $project->completed_tasks }}</p>
                                <p class="text-xs text-gray-500">Selesai</p>
                            </div>
                        </div>

                        <!-- Pending -->
                        <div class="flex items-center space-x-2">
                            <lord-icon
                                src="https://cdn.lordicon.com/kbtmbyzy.json"
                                trigger="hover"
                                colors="primary:#ca8a04,secondary:#fef08a"
                                style="width:20px;height:20px">
                            </lord-icon>
                            <div>
                                <p class="text-lg font-bold text-yellow-600">{{ $project->pending_tasks }}</p>
                                <p class="text-xs text-gray-500">Pending</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                @if($project->start_date || $project->end_date)
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                    <div class="flex items-center justify-between text-xs text-gray-600">
                        @if($project->start_date)
                        <span>📅 {{ $project->start_date->format('d M Y') }}</span>
                        @endif
                        @if($project->end_date)
                        <span>🏁 {{ $project->end_date->format('d M Y') }}</span>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="px-6 py-4 bg-white flex flex-wrap gap-2">
                    <a href="{{ route('projects.show', $project) }}" class="bg-sky-100 hover:bg-sky-200 text-sky-600 px-3 py-2 rounded-lg transition border border-blue-200 flex items-center justify-center" title="Lihat Detail">
                        <lord-icon
                            src="https://cdn.lordicon.com/msoeawqm.json"
                            trigger="loop"
                            colors="primary:#0284c7,secondary:#0284c7"
                            style="width:20px;height:20px">
                        </lord-icon>
                    </a>
                    
                    <a href="{{ route('projects.edit', $project) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-2 rounded-lg transition border border-blue-200 flex items-center justify-center" title="Edit Project">
                        <lord-icon
                            src="https://cdn.lordicon.com/wuvorxbv.json"
                            trigger="loop"
                            colors="primary:#4b5563,secondary:#4b5563"
                            style="width:20px;height:20px">
                        </lord-icon>
                    </a>
                    
                    <form action="{{ route('projects.duplicate', $project) }}" method="POST" class="inline-flex">
                        @csrf
                        <button type="submit" class="bg-blue-100 hover:bg-blue-200 text-blue-600 px-3 py-2 rounded-lg transition border border-blue-200 flex items-center justify-center" title="Duplikat Project">
                            <lord-icon
                                src="https://cdn.lordicon.com/puvaffet.json"
                                trigger="loop"
                                colors="primary:#2563eb,secondary:#2563eb"
                                style="width:20px;height:20px">
                            </lord-icon>
                        </button>
                    </form>
                    
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus project ini? Semua task terkait juga akan dihapus.')" class="inline-flex">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-600 px-3 py-2 rounded-lg transition border border-red-200 flex items-center justify-center" title="Hapus Project">
                            <lord-icon
                                src="https://cdn.lordicon.com/wpyrrmcq.json"
                                trigger="loop"
                                colors="primary:#dc2626,secondary:#dc2626"
                                style="width:20px;height:20px">
                            </lord-icon>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
