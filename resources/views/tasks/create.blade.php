@extends('layouts.app')

@section('title', 'Tambah Task')

@section('content')
<div class="max-w-2xl mx-auto space-y-5">
    {{-- Back --}}
    <a href="{{ route('tasks.index') }}" class="inline-flex items-center gap-2 text-white/40 hover:text-white/70 text-sm transition animate-fade-in">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Tasks
    </a>

    {{-- Form Card --}}
    <div class="glass-card p-6 md:p-8 animate-fade-in" style="animation-delay: 0.05s;">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-violet-500/15 flex items-center justify-center">
                <lord-icon src="https://cdn.lordicon.com/mecwbjnp.json" trigger="loop" delay="3000" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:24px;height:24px"></lord-icon>
            </div>
            <h1 class="text-xl font-bold text-white">Tambah Task Baru</h1>
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

        <form method="POST" action="{{ route('tasks.store') }}" class="space-y-5">
            @csrf

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-white/60 mb-2">
                    Judul Task <span class="text-red-400">*</span>
                </label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-white/20 focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm"
                    placeholder="Contoh: Submit laporan bulanan">
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-white/60 mb-2">
                    Deskripsi <span class="text-white/20 text-xs">(opsional)</span>
                </label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-white/20 focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none resize-none text-sm"
                    placeholder="Detail task...">{{ old('description') }}</textarea>
            </div>

            {{-- Project --}}
            @if($projects->isNotEmpty())
            <div>
                <label for="project_id" class="block text-sm font-medium text-white/60 mb-2">
                    Project <span class="text-white/20 text-xs">(opsional)</span>
                </label>
                <select id="project_id" name="project_id"
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm" style="background-color: rgba(255,255,255,0.03);">
                    <option value="" style="background: #1a1a3e;">-- Pilih Project --</option>
                    @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ old('project_id', $selectedProjectId) == $project->id ? 'selected' : '' }} style="background: #1a1a3e;">
                        {{ $project->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif

            {{-- Date and Time --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="due_date" class="block text-sm font-medium text-white/60 mb-2">
                        Tanggal Deadline <span class="text-red-400">*</span>
                    </label>
                    <input type="date" id="due_date" name="due_date" value="{{ old('due_date', date('Y-m-d')) }}" required
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm" style="color-scheme: dark;">
                </div>
                <div>
                    <label for="due_time" class="block text-sm font-medium text-white/60 mb-2">
                        Jam Deadline <span class="text-red-400">*</span>
                    </label>
                    <input type="time" id="due_time" name="due_time" value="{{ old('due_time', '17:00') }}" required
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm" style="color-scheme: dark;">
                </div>
            </div>

            {{-- Recurrence --}}
            <div>
                <label for="recurrence_type" class="block text-sm font-medium text-white/60 mb-2">
                    Ulangi Task
                </label>
                <select id="recurrence_type" name="recurrence_type"
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm" style="background-color: rgba(255,255,255,0.03);">
                    <option value="none" {{ old('recurrence_type') == 'none' ? 'selected' : '' }} style="background: #1a1a3e;">Tidak Diulang</option>
                    <option value="daily" {{ old('recurrence_type') == 'daily' ? 'selected' : '' }} style="background: #1a1a3e;">Setiap Hari</option>
                    <option value="weekly" {{ old('recurrence_type') == 'weekly' ? 'selected' : '' }} style="background: #1a1a3e;">Setiap Minggu</option>
                    <option value="monthly" {{ old('recurrence_type') == 'monthly' ? 'selected' : '' }} style="background: #1a1a3e;">Setiap Bulan</option>
                </select>
            </div>

            {{-- Recurrence End Date --}}
            <div id="recurrence_end_date_container" class="{{ old('recurrence_type', 'none') !== 'none' ? '' : 'hidden' }}">
                <label for="recurrence_end_date" class="block text-sm font-medium text-white/60 mb-2">
                    Sampai Tanggal <span class="text-white/20 text-xs">(opsional)</span>
                </label>
                <input type="date" id="recurrence_end_date" name="recurrence_end_date" value="{{ old('recurrence_end_date') }}"
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm" style="color-scheme: dark;">
                <p class="text-white/20 text-xs mt-1.5">Default: Harian 30 hari, Mingguan 12 minggu, Bulanan 12 bulan.</p>
            </div>

            <script>
                document.getElementById('recurrence_type').addEventListener('change', function() {
                    const container = document.getElementById('recurrence_end_date_container');
                    if (this.value !== 'none') {
                        container.classList.remove('hidden');
                    } else {
                        container.classList.add('hidden');
                        document.getElementById('recurrence_end_date').value = '';
                    }
                });
            </script>

            {{-- Info --}}
            <div class="glass-card-light p-4 flex items-start gap-3">
                <span class="text-lg">📱</span>
                <div class="text-sm">
                    <p class="text-violet-300 font-medium mb-0.5">Reminder WhatsApp Otomatis</p>
                    <p class="text-white/30 text-xs">Jika task belum selesai sampai deadline, reminder dikirim ke WhatsApp ({{ Auth::user()->phone_number ?? 'belum diset' }}).</p>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="flex-1 btn-primary text-white font-semibold py-3 rounded-xl text-sm">
                    💾 Simpan Task
                </button>
                <a href="{{ route('tasks.index') }}" class="btn-ghost px-6 py-3 rounded-xl text-sm font-medium text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
