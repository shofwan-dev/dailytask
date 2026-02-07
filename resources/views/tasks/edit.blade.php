@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<div class="min-h-screen px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6 animate-fade-in">
            <a href="{{ route('tasks.index') }}" class="inline-flex items-center space-x-2 text-white hover:text-purple-200 transition">
                <lord-icon
                    src="https://cdn.lordicon.com/jxwksgwv.json"
                    trigger="hover"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:20px;height:20px">
                </lord-icon>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 animate-fade-in" style="animation-delay: 0.1s;">
            <div class="flex items-center space-x-3 mb-6">
                <div class="bg-purple-100 p-3 rounded-lg flex items-center justify-center">
                    <lord-icon
                        src="https://cdn.lordicon.com/wuvorxbv.json"
                        trigger="hover"
                        colors="primary:#9333ea,secondary:#e9d5ff"
                        style="width:32px;height:32px">
                    </lord-icon>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Edit Task</h1>
            </div>

            @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Task <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="Contoh: Submit laporan bulanan">
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi <span class="text-gray-400 text-xs">(opsional)</span>
                    </label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition resize-none"
                        placeholder="Detail task yang perlu dikerjakan...">{{ old('description', $task->description) }}</textarea>
                </div>

                <!-- Project Selection -->
                @if($projects->isNotEmpty())
                <div>
                    <label for="project_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Project <span class="text-gray-400 text-xs">(opsional)</span>
                    </label>
                    <select id="project_id" name="project_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        <option value="">-- Pilih Project --</option>
                        @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Hubungkan task ini dengan project tertentu</p>
                </div>
                @endif

                <!-- Date and Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Due Date -->
                    <div>
                        <label for="due_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Deadline <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <lord-icon
                                    src="https://cdn.lordicon.com/kbtmbyzy.json"
                                    trigger="hover"
                                    colors="primary:#9ca3af,secondary:#d1d5db"
                                    style="width:20px;height:20px">
                                </lord-icon>
                            </div>
                            <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <!-- Due Time -->
                    <div>
                        <label for="due_time" class="block text-sm font-semibold text-gray-700 mb-2">
                            Jam Deadline <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <lord-icon
                                    src="https://cdn.lordicon.com/lupuorrc.json"
                                    trigger="hover"
                                    colors="primary:#9ca3af,secondary:#d1d5db"
                                    style="width:20px;height:20px">
                                </lord-icon>
                            </div>
                            <input type="time" id="due_time" name="due_time" value="{{ old('due_time', $task->due_time) }}" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status
                    </label>
                    <select id="status" name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="done" {{ old('status', $task->status) === 'done' ? 'selected' : '' }}>✅ Done</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex items-center space-x-4 pt-4">
                    <button type="submit" class="flex-1 btn-primary text-white font-semibold py-3 rounded-lg shadow-lg">
                        💾 Update Task
                    </button>
                    <a href="{{ route('tasks.index') }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
