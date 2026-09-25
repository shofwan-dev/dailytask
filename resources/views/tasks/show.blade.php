@extends('layouts.app')

@section('title', 'Detail Task')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">
    {{-- Back Button --}}
    <div class="animate-fade-in">
        <a href="{{ route('tasks.index') }}" class="inline-flex items-center gap-2 text-white/40 hover:text-white/70 text-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Tasks
        </a>
    </div>

    {{-- Main Card --}}
    <div class="glass-card overflow-hidden animate-fade-in" style="animation-delay: 0.1s;">
        {{-- Header --}}
        <div class="p-6 md:p-8 {{ $task->status === 'done' ? 'bg-emerald-500/10' : ($task->isOverdue() ? 'bg-red-500/10' : 'bg-violet-500/10') }} border-b border-white/5 relative overflow-hidden">
            {{-- Decorative gradient --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br {{ $task->status === 'done' ? 'from-emerald-500/20' : ($task->isOverdue() ? 'from-red-500/20' : 'from-violet-500/20') }} to-transparent rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col gap-4">
                <div class="flex flex-wrap items-center gap-2">
                    @if($task->status === 'done')
                    <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-semibold flex items-center gap-1.5 border border-emerald-500/20">
                        ✅ Selesai
                    </span>
                    @elseif($task->isOverdue())
                    <span class="px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-xs font-semibold flex items-center gap-1.5 border border-red-500/20 animate-pulse">
                        ⚠️ Terlambat
                    </span>
                    @else
                    <span class="px-3 py-1 bg-amber-500/20 text-amber-400 rounded-full text-xs font-semibold flex items-center gap-1.5 border border-amber-500/20">
                        ⏳ Pending
                    </span>
                    @endif
                    
                    @if($task->project)
                    <a href="{{ route('projects.show', $task->project) }}" class="px-3 py-1 bg-violet-500/20 text-violet-300 rounded-full text-xs font-semibold flex items-center gap-1.5 hover:bg-violet-500/30 transition border border-violet-500/20">
                        📁 {{ $task->project->name }}
                    </a>
                    @endif
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-white break-words leading-tight">{{ $task->title }}</h1>
            </div>
        </div>

        {{-- Content --}}
        <div class="p-6 md:p-8 space-y-8">
            {{-- Info Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Date & Time --}}
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center flex-shrink-0 border border-blue-500/20">
                        <lord-icon src="https://cdn.lordicon.com/kbtmbyzy.json" trigger="loop" delay="2000" colors="primary:#60a5fa,secondary:#93c5fd" style="width:28px;height:28px"></lord-icon>
                    </div>
                    <div>
                        <p class="text-xs text-white/40 font-medium mb-1 uppercase tracking-wider">Tenggat Waktu</p>
                        <p class="text-base font-bold text-white">{{ $task->due_date->format('l, d F Y') }}</p>
                        <p class="text-blue-400 font-semibold">{{ \Carbon\Carbon::parse($task->due_time)->format('H:i') }} WIB</p>
                    </div>
                </div>
                
                {{-- Recurrence --}}
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center flex-shrink-0 border border-indigo-500/20">
                        <lord-icon src="https://cdn.lordicon.com/qjuahhae.json" trigger="loop" delay="3000" colors="primary:#818cf8,secondary:#a5b4fc" style="width:28px;height:28px"></lord-icon>
                    </div>
                    <div>
                        <p class="text-xs text-white/40 font-medium mb-1 uppercase tracking-wider">Pengulangan</p>
                        @if($task->recurrence_type !== 'none')
                        <p class="text-base font-bold text-white capitalize">{{ $task->recurrence_type }}</p>
                        <p class="text-indigo-400 font-semibold text-sm">
                            @if($task->recurrence_end_date)
                            Sampai {{ $task->recurrence_end_date->format('d M Y') }}
                            @else
                            Selamanya
                            @endif
                        </p>
                        @else
                        <p class="text-base font-bold text-white/50">Tidak Berulang</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div>
                <h3 class="text-sm font-bold text-white/50 uppercase tracking-widest mb-3 flex items-center gap-2">
                    <lord-icon src="https://cdn.lordicon.com/wuvorxbv.json" trigger="hover" colors="primary:#9ca3af,secondary:#d1d5db" style="width:18px;height:18px"></lord-icon>
                    Deskripsi
                </h3>
                <div class="glass-card-light p-6 text-white/80 leading-relaxed whitespace-pre-line text-sm border border-white/5">
                    {{ $task->description ?: 'Tidak ada deskripsi untuk task ini.' }}
                </div>
            </div>
            
            {{-- WhatsApp Status --}}
            @if($task->wa_notified)
            <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-5 flex items-start sm:items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                    <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" delay="2000" colors="primary:#34d399,secondary:#6ee7b7" style="width:24px;height:24px"></lord-icon>
                </div>
                <div>
                    <p class="text-emerald-400 font-bold text-sm">Notifikasi WhatsApp Terkirim</p>
                    <p class="text-emerald-400/60 text-xs mt-0.5">Pengingat telah dikirim ke nomor Anda dengan sukses.</p>
                </div>
            </div>
            @endif
        </div>

        {{-- Actions Footer --}}
        <div class="p-6 md:p-8 bg-black/20 border-t border-white/5 flex flex-col sm:flex-row gap-3">
            <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full justify-center flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-white transition transform hover:-translate-y-0.5 shadow-lg {{ $task->status === 'done' ? 'bg-amber-500 hover:bg-amber-400' : 'bg-emerald-500 hover:bg-emerald-400' }}">
                    @if($task->status === 'done')
                    <lord-icon src="https://cdn.lordicon.com/kbtmbyzy.json" trigger="loop" colors="primary:#ffffff,secondary:#ffffff" style="width:20px;height:20px"></lord-icon>
                    <span>Tandai Belum Selesai</span>
                    @else
                    <lord-icon src="https://cdn.lordicon.com/egiwmiit.json" trigger="loop" colors="primary:#ffffff,secondary:#ffffff" style="width:20px;height:20px"></lord-icon>
                    <span>Tandai Selesai</span>
                    @endif
                </button>
            </form>
            
            <a href="{{ route('tasks.edit', $task) }}" class="flex-1 justify-center flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-white bg-white/10 hover:bg-white/20 transition border border-white/10">
                <lord-icon src="https://cdn.lordicon.com/wuvorxbv.json" trigger="hover" colors="primary:#ffffff,secondary:#ffffff" style="width:20px;height:20px"></lord-icon>
                <span>Edit Task</span>
            </a>
            
            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus task ini?');" class="sm:flex-none">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full sm:w-auto justify-center flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-red-400 bg-red-500/10 hover:bg-red-500/20 transition border border-red-500/20">
                    <lord-icon src="https://cdn.lordicon.com/kfzfxczd.json" trigger="hover" colors="primary:#f87171,secondary:#fca5a5" style="width:20px;height:20px"></lord-icon>
                    <span class="sm:hidden">Hapus</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
