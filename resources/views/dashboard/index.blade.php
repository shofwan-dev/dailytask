@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 animate-fade-in">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/winbdcqi.json"
                        trigger="loop"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:40px;height:40px">
                    </lord-icon>
                    <h1 class="text-4xl font-bold text-white">Dashboard</h1>
                </div>
                <p class="text-purple-200">Halo, {{ Auth::user()->name }}!</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('settings.index') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition backdrop-blur-sm border border-white/30 flex items-center space-x-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/hwuyodym.json"
                        trigger="hover"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <span>Pengaturan</span>
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

        <!-- Filter -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 animate-fade-in" style="animation-delay: 0.1s;">
            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Periode</label>
                    <select name="filter" id="filterSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" onchange="toggleCustomDates()">
                        <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="custom" {{ $filter == 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                </div>

                <div id="customDates" class="flex gap-4 flex-1" style="display: {{ $filter == 'custom' ? 'flex' : 'none' }};">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date', $startDate->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date', $endDate->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>

                <button type="submit" class="btn-primary text-white px-6 py-2 rounded-lg font-semibold shadow-lg flex items-center space-x-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/qhgmphtg.json"
                        trigger="hover"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <span>Filter</span>
                </button>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-fade-in" style="animation-delay: 0.2s;">
            <div class="bg-white rounded-xl p-6 shadow-lg card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Tasks</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
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

            <div class="bg-white rounded-xl p-6 shadow-lg card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pending</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['pending'] }}</p>
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

            <div class="bg-white rounded-xl p-6 shadow-lg card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Completed</p>
                        <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['done'] }}</p>
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

            <div class="bg-white rounded-xl p-6 shadow-lg card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Overdue</p>
                        <p class="text-3xl font-bold text-red-600 mt-1">{{ $stats['overdue'] }}</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-lg flex items-center justify-center">
                        <lord-icon
                            src="https://cdn.lordicon.com/bazyvshu.json"
                            trigger="hover"
                            colors="primary:#dc2626,secondary:#fecaca"
                            style="width:32px;height:32px">
                        </lord-icon>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 animate-fade-in" style="animation-delay: 0.3s;">
            <a href="{{ route('tasks.create') }}" class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl p-6 shadow-lg card-hover text-white">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 p-4 rounded-lg flex items-center justify-center">
                        <lord-icon
                            src="https://cdn.lordicon.com/mecwbjnp.json"
                            trigger="morph"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:32px;height:32px">
                        </lord-icon>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Tambah Task Baru</h3>
                        <p class="text-purple-100 text-sm">Buat task baru dengan reminder WhatsApp</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('tasks.index') }}" class="bg-gradient-to-r from-blue-500 to-cyan-600 rounded-xl p-6 shadow-lg card-hover text-white">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 p-4 rounded-lg flex items-center justify-center">
                        <lord-icon
                            src="https://cdn.lordicon.com/msoeawqm.json"
                            trigger="hover"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:32px;height:32px">
                        </lord-icon>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Lihat Semua Task</h3>
                        <p class="text-blue-100 text-sm">Kelola dan update task Anda</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Tasks -->
        <div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in" style="animation-delay: 0.4s;">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">📝 Task Terbaru</h2>
            
            @if($recentTasks->count() > 0)
            <div class="space-y-3">
                @foreach($recentTasks as $task)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" class="checkbox-custom" {{ $task->status === 'done' ? 'checked' : '' }} disabled>
                        <div>
                            <h4 class="font-semibold text-gray-800 {{ $task->status === 'done' ? 'line-through text-gray-400' : '' }}">
                                {{ $task->title }}
                            </h4>
                            <p class="text-sm text-gray-500">
                                {{ $task->due_date->format('d M Y') }} • {{ \Carbon\Carbon::parse($task->due_time)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                    <div>
                        @if($task->status === 'pending')
                            @if($task->isOverdue())
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                ⚠️ Overdue
                            </span>
                            @else
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                ⏳ Pending
                            </span>
                            @endif
                        @else
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                            ✅ Done
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <p class="text-gray-500">Belum ada task</p>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleCustomDates() {
    const filter = document.getElementById('filterSelect').value;
    const customDates = document.getElementById('customDates');
    customDates.style.display = filter === 'custom' ? 'flex' : 'none';
}
</script>
@endpush
@endsection
