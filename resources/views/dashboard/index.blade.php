@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header - Responsive -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8 animate-fade-in">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/cwwqfdik.json"
                        trigger="loop"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:40px;height:40px">
                    </lord-icon>
                    <h1 class="text-3xl md:text-4xl font-bold text-white">Dashboard</h1>
                </div>
                <p class="text-purple-200">Halo, {{ Auth::user()->name }}!</p>
            </div>
            <div class="flex flex-wrap gap-2 md:gap-3">
                <a href="{{ route('settings.index') }}" class="bg-white/20 hover:bg-white/30 text-white px-3 md:px-4 py-2 rounded-lg transition backdrop-blur-sm border border-white/30 flex items-center space-x-2 text-sm md:text-base">
                    <lord-icon
                        src="https://cdn.lordicon.com/hwuyodym.json"
                        trigger="loop"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <span>Pengaturan</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-white/20 hover:bg-white/30 text-white px-3 md:px-4 py-2 rounded-lg transition backdrop-blur-sm border border-white/30 flex items-center space-x-2 text-sm md:text-base">
                        <lord-icon
                            src="https://cdn.lordicon.com/moscwhoj.json"
                            trigger="loop"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:20px;height:20px">
                        </lord-icon>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8 animate-fade-in" style="animation-delay: 0.1s;">
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Tasks</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <lord-icon
                            src="https://cdn.lordicon.com/osuxyevn.json"
                            trigger="loop"
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
                        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['pending'] }}</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <lord-icon
                            src="https://cdn.lordicon.com/kbtmbyzy.json"
                            trigger="loop"
                            colors="primary:#ca8a04,secondary:#ca8a04"
                            style="width:32px;height:32px">
                        </lord-icon>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Completed</p>
                        <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['done'] }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <lord-icon
                            src="https://cdn.lordicon.com/egiwmiit.json"
                            trigger="loop"
                            colors="primary:#16a34a,secondary:#bbf7d0"
                            style="width:32px;height:32px">
                        </lord-icon>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8 animate-fade-in" style="animation-delay: 0.2s;">
            <a href="{{ route('tasks.create') }}" class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl p-4 md:p-6 shadow-lg card-hover text-white">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <div class="bg-white/20 p-3 md:p-4 rounded-lg flex items-center justify-center flex-shrink-0">
                        <lord-icon
                            src="https://cdn.lordicon.com/mecwbjnp.json"
                            trigger="loop"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:28px;height:28px">
                        </lord-icon>
                    </div>
                    <div>
                        <h3 class="text-lg md:text-xl font-bold">Tambah Task Baru</h3>
                        <p class="text-purple-100 text-xs md:text-sm">Buat task baru dengan reminder WhatsApp</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('tasks.index') }}" class="bg-gradient-to-r from-blue-500 to-cyan-600 rounded-xl p-4 md:p-6 shadow-lg card-hover text-white">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <div class="bg-white/20 p-3 md:p-4 rounded-lg flex items-center justify-center flex-shrink-0">
                        <lord-icon
                            src="https://cdn.lordicon.com/msoeawqm.json"
                            trigger="loop"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:28px;height:28px">
                        </lord-icon>
                    </div>
                    <div>
                        <h3 class="text-lg md:text-xl font-bold">Lihat Semua Task</h3>
                        <p class="text-blue-100 text-xs md:text-sm">Kelola dan update task Anda</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('projects.index') }}" class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl p-4 md:p-6 shadow-lg card-hover text-white">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <div class="bg-white/20 p-3 md:p-4 rounded-lg flex items-center justify-center flex-shrink-0">
                        <lord-icon
                            src="https://cdn.lordicon.com/fhtaantg.json"
                            trigger="loop"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:28px;height:28px">
                        </lord-icon>
                    </div>
                    <div>
                        <h3 class="text-lg md:text-xl font-bold">Kelola Projects</h3>
                        <p class="text-green-100 text-xs md:text-sm">Lihat dan kelola semua project</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Projects Summary -->
        @if($projectStats['total'] > 0)
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 animate-fade-in" style="animation-delay: 0.25s;">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <lord-icon
                        src="https://cdn.lordicon.com/fhtaantg.json"
                        trigger="loop"
                        colors="primary:#9333ea,secondary:#e9d5ff"
                        style="width:32px;height:32px">
                    </lord-icon>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">Projects Terbaru</h2>
                </div>
                <a href="{{ route('projects.index') }}" class="text-purple-600 hover:text-purple-700 font-semibold text-sm flex items-center space-x-1">
                    <span>Lihat Semua</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>


            <!-- Project Stats Mini - Horizontal Layout -->
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg p-4 mb-6">
                <div class="flex items-center justify-between w-full px-4">
                    <!-- Total Projects -->
                    <div class="flex items-center space-x-2">
                        <lord-icon
                            src="https://cdn.lordicon.com/hisvnjlk.json"
                            trigger="loop"
                            colors="primary:#9333ea,secondary:#c084fc"
                            style="width:28px;height:28px">
                        </lord-icon>
                        <div>
                            <p class="text-2xl font-bold text-purple-600">{{ $projectStats['total'] }}</p>
                            <p class="text-xs text-gray-600">Total</p>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="h-12 w-px bg-gray-300"></div>

                    <!-- Active Projects -->
                    <div class="flex items-center space-x-2">
                        <lord-icon
                            src="https://cdn.lordicon.com/fihkmkwt.json"
                            trigger="loop"
                            colors="primary:#16a34a,secondary:#86efac"
                            style="width:28px;height:28px">
                        </lord-icon>
                        <div>
                            <p class="text-2xl font-bold text-green-600">{{ $projectStats['active'] }}</p>
                            <p class="text-xs text-gray-600">Aktif</p>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="h-12 w-px bg-gray-300"></div>

                    <!-- Completed Projects -->
                    <div class="flex items-center space-x-2">
                        <lord-icon
                            src="https://cdn.lordicon.com/yqzmiobz.json"
                            trigger="loop"
                            colors="primary:#2563eb,secondary:#93c5fd"
                            style="width:28px;height:28px">
                        </lord-icon>
                        <div>
                            <p class="text-2xl font-bold text-blue-600">{{ $projectStats['completed'] }}</p>
                            <p class="text-xs text-gray-600">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Recent Projects - Responsive Grid -->
            <!-- Grid selalu 3 kolom di desktop, tidak peduli jumlah project -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($projects as $project)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-bold text-gray-800">{{ $project->name }}</h3>
                                @if($project->status === 'completed')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Selesai</span>
                                @elseif($project->status === 'on_hold')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Ditunda</span>
                                @else
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">Aktif</span>
                                @endif
                            </div>
                            @if($project->description)
                            <p class="text-gray-600 text-sm line-clamp-2">{{ $project->description }}</p>
                            @endif
                        </div>
                        <a href="{{ route('projects.show', $project) }}" class="ml-4 bg-purple-100 hover:bg-purple-200 text-purple-700 px-3 py-2 rounded-lg transition text-sm font-semibold">
                            Detail
                        </a>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mb-3">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-semibold text-gray-600">Progress</span>
                            <span class="text-xs font-bold text-purple-600">{{ $project->progress }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 h-2 rounded-full transition-all duration-500" style="width: {{ $project->progress }}%"></div>
                        </div>
                    </div>

                    <!-- Task Stats -->
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <span>📋 {{ $project->total_tasks }} tasks</span>
                        <span>✅ {{ $project->completed_tasks }} selesai</span>
                        <span>⏳ {{ $project->pending_tasks }} pending</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Calendar View - FullCalendar -->
        <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 animate-fade-in" style="animation-delay: 0.3s;">
            <!-- Calendar Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div class="flex items-center space-x-3 mb-4 md:mb-0">
                    <lord-icon
                        src="https://cdn.lordicon.com/fhtaantg.json"
                        trigger="loop"
                        colors="primary:#9333ea,secondary:#e9d5ff"
                        style="width:32px;height:32px">
                    </lord-icon>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">
                        Kalender Task
                    </h2>
                </div>
                
                <!-- Legend -->
                <div class="flex items-center space-x-3 text-xs md:text-sm text-gray-600">
                    <span class="flex items-center">
                        <span class="w-3 h-3 bg-red-500 rounded-full mr-1"></span> Overdue
                    </span>
                    <span class="flex items-center">
                        <span class="w-3 h-3 bg-yellow-500 rounded-full mr-1"></span> Pending
                    </span>
                    <span class="flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-1"></span> Done
                    </span>
                </div>
            </div>

            <!-- FullCalendar Container -->
            <div id="calendar"></div>
        </div>
    </div>
</div>

<!-- FullCalendar CSS & JS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<!-- Custom Responsive CSS for FullCalendar -->
<style>
/* Responsive FullCalendar Header */
@media (max-width: 767px) {
    /* Toolbar responsive */
    .fc .fc-toolbar {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        padding: 0.5rem 0;
    }
    
    .fc .fc-toolbar-chunk {
        display: flex;
        justify-content: center;
        width: 100%;
    }
    
    /* Title smaller */
    .fc .fc-toolbar-title {
        font-size: 1.125rem !important; /* 18px */
        font-weight: 600;
    }
    
    /* Buttons smaller */
    .fc .fc-button {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.75rem !important; /* 12px */
    }
    
    /* View buttons compact */
    .fc .fc-button-group {
        display: flex;
        gap: 0.25rem;
    }
    
    /* Icon buttons */
    .fc .fc-prev-button,
    .fc .fc-next-button {
        padding: 0.25rem 0.5rem !important;
    }
    
    /* Today button */
    .fc .fc-today-button {
        padding: 0.25rem 0.75rem !important;
    }
}

/* Desktop - ensure proper spacing */
@media (min-width: 768px) {
    .fc .fc-toolbar {
        margin-bottom: 1rem;
    }
    
    .fc .fc-toolbar-title {
        font-size: 1.5rem !important;
        font-weight: 700;
    }
}

/* General improvements */
.fc .fc-button {
    border-radius: 0.5rem;
    transition: all 0.2s;
}

.fc .fc-button:hover {
    transform: translateY(-1px);
}

.fc .fc-button-primary {
    background-color: #9333ea !important;
    border-color: #9333ea !important;
}

.fc .fc-button-primary:hover {
    background-color: #7e22ce !important;
    border-color: #7e22ce !important;
}

.fc .fc-button-primary:disabled {
    background-color: #d1d5db !important;
    border-color: #d1d5db !important;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    
    // Prepare events from tasks
    const events = @json($calendarEvents);
    
    // Helper for task navigation
    window.openEditTask = function(taskId) {
        const url = '{{ route("tasks.edit", ":id") }}'.replace(':id', taskId);
        window.location.href = url;
    };

    window.openShowTask = function(taskId) {
        const url = '{{ route("tasks.show", ":id") }}'.replace(':id', taskId);
        window.location.href = url;
    };
    
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: window.innerWidth < 768 ? 'timeGridDay' : 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan',
            week: 'Minggu',
            day: 'Hari'
        },
        locale: 'id',
        events: events,
        height: 'auto',
        eventClick: function(info) {
            showTaskModal(info.event);
        },
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        slotLabelFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        // Swipe navigation for mobile
        navLinks: true,
        // Responsive
        windowResize: function(view) {
            if (window.innerWidth < 768) {
                calendar.changeView('timeGridDay');
            } else {
                calendar.changeView('dayGridMonth');
            }
        }
    });
    
    calendar.render();
    
    // Function to show task modal
    function showTaskModal(event) {
        const props = event.extendedProps;
        const status = props.status;
        const description = props.description || 'Tidak ada deskripsi';
        const waNotified = props.wa_notified;
        const is_virtual = props.is_virtual;
        
        // Determine status badge
        let statusBadge = '';
        if (status === 'done') {
            statusBadge = '<span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">\u2705 Selesai</span>';
        } else {
            const taskDateTime = new Date(props.due_date + 'T' + props.due_time);
            if (taskDateTime < new Date()) {
                statusBadge = '<span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">\u26a0\ufe0f Terlambat</span>';
            } else {
                statusBadge = '<span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold">\u23f3 Pending</span>';
            }
        }
        
        // Format date and time
        const taskDateTime = new Date(props.due_date + 'T' + props.due_time);
        const formattedDate = taskDateTime.toLocaleDateString('id-ID', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        const formattedTime = taskDateTime.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
        
        // Escape HTML
        const safeDescription = description.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\n/g, '<br>');
        const safeTitle = event.title.replace(/</g, '&lt;').replace(/>/g, '&gt;');
        
        // Create modal HTML
        const modalHTML = `
            <div id="taskModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 animate-fade-in">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-6 rounded-t-2xl sticky top-0">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 pr-4">
                                <h3 class="text-xl font-bold text-white mb-3 break-words">${safeTitle}</h3>
                                ${statusBadge}
                            </div>
                            <button onclick="closeTaskModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6 space-y-4">
                        <!-- Date & Time -->
                        <div class="flex items-start space-x-3">
                            <div class="bg-purple-100 p-2 rounded-lg flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 mb-1">Tanggal & Waktu</p>
                                <p class="font-semibold text-gray-800">${formattedDate}</p>
                                <p class="text-purple-600 font-semibold text-lg">${formattedTime}</p>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <div class="flex items-start space-x-3">
                            <div class="bg-purple-100 p-2 rounded-lg flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 mb-1">Deskripsi</p>
                                <p class="text-gray-800 leading-relaxed">${safeDescription}</p>
                            </div>
                        </div>
                        
                        <!-- WhatsApp Notification -->
                        ${waNotified ? `
                        <div class="flex items-center space-x-2 bg-green-50 border border-green-200 rounded-lg p-3">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            <span class="text-green-700 text-sm font-semibold">Notifikasi WhatsApp terkirim</span>
                        </div>
                        ` : ''}
                    </div>
                    
                    <!-- Footer -->
                    <div class="bg-gray-50 p-4 rounded-b-2xl flex items-center justify-center gap-6 sticky bottom-0">
                        <button onclick="openShowTask('${event.id}')" class="p-3 rounded-full bg-purple-50 hover:bg-purple-100 text-purple-600 transition-all hover:scale-110 group" title="Lihat Detail">
                            <lord-icon
                                src="https://cdn.lordicon.com/msoeawqm.json"
                                trigger="hover"
                                target=".group"
                                colors="primary:#9333ea,secondary:#e9d5ff"
                                style="width:32px;height:32px">
                            </lord-icon>
                        </button>
                        
                        <button onclick="openEditTask('${event.id}')" class="p-3 rounded-full bg-blue-50 hover:bg-blue-100 text-blue-600 transition-all hover:scale-110 group" title="Edit Task">
                            <lord-icon
                                src="https://cdn.lordicon.com/wuvorxbv.json"
                                trigger="hover"
                                target=".group"
                                colors="primary:#2563eb,secondary:#bfdbfe"
                                style="width:32px;height:32px">
                            </lord-icon>
                        </button>

                        <button onclick="closeTaskModal()" class="p-3 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 transition-all hover:scale-110 group" title="Tutup">
                            <lord-icon
                                src="https://cdn.lordicon.com/nqtddedc.json"
                                trigger="hover"
                                target=".group"
                                colors="primary:#4b5563,secondary:#9ca3af"
                                style="width:32px;height:32px">
                            </lord-icon>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Append to body
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        // Add click event to close on backdrop
        const modal = document.getElementById('taskModal');
        modal.addEventListener('click', function(e) {
            if (e.target.id === 'taskModal') {
                closeTaskModal();
            }
        });
    }
    // Function to close modal
    window.closeTaskModal = function() {
        const modal = document.getElementById('taskModal');
        if (modal) {
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.remove();
            }, 200);
        }
    };

    // Add keydown event for Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeTaskModal();
        }
    });
});
</script>
@endpush
@endsection
