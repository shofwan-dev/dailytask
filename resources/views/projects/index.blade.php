@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 animate-fade-in">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-white">Projects</h1>
            <p class="text-slate-300 text-sm mt-1">Kelola semua project Anda</p>
        </div>
        <a href="{{ route('projects.create') }}" class="btn-primary text-white font-semibold px-5 py-2.5 rounded-xl inline-flex items-center gap-2 text-sm w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Project
        </a>
    </div>

    {{-- Projects Grid --}}
    @if($projects->isEmpty())
    <div class="glass-card p-12 text-center animate-fade-in">
        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-violet-500/10 flex items-center justify-center">
            <lord-icon src="https://cdn.lordicon.com/fhtaantg.json" trigger="loop" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:36px;height:36px"></lord-icon>
        </div>
        <h3 class="text-lg font-bold text-white mb-2">Belum Ada Project</h3>
        <p class="text-slate-300 text-sm mb-6">Mulai dengan membuat project pertama Anda</p>
        <a href="{{ route('projects.create') }}" class="btn-primary text-white font-semibold px-5 py-2.5 rounded-xl inline-flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat Project Baru
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-5 animate-fade-in" style="animation-delay: 0.1s;">
        @foreach($projects as $index => $project)
        <div class="glass-card overflow-hidden card-hover animate-fade-in flex flex-col h-full" style="animation-delay: {{ 0.1 + ($index * 0.05) }}s;">
            {{-- Project Header --}}
            <div class="p-5 {{ $project->status === 'completed' ? 'bg-emerald-500/10' : ($project->status === 'on_hold' ? 'bg-amber-500/10' : 'bg-violet-500/10') }} border-b border-white/10 relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <h3 class="text-lg font-bold text-white flex-1 break-words leading-tight">
                            <a href="{{ route('projects.show', $project) }}" class="hover:text-violet-300 transition">{{ $project->name }}</a>
                        </h3>
                        @if($project->status === 'completed')
                        <span class="px-2.5 py-1 bg-emerald-500/20 text-emerald-400 rounded-lg text-[10px] font-bold uppercase tracking-wider flex-shrink-0 border border-emerald-500/20">Selesai</span>
                        @elseif($project->status === 'on_hold')
                        <span class="px-2.5 py-1 bg-amber-500/20 text-amber-400 rounded-lg text-[10px] font-bold uppercase tracking-wider flex-shrink-0 border border-amber-500/20">Ditunda</span>
                        @else
                        <span class="px-2.5 py-1 bg-violet-500/20 text-violet-300 rounded-lg text-[10px] font-bold uppercase tracking-wider flex-shrink-0 border border-violet-500/20">Aktif</span>
                        @endif
                    </div>
                    @if($project->description)
                    <p class="text-slate-300 text-xs line-clamp-2">{{ $project->description }}</p>
                    @endif
                </div>
            </div>

            {{-- Progress & Stats --}}
            <div class="p-5 flex-1 flex flex-col justify-center">
                {{-- Progress Bar --}}
                <div class="mb-5">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Progress</span>
                        <span class="text-xs font-bold text-violet-400">{{ $project->progress }}%</span>
                    </div>
                    <div class="w-full bg-white/10 rounded-full h-1.5 overflow-hidden border border-white/10">
                        <div class="bg-gradient-to-r from-violet-500 to-indigo-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ $project->progress }}%"></div>
                    </div>
                </div>

                {{-- Mini Stats Grid --}}
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-white/5 rounded-xl p-3 text-center border border-white/10">
                        <p class="text-xs text-slate-300 font-semibold mb-1">Total</p>
                        <p class="text-lg font-bold text-white">{{ $project->total_tasks }}</p>
                    </div>
                    <div class="bg-emerald-500/5 rounded-xl p-3 text-center border border-emerald-500/20">
                        <p class="text-xs text-emerald-300 font-semibold mb-1">Selesai</p>
                        <p class="text-lg font-bold text-emerald-400">{{ $project->completed_tasks }}</p>
                    </div>
                    <div class="bg-amber-500/5 rounded-xl p-3 text-center border border-amber-500/20">
                        <p class="text-xs text-amber-300 font-semibold mb-1">Pending</p>
                        <p class="text-lg font-bold text-amber-400">{{ $project->pending_tasks }}</p>
                    </div>
                </div>
            </div>

            {{-- Dates & Actions --}}
            <div class="mt-auto">
                {{-- Dates --}}
                @if($project->start_date || $project->end_date)
                <div class="px-5 py-3 bg-black/30 border-t border-white/10">
                    <div class="flex items-center justify-between text-[11px] font-medium">
                        @if($project->start_date)
                        <span class="text-slate-300 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-violet-400"></span>
                            {{ $project->start_date->format('d M Y') }}
                        </span>
                        @endif
                        @if($project->end_date)
                        <span class="text-slate-300 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            {{ $project->end_date->format('d M Y') }}
                        </span>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Actions --}}
                <div class="px-5 py-4 border-t border-white/10 flex items-center gap-2">
                    <a href="{{ route('projects.show', $project) }}" class="flex-1 btn-ghost py-2 rounded-xl text-[11px] font-bold uppercase tracking-wider flex items-center justify-center gap-2 text-blue-400 hover:text-blue-300">
                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="hover" colors="primary:#60a5fa,secondary:#93c5fd" style="width:16px;height:16px"></lord-icon>
                        Detail
                    </a>
                    
                    <a href="{{ route('projects.edit', $project) }}" class="flex-1 btn-ghost py-2 rounded-xl text-[11px] font-bold uppercase tracking-wider flex items-center justify-center gap-2 text-slate-300 hover:text-white">
                        <lord-icon src="https://cdn.lordicon.com/wuvorxbv.json" trigger="hover" colors="primary:#cbd5e1,secondary:#94a3b8" style="width:16px;height:16px"></lord-icon>
                        Edit
                    </a>
                    
                    <div class="flex items-center gap-1">
                        <form action="{{ route('projects.duplicate', $project) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-slate-300 hover:text-white transition" title="Duplikat Project">
                                <lord-icon src="https://cdn.lordicon.com/puvaffet.json" trigger="hover" colors="primary:#cbd5e1,secondary:#94a3b8" style="width:16px;height:16px"></lord-icon>
                            </button>
                        </form>
                        
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus project ini? Semua task terkait juga akan dihapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-lg bg-red-500/10 hover:bg-red-500/20 flex items-center justify-center text-red-400 transition" title="Hapus Project">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
