@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    {{-- Welcome & Today's Focus --}}
    <div class="animate-fade-in">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-2">
            <div>
                <p class="text-white/40 text-sm font-medium">Selamat datang kembali,</p>
                <h1 class="text-2xl md:text-3xl font-bold text-white">{{ Auth::user()->name }} 👋</h1>
            </div>
            <a href="{{ route('tasks.create') }}" class="btn-primary text-white font-semibold px-5 py-2.5 rounded-xl inline-flex items-center gap-2 text-sm w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Task
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 animate-fade-in" style="animation-delay: 0.05s;">
        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-violet-500/10 flex items-center justify-center flex-shrink-0">
                    <lord-icon src="https://cdn.lordicon.com/osuxyevn.json" trigger="loop" delay="3000" colors="primary:#8b5cf6,secondary:#c4b5fd" style="width:22px;height:22px"></lord-icon>
                </div>
                <div>
                    <p class="text-2xl font-bold text-white">{{ $stats['total'] }}</p>
                    <p class="text-white/30 text-xs font-medium">Total Task</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center flex-shrink-0">
                    <lord-icon src="https://cdn.lordicon.com/kbtmbyzy.json" trigger="loop" delay="3000" colors="primary:#f59e0b,secondary:#fbbf24" style="width:22px;height:22px"></lord-icon>
                </div>
                <div>
                    <p class="text-2xl font-bold text-amber-400">{{ $stats['pending'] }}</p>
                    <p class="text-white/30 text-xs font-medium">Pending</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center flex-shrink-0">
                    <lord-icon src="https://cdn.lordicon.com/egiwmiit.json" trigger="loop" delay="3000" colors="primary:#10b981,secondary:#6ee7b7" style="width:22px;height:22px"></lord-icon>
                </div>
                <div>
                    <p class="text-2xl font-bold text-emerald-400">{{ $stats['done'] }}</p>
                    <p class="text-white/30 text-xs font-medium">Selesai</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center flex-shrink-0">
                    <lord-icon src="https://cdn.lordicon.com/wdnwtnyn.json" trigger="loop" delay="3000" colors="primary:#ef4444,secondary:#fca5a5" style="width:22px;height:22px"></lord-icon>
                </div>
                <div>
                    <p class="text-2xl font-bold text-red-400">{{ $stats['overdue'] }}</p>
                    <p class="text-white/30 text-xs font-medium">Overdue</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4 animate-fade-in" style="animation-delay: 0.1s;">
        <a href="{{ route('tasks.create') }}" class="glass-card p-4 card-hover flex items-center gap-4 group">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-violet-500/20 to-indigo-500/20 flex items-center justify-center flex-shrink-0 group-hover:from-violet-500/30 group-hover:to-indigo-500/30 transition">
                <lord-icon src="https://cdn.lordicon.com/mecwbjnp.json" trigger="hover" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:24px;height:24px"></lord-icon>
            </div>
            <div>
                <h3 class="text-white font-semibold text-sm">Tambah Task Baru</h3>
                <p class="text-white/30 text-xs">Buat task dengan reminder WA</p>
            </div>
        </a>

        <a href="{{ route('tasks.index') }}" class="glass-card p-4 card-hover flex items-center gap-4 group">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-500/20 to-cyan-500/20 flex items-center justify-center flex-shrink-0 group-hover:from-blue-500/30 group-hover:to-cyan-500/30 transition">
                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="hover" colors="primary:#60a5fa,secondary:#93c5fd" style="width:24px;height:24px"></lord-icon>
            </div>
            <div>
                <h3 class="text-white font-semibold text-sm">Lihat Semua Task</h3>
                <p class="text-white/30 text-xs">Kelola dan update task</p>
            </div>
        </a>

        <a href="{{ route('projects.index') }}" class="glass-card p-4 card-hover flex items-center gap-4 group">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500/20 to-teal-500/20 flex items-center justify-center flex-shrink-0 group-hover:from-emerald-500/30 group-hover:to-teal-500/30 transition">
                <lord-icon src="https://cdn.lordicon.com/fhtaantg.json" trigger="hover" colors="primary:#34d399,secondary:#6ee7b7" style="width:24px;height:24px"></lord-icon>
            </div>
            <div>
                <h3 class="text-white font-semibold text-sm">Kelola Projects</h3>
                <p class="text-white/30 text-xs">Lihat semua project</p>
            </div>
        </a>
    </div>

    {{-- Projects Summary --}}
    @if($projectStats['total'] > 0)
    <div class="glass-card p-5 md:p-6 animate-fade-in" style="animation-delay: 0.15s;">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2">
                <lord-icon src="https://cdn.lordicon.com/fhtaantg.json" trigger="loop" delay="5000" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:24px;height:24px"></lord-icon>
                <h2 class="text-lg font-bold text-white">Projects</h2>
            </div>
            <a href="{{ route('projects.index') }}" class="text-violet-400 hover:text-violet-300 font-medium text-sm flex items-center gap-1 transition">
                <span>Semua</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        {{-- Project Stats Mini --}}
        <div class="flex items-center gap-6 mb-5 pb-5 border-b border-white/5">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-violet-400"></div>
                <span class="text-white/40 text-xs">Total</span>
                <span class="text-white font-bold text-sm">{{ $projectStats['total'] }}</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-amber-400"></div>
                <span class="text-white/40 text-xs">Aktif</span>
                <span class="text-amber-400 font-bold text-sm">{{ $projectStats['pending'] }}</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                <span class="text-white/40 text-xs">Selesai</span>
                <span class="text-emerald-400 font-bold text-sm">{{ $projectStats['completed'] }}</span>
            </div>
        </div>

        {{-- Recent Projects --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($projects as $project)
            <a href="{{ route('projects.show', $project) }}" class="glass-card-light p-4 card-hover block group">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-semibold text-white text-sm group-hover:text-violet-300 transition truncate flex-1">{{ $project->name }}</h3>
                    @if($project->status === 'completed')
                    <span class="ml-2 px-2 py-0.5 bg-emerald-500/15 text-emerald-400 rounded-full text-[10px] font-semibold flex-shrink-0">Selesai</span>
                    @elseif($project->status === 'on_hold')
                    <span class="ml-2 px-2 py-0.5 bg-amber-500/15 text-amber-400 rounded-full text-[10px] font-semibold flex-shrink-0">Ditunda</span>
                    @else
                    <span class="ml-2 px-2 py-0.5 bg-violet-500/15 text-violet-400 rounded-full text-[10px] font-semibold flex-shrink-0">Aktif</span>
                    @endif
                </div>
                
                {{-- Progress Bar --}}
                <div class="mb-3">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-white/30 text-[10px] font-medium">Progress</span>
                        <span class="text-violet-400 text-[10px] font-bold">{{ $project->progress }}%</span>
                    </div>
                    <div class="w-full bg-white/5 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-violet-500 to-indigo-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ $project->progress }}%"></div>
                    </div>
                </div>

                {{-- Task Stats --}}
                <div class="flex items-center gap-3 text-[11px] text-white/30">
                    <span>📋 {{ $project->total_tasks }}</span>
                    <span>✅ {{ $project->completed_tasks }}</span>
                    <span>⏳ {{ $project->pending_tasks }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Calendar View --}}
    <div class="glass-card p-4 md:p-6 animate-fade-in" style="animation-delay: 0.2s;">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-5 gap-3">
            <div class="flex items-center gap-2">
                <lord-icon src="https://cdn.lordicon.com/kbtmbyzy.json" trigger="loop" delay="5000" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:24px;height:24px"></lord-icon>
                <h2 class="text-lg font-bold text-white">Kalender Task</h2>
            </div>
            
            {{-- Legend --}}
            <div class="flex items-center gap-4 text-xs text-white/40">
                <span class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 bg-red-500 rounded-full"></span> Overdue
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 bg-amber-500 rounded-full"></span> Pending
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full"></span> Done
                </span>
            </div>
        </div>

        <div id="calendar"></div>
    </div>
</div>

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<style>
/* FullCalendar Dark Theme */
.fc {
    --fc-border-color: rgba(255, 255, 255, 0.06);
    --fc-page-bg-color: transparent;
    --fc-neutral-bg-color: rgba(255, 255, 255, 0.02);
    --fc-today-bg-color: rgba(139, 92, 246, 0.08);
    --fc-event-border-color: transparent;
}

.fc .fc-col-header-cell-cushion,
.fc .fc-daygrid-day-number,
.fc .fc-timegrid-slot-label-cushion {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.8rem;
}

.fc .fc-daygrid-day-number {
    color: rgba(255, 255, 255, 0.6);
}

.fc .fc-day-today .fc-daygrid-day-number {
    color: #a78bfa;
    font-weight: 700;
}

.fc .fc-toolbar-title {
    color: white !important;
    font-size: 1.1rem !important;
    font-weight: 700 !important;
}

.fc .fc-button {
    border-radius: 8px !important;
    transition: all 0.2s !important;
    font-size: 0.8rem !important;
    padding: 6px 12px !important;
}

.fc .fc-button-primary {
    background-color: rgba(139, 92, 246, 0.2) !important;
    border-color: rgba(139, 92, 246, 0.3) !important;
    color: #a78bfa !important;
}

.fc .fc-button-primary:hover {
    background-color: rgba(139, 92, 246, 0.35) !important;
}

.fc .fc-button-primary.fc-button-active,
.fc .fc-button-primary:not(:disabled):active {
    background-color: rgba(139, 92, 246, 0.4) !important;
    border-color: rgba(139, 92, 246, 0.5) !important;
}

.fc .fc-button-primary:disabled {
    background-color: rgba(255, 255, 255, 0.05) !important;
    border-color: rgba(255, 255, 255, 0.08) !important;
    color: rgba(255, 255, 255, 0.2) !important;
}

.fc-event {
    border-radius: 6px !important;
    padding: 2px 6px !important;
    font-size: 0.75rem !important;
    font-weight: 500 !important;
}

@keyframes blink-overdue {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}

.fc-event-overdue {
    animation: blink-overdue 1.5s ease-in-out infinite;
}

@media (max-width: 767px) {
    .fc .fc-toolbar {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .fc .fc-toolbar-chunk {
        display: flex;
        justify-content: center;
        width: 100%;
    }
    .fc .fc-toolbar-title {
        font-size: 1rem !important;
    }
    .fc .fc-button {
        padding: 4px 8px !important;
        font-size: 0.7rem !important;
    }
}
</style>
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const events = @json($calendarEvents);
    
    window.openEditTask = function(taskId) {
        window.location.href = '{{ route("tasks.edit", ":id") }}'.replace(':id', taskId);
    };

    window.openShowTask = function(taskId) {
        window.location.href = '{{ route("tasks.show", ":id") }}'.replace(':id', taskId);
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
        eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
        slotLabelFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
        navLinks: true,
        eventDidMount: function(info) {
            const props = info.event.extendedProps;
            const taskDateTime = new Date(props.due_date + 'T' + props.due_time);
            if (taskDateTime < new Date() && props.status !== 'done') {
                info.el.classList.add('fc-event-overdue');
            }
        },
        windowResize: function() {
            if (window.innerWidth < 768) {
                calendar.changeView('timeGridDay');
            } else {
                calendar.changeView('dayGridMonth');
            }
        }
    });
    
    calendar.render();
    
    function showTaskModal(event) {
        const props = event.extendedProps;
        const status = props.status;
        const description = props.description || 'Tidak ada deskripsi';
        const waNotified = props.wa_notified;
        
        let statusBadge = '';
        if (status === 'done') {
            statusBadge = '<span class="px-3 py-1 bg-emerald-500/15 text-emerald-400 rounded-full text-xs font-semibold">✅ Selesai</span>';
        } else {
            const taskDateTime = new Date(props.due_date + 'T' + props.due_time);
            if (taskDateTime < new Date()) {
                statusBadge = '<span class="px-3 py-1 bg-red-500/15 text-red-400 rounded-full text-xs font-semibold">⚠️ Terlambat</span>';
            } else {
                statusBadge = '<span class="px-3 py-1 bg-amber-500/15 text-amber-400 rounded-full text-xs font-semibold">⏳ Pending</span>';
            }
        }
        
        const taskDateTime = new Date(props.due_date + 'T' + props.due_time);
        const formattedDate = taskDateTime.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        const formattedTime = taskDateTime.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        
        const safeDescription = description.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\n/g, '<br>');
        const safeTitle = event.title.replace(/</g, '&lt;').replace(/>/g, '&gt;');
        
        const modalHTML = `
            <div id="taskModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 animate-fade-in">
                <div class="absolute inset-0 bg-black/60 backdrop-filter backdrop-blur-sm" onclick="closeTaskModal()"></div>
                <div class="relative w-full max-w-md max-h-[85vh] overflow-y-auto rounded-2xl" style="background: linear-gradient(180deg, #1e1e3f 0%, #151530 100%); border: 1px solid rgba(255,255,255,0.08);">
                    <div class="p-6 border-b border-white/5">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 pr-4">
                                <p class="text-violet-400 text-[10px] font-bold uppercase tracking-widest mb-2">Task</p>
                                <h3 class="text-lg font-bold text-white mb-3 break-words">${safeTitle}</h3>
                                ${statusBadge}
                            </div>
                            <button onclick="closeTaskModal()" class="text-white/30 hover:text-white p-1 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-lg bg-violet-500/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white/30 text-xs mb-0.5">Deadline</p>
                                <p class="text-white text-sm font-medium">${formattedDate}</p>
                                <p class="text-violet-400 font-bold text-base">${formattedTime}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-lg bg-violet-500/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white/30 text-xs mb-0.5">Deskripsi</p>
                                <p class="text-white/70 text-sm leading-relaxed">${safeDescription}</p>
                            </div>
                        </div>
                        
                        ${waNotified ? `
                        <div class="flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/15 rounded-xl p-3">
                            <span class="text-emerald-400 text-sm font-medium">📱 Notifikasi WA terkirim</span>
                        </div>
                        ` : ''}
                    </div>
                    
                    <div class="p-4 border-t border-white/5 flex items-center justify-center gap-3">
                        <button onclick="openShowTask('${event.id}')" class="btn-ghost px-4 py-2.5 rounded-xl text-sm font-medium flex items-center gap-2">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="hover" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:18px;height:18px"></lord-icon>
                            Detail
                        </button>
                        <button onclick="openEditTask('${event.id}')" class="btn-ghost px-4 py-2.5 rounded-xl text-sm font-medium flex items-center gap-2">
                            <lord-icon src="https://cdn.lordicon.com/wuvorxbv.json" trigger="hover" colors="primary:#60a5fa,secondary:#93c5fd" style="width:18px;height:18px"></lord-icon>
                            Edit
                        </button>
                        <button onclick="closeTaskModal()" class="btn-ghost px-4 py-2.5 rounded-xl text-sm font-medium flex items-center gap-2">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    window.closeTaskModal = function() {
        const modal = document.getElementById('taskModal');
        if (modal) {
            modal.style.opacity = '0';
            modal.style.transition = 'opacity 0.2s ease';
            setTimeout(() => modal.remove(), 200);
        }
    };

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') closeTaskModal();
    });
});
</script>
@endpush
@endsection
