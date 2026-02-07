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
                        trigger="hover"
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
                            trigger="hover"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:20px;height:20px">
                        </lord-icon>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Filter - Responsive -->
        <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 mb-6 animate-fade-in" style="animation-delay: 0.1s;">
            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col md:flex-row md:flex-wrap md:items-end gap-4">
                <div class="flex-1 min-w-full md:min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Periode</label>
                    <select name="filter" id="filterSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" onchange="toggleCustomDates()">
                        <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="custom" {{ $filter == 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                </div>

                <div id="customDates" class="flex flex-col md:flex-row gap-4 w-full md:flex-1" style="display: {{ $filter == 'custom' ? 'flex' : 'none' }};">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date', $startDate->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date', $endDate->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>

                <button type="submit" class="btn-primary text-white px-6 py-2 rounded-lg font-semibold shadow-lg flex items-center justify-center space-x-2 w-full md:w-auto">
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

        <!-- Quick Actions - Responsive -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-8 animate-fade-in" style="animation-delay: 0.3s;">
            <a href="{{ route('tasks.create') }}" class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl p-4 md:p-6 shadow-lg card-hover text-white">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <div class="bg-white/20 p-3 md:p-4 rounded-lg flex items-center justify-center flex-shrink-0">
                        <lord-icon
                            src="https://cdn.lordicon.com/mecwbjnp.json"
                            trigger="morph"
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
                            trigger="hover"
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
        </div>

        <!-- Calendar View - TUI Calendar -->
        <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 animate-fade-in" style="animation-delay: 0.4s;">
            <!-- Calendar Header with Navigation -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div class="flex items-center space-x-3 mb-4 md:mb-0">
                    <lord-icon
                        src="https://cdn.lordicon.com/fhtaantg.json"
                        trigger="loop"
                        colors="primary:#9333ea,secondary:#e9d5ff"
                        style="width:32px;height:32px">
                    </lord-icon>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800" id="calendarTitle">
                        Kalender Task
                    </h2>
                </div>
                
                <div class="flex items-center justify-between md:justify-end gap-4">
                    <!-- Legend -->
                    <div class="flex items-center space-x-2 text-xs md:text-sm text-gray-600">
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
                    
                    <!-- Navigation Buttons -->
                    <div class="flex items-center space-x-2">
                        <button id="prevMonth" class="p-2 hover:bg-gray-100 rounded-lg transition" title="Bulan Sebelumnya">
                            <lord-icon
                                src="https://cdn.lordicon.com/zmkotitn.json"
                                trigger="hover"
                                colors="primary:#6b7280"
                                style="width:20px;height:20px;transform:rotate(180deg)">
                            </lord-icon>
                        </button>
                        <button id="today" class="px-3 py-1.5 text-sm font-semibold text-purple-600 hover:bg-purple-50 rounded-lg transition">
                            Hari Ini
                        </button>
                        <button id="nextMonth" class="p-2 hover:bg-gray-100 rounded-lg transition" title="Bulan Berikutnya">
                            <lord-icon
                                src="https://cdn.lordicon.com/zmkotitn.json"
                                trigger="hover"
                                colors="primary:#6b7280"
                                style="width:20px;height:20px">
                            </lord-icon>
                        </button>
                    </div>
                </div>
            </div>

            <!-- TUI Calendar Container -->
            <div id="calendar" style="height: 600px;"></div>
        </div>
    </div>
</div>

@push('styles')
<!-- TUI Calendar CSS -->
<link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
@endpush

@push('scripts')
<!-- TUI Calendar JS -->
<script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const Calendar = window.tui.Calendar;
    
    // Initialize calendar
    const calendar = new Calendar('#calendar', {
        defaultView: 'month',
        useFormPopup: false,
        useDetailPopup: true,
        isReadOnly: true,
        usageStatistics: false,
        week: {
            startDayOfWeek: 0, // Sunday
            dayNames: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
            narrowWeekend: false,
            workweek: false,
            showTimezoneCollapseButton: false,
            timezonesCollapsed: false,
        },
        month: {
            dayNames: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
            startDayOfWeek: 0,
            narrowWeekend: false,
            visibleWeeksCount: 0, // auto
            isAlways6Weeks: true,
            workweek: false,
            visibleEventCount: 3,
        },
        template: {
            monthDayName(model) {
                return model.label;
            },
            monthGridHeader(model) {
                const date = parseInt(model.date.split('-')[2], 10);
                const classNames = ['tui-calendar-template-monthGridHeader'];
                
                if (model.isToday) {
                    classNames.push('tui-calendar-template-monthGridHeader-today');
                }
                
                return `<span class="${classNames.join(' ')}">${date}</span>`;
            },
            popupDetailDate(isAllday, start, end) {
                const startDate = new Date(start);
                return startDate.toLocaleDateString('id-ID', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            },
        },
        theme: {
            common: {
                border: '1px solid #e5e7eb',
                backgroundColor: '#ffffff',
                holiday: {
                    color: '#ef4444'
                },
                saturday: {
                    color: '#000000'
                },
                dayName: {
                    color: '#374151'
                },
                today: {
                    color: '#ffffff'
                },
            },
            month: {
                dayName: {
                    borderLeft: 'none',
                    backgroundColor: '#f9fafb',
                    fontSize: '14px',
                    fontWeight: '600',
                },
                holidayExceptThisMonth: {
                    color: '#9ca3af'
                },
                dayExceptThisMonth: {
                    color: '#9ca3af'
                },
                weekend: {
                    backgroundColor: '#ffffff'
                },
                moreView: {
                    border: '1px solid #e5e7eb',
                    boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
                    backgroundColor: '#ffffff',
                    width: 320,
                    height: 'auto',
                },
                moreViewTitle: {
                    backgroundColor: '#f9fafb',
                },
            },
        },
    });

    // Prepare events from tasks
    const events = [
        @foreach($calendarTasks->flatten() as $task)
        {
            id: '{{ $task->id }}',
            calendarId: 'tasks',
            title: '{{ addslashes($task->title) }}',
            category: 'time',
            start: '{{ $task->due_date->format('Y-m-d') }}T{{ $task->due_time }}',
            end: '{{ $task->due_date->format('Y-m-d') }}T{{ \Carbon\Carbon::parse($task->due_time)->addHour()->format('H:i:s') }}',
            backgroundColor: '{{ $task->status === "done" ? "#dcfce7" : ($task->isOverdue() ? "#fee2e2" : "#fef9c3") }}',
            borderColor: '{{ $task->status === "done" ? "#16a34a" : ($task->isOverdue() ? "#dc2626" : "#ca8a04") }}',
            color: '{{ $task->status === "done" ? "#166534" : ($task->isOverdue() ? "#991b1b" : "#854d0e") }}',
            isReadOnly: true,
            customStyle: {
                fontWeight: '600',
                fontSize: '11px',
            },
            raw: {
                status: '{{ $task->status }}',
                description: '{{ addslashes($task->description ?? "") }}',
                wa_notified: {{ $task->wa_notified ? 'true' : 'false' }},
                due_date: '{{ $task->due_date->format('Y-m-d') }}',
                due_time: '{{ $task->due_time }}',
            }
        },
        @endforeach
    ];

    // Create calendar
    calendar.createEvents(events);

    // Set current date
    calendar.setDate(new Date());
    
    // Update calendar title
    function updateCalendarTitle() {
        const date = calendar.getDate();
        const options = { year: 'numeric', month: 'long' };
        const monthYear = date.toLocaleDateString('id-ID', options);
        document.getElementById('calendarTitle').textContent = monthYear;
    }
    updateCalendarTitle();

    // Navigation button handlers
    document.getElementById('prevMonth').addEventListener('click', function() {
        calendar.prev();
        updateCalendarTitle();
    });

    document.getElementById('nextMonth').addEventListener('click', function() {
        calendar.next();
        updateCalendarTitle();
    });

    document.getElementById('today').addEventListener('click', function() {
        calendar.today();
        updateCalendarTitle();
    });

    // Handle window resize for responsiveness
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            calendar.render();
        }, 250);
    });

    // Click event handler - Show popup preview
    calendar.on('clickEvent', function(eventObj) {
        const event = eventObj.event;
        showTaskPreview(event);
    });

    // Function to show task preview popup
    function showTaskPreview(event) {
        const status = event.raw.status;
        const description = event.raw.description || 'Tidak ada deskripsi';
        const waNotified = event.raw.wa_notified;
        
        // Determine status badge
        let statusBadge = '';
        let statusIcon = '';
    // KODE BARU (GANTI):
    if (status === 'done') {
        statusBadge = '<span class="px-2 md:px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs md:text-sm font-semibold">✅ Selesai</span>';
    } else {
        // Use raw date/time for accurate comparison
        const taskDateTime = new Date(event.raw.due_date + 'T' + event.raw.due_time);
        if (taskDateTime < new Date()) {
            statusBadge = '<span class="px-2 md:px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs md:text-sm font-semibold">⚠️ Terlambat</span>';
        } else {
            statusBadge = '<span class="px-2 md:px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs md:text-sm font-semibold">⏳ Pending</span>';
        }
    }

    // Format date and time using raw data
    const taskDateTime = new Date(event.raw.due_date + 'T' + event.raw.due_time);
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
        
        // Escape HTML to prevent XSS
        const safeDescription = description.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\n/g, '<br>');
        const safeTitle = event.title.replace(/</g, '&lt;').replace(/>/g, '&gt;');
        
        // Create popup HTML
        const popupHTML = `
            <div id="taskPreviewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 animate-fade-in">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all" onclick="event.stopPropagation()">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-6 rounded-t-2xl">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 pr-4">
                                <h3 class="text-xl font-bold text-white mb-3 break-words">${safeTitle}</h3>
                                ${statusBadge}
                            </div>
                            <button onclick="closeTaskPreview()" class="text-white hover:bg-white/20 rounded-lg p-2 transition flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6 space-y-4 max-h-96 overflow-y-auto">
                        <!-- Date & Time -->
                        <div class="flex items-start space-x-3">
                            <div class="bg-purple-100 p-2 rounded-lg flex-shrink-0">
                                <lord-icon
                                    src="https://cdn.lordicon.com/fhtaantg.json"
                                    trigger="hover"
                                    colors="primary:#9333ea,secondary:#e9d5ff"
                                    style="width:24px;height:24px">
                                </lord-icon>
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
                                <lord-icon
                                    src="https://cdn.lordicon.com/nocovwne.json"
                                    trigger="hover"
                                    colors="primary:#9333ea,secondary:#e9d5ff"
                                    style="width:24px;height:24px">
                                </lord-icon>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 mb-1">Deskripsi</p>
                                <p class="text-gray-800 leading-relaxed">${safeDescription}</p>
                            </div>
                        </div>
                        
                        <!-- WhatsApp Notification -->
                        ${waNotified ? `
                        <div class="flex items-center space-x-2 bg-green-50 border border-green-200 rounded-lg p-3">
                            <lord-icon src="https://cdn.lordicon.com/ayhtotha.json" trigger="loop" colors="primary:#25D366,secondary:#128C7E" style="width:20px;height:20px"></lord-icon>
                            <span class="text-green-700 text-sm font-semibold">Notifikasi WhatsApp terkirim</span>
                        </div>
                        ` : ''}
                    </div>
                    
                    <!-- Footer -->
                    <div class="bg-gray-50 p-4 rounded-b-2xl flex flex-col sm:flex-row gap-2">
                        <button onclick="window.location.href='{{ route('tasks.index') }}'" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition">
                            Lihat Semua Task
                        </button>
                        <button onclick="closeTaskPreview()" class="sm:w-auto px-6 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 rounded-lg transition">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Append to body
        document.body.insertAdjacentHTML('beforeend', popupHTML);
        
        // Add event listener to backdrop for closing
        const modal = document.getElementById('taskPreviewModal');
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeTaskPreview();
            }
        });
    }

    // Function to close task preview
    window.closeTaskPreview = function() {
        const modal = document.getElementById('taskPreviewModal');
        if (modal) {
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.remove();
            }, 200);
        }
    }

    // Render calendar
    calendar.render();
});
</script>

<style>
/* Custom TUI Calendar Styles */
.tui-full-calendar-month-dayname {
    height: 40px !important;
    line-height: 40px !important;
    font-size: 14px !important;
}

.tui-full-calendar-weekday-grid-date {
    font-weight: 600 !important;
}

.tui-full-calendar-weekday-grid-date-decorator {
    display: none;
}

/* Today highlight */
.tui-calendar-template-monthGridHeader-today {
    background-color: #3b82f6 !important;
    color: white !important;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}

/* Event styling */
.tui-full-calendar-month-more {
    background-color: #9333ea !important;
    color: white !important;
    font-size: 11px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
}

.tui-full-calendar-weekday-schedule {
    border-radius: 4px !important;
    padding: 2px 6px !important;
    font-size: 12px !important;
    cursor: pointer !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
}

.tui-full-calendar-weekday-schedule-title {
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    #calendar {
        height: 550px !important;
    }
    
    .tui-full-calendar-weekday-schedule {
        font-size: 11px !important;
        padding: 1px 4px !important;
    }
}

@media (max-width: 768px) {
    #calendar {
        height: 500px !important;
    }
    
    .tui-full-calendar-month-dayname {
        font-size: 12px !important;
        height: 32px !important;
        line-height: 32px !important;
    }
    
    .tui-full-calendar-weekday-schedule {
        font-size: 10px !important;
        padding: 1px 3px !important;
    }
    
    .tui-full-calendar-weekday-schedule-title {
        font-size: 10px !important;
    }
    
    .tui-calendar-template-monthGridHeader {
        font-size: 12px !important;
    }
    
    .tui-calendar-template-monthGridHeader-today {
        width: 24px;
        height: 24px;
        font-size: 11px !important;
    }
}

@media (max-width: 640px) {
    #calendar {
        height: 450px !important;
    }
    
    .tui-full-calendar-month-dayname {
        font-size: 10px !important;
        height: 28px !important;
        line-height: 28px !important;
        padding: 0 2px !important;
    }
    
    .tui-full-calendar-weekday-schedule {
        font-size: 9px !important;
        padding: 1px 2px !important;
    }
    
    .tui-calendar-template-monthGridHeader-today {
        width: 20px;
        height: 20px;
        font-size: 10px !important;
    }
}

/* Popup detail styling */
.tui-full-calendar-popup-container {
    border-radius: 8px !important;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
}

.tui-full-calendar-section-detail {
    padding: 12px !important;
}
</style>
@endpush
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
