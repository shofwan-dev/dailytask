@extends('layouts.app')

@section('title', 'Buat Project Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-5">
    {{-- Back --}}
    <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 text-white/40 hover:text-white/70 text-sm transition animate-fade-in">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Projects
    </a>

    {{-- Form Card --}}
    <div class="glass-card p-6 md:p-8 animate-fade-in" style="animation-delay: 0.05s;">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-violet-500/15 flex items-center justify-center">
                <lord-icon src="https://cdn.lordicon.com/mecwbjnp.json" trigger="loop" delay="3000" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:24px;height:24px"></lord-icon>
            </div>
            <h1 class="text-xl font-bold text-white">Buat Project Baru</h1>
        </div>

        @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 mb-6">
            <ul class="list-disc list-inside text-red-400 text-sm space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('projects.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-white/60 mb-2">
                    Nama Project <span class="text-red-400">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-white/20 focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm"
                    placeholder="Contoh: Redesign Website">
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-white/60 mb-2">
                    Deskripsi <span class="text-white/20 text-xs">(opsional)</span>
                </label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-white/20 focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none resize-none text-sm"
                    placeholder="Detail tentang project ini...">{{ old('description') }}</textarea>
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-white/60 mb-2">
                    Status Project <span class="text-red-400">*</span>
                </label>
                <select id="status" name="status" required
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm" style="background-color: rgba(255,255,255,0.03);">
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }} style="background: #1a1a3e;">Aktif</option>
                    <option value="on_hold" {{ old('status') === 'on_hold' ? 'selected' : '' }} style="background: #1a1a3e;">Ditunda</option>
                    <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }} style="background: #1a1a3e;">Selesai</option>
                </select>
            </div>

            {{-- Dates --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-white/60 mb-2">
                        Tanggal Mulai <span class="text-white/20 text-xs">(opsional)</span>
                    </label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm" style="color-scheme: dark;">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-white/60 mb-2">
                        Tanggal Selesai <span class="text-white/20 text-xs">(opsional)</span>
                    </label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm" style="color-scheme: dark;">
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center gap-3 pt-2 border-t border-white/5">
                <button type="submit" class="flex-1 btn-primary text-white font-semibold py-3 rounded-xl text-sm">
                    💾 Simpan Project
                </button>
                <a href="{{ route('projects.index') }}" class="btn-ghost px-6 py-3 rounded-xl text-sm font-medium text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
