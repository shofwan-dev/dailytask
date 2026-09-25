<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DailyTask - Task & Reminder via WhatsApp">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DailyTask') - Task & Reminder</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Lordicon -->
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: #0f0f23;
            min-height: 100vh;
        }
        
        /* ===== Sidebar ===== */
        .sidebar {
            background: linear-gradient(180deg, #1a1a3e 0%, #0f0f23 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            width: 240px;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar.collapsed {
            width: 72px;
        }
        
        .sidebar.collapsed .sidebar-label,
        .sidebar.collapsed .sidebar-logo-text,
        .sidebar.collapsed .sidebar-user-info {
            display: none;
        }
        
        .sidebar.collapsed .sidebar-nav-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        
        .sidebar-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            text-decoration: none;
            margin: 2px 8px;
        }
        
        .sidebar-nav-item:hover {
            background: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.9);
        }
        
        .sidebar-nav-item.active {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.3), rgba(59, 130, 246, 0.2));
            color: #a78bfa;
            font-weight: 600;
            border: 1px solid rgba(139, 92, 246, 0.2);
        }
        
        .sidebar-nav-item.active lord-icon {
            filter: brightness(1.5);
        }
        
        /* ===== Top Bar ===== */
        .topbar {
            background: rgba(15, 15, 35, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }
        
        /* ===== Main Content ===== */
        .main-content {
            background: #0f0f23;
            min-height: 100vh;
        }
        
        /* ===== Cards ===== */
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
        }
        
        .glass-card-light {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(139, 92, 246, 0.15);
            border-color: rgba(139, 92, 246, 0.2);
        }
        
        /* ===== Buttons ===== */
        .btn-primary {
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            transition: all 0.3s ease;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.35);
        }
        
        .btn-ghost {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.2s ease;
        }
        
        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
        }
        
        /* ===== Animations ===== */
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* ===== Form Elements ===== */
        .checkbox-custom {
            appearance: none;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid rgba(139, 92, 246, 0.4);
            border-radius: 6px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.03);
        }
        
        .checkbox-custom:checked {
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            border-color: #8b5cf6;
        }
        
        .checkbox-custom:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            font-size: 11px;
        }

        /* ===== Utility ===== */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* ===== Scrollbar ===== */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(139, 92, 246, 0.3);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(139, 92, 246, 0.5);
        }

        /* ===== Search Modal ===== */
        .search-modal-backdrop {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }

        .search-input-wrapper {
            background: #1a1a3e;
            border: 1px solid rgba(139, 92, 246, 0.3);
            border-radius: 16px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }

        /* ===== Bottom Nav (Mobile) ===== */
        .bottom-nav {
            background: rgba(15, 15, 35, 0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            padding: 6px 0;
            font-size: 0.625rem;
            color: rgba(255, 255, 255, 0.4);
            transition: all 0.2s ease;
            text-decoration: none;
            flex: 1;
        }

        .bottom-nav-item.active {
            color: #a78bfa;
        }

        .bottom-nav-item:hover {
            color: rgba(255, 255, 255, 0.8);
        }

        .bottom-nav-fab {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: -20px;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
            transition: all 0.2s ease;
        }

        .bottom-nav-fab:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.5);
        }

        /* ===== Toast ===== */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
        }

        .toast {
            background: rgba(30, 30, 60, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInRight 0.4s ease-out;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .toast-success {
            border-left: 3px solid #10b981;
        }

        .toast-error {
            border-left: 3px solid #ef4444;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* ===== Stats Cards ===== */
        .stat-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(139, 92, 246, 0.15);
        }

        /* Responsive text utilities */
        @media (max-width: 640px) {
            .text-responsive {
                font-size: 0.875rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @auth
    {{-- ===== AUTHENTICATED LAYOUT ===== --}}
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar (Desktop) --}}
        <aside class="sidebar hidden md:flex flex-col fixed left-0 top-0 h-full z-30" id="sidebar">
            {{-- Logo --}}
            <div class="flex items-center gap-3 px-5 py-5 border-b border-white/5">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                    <lord-icon src="https://cdn.lordicon.com/cwwqfdik.json" trigger="loop" delay="3000" colors="primary:#ffffff,secondary:#ffffff" style="width:20px;height:20px"></lord-icon>
                </div>
                <span class="sidebar-logo-text text-white font-bold text-lg tracking-tight">DailyTask</span>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto py-4 space-y-1">
                <p class="sidebar-label text-[10px] font-bold uppercase tracking-widest text-white/25 px-5 mb-2">Menu</p>
                
                <a href="{{ route('dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <lord-icon src="https://cdn.lordicon.com/wmwqvixz.json" trigger="hover" colors="primary:{{ request()->routeIs('dashboard') ? '#a78bfa' : '#9ca3af' }},secondary:{{ request()->routeIs('dashboard') ? '#c4b5fd' : '#d1d5db' }}" style="width:22px;height:22px"></lord-icon>
                    <span class="sidebar-label">Dashboard</span>
                </a>
                
                <a href="{{ route('tasks.index') }}" class="sidebar-nav-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                    <lord-icon src="https://cdn.lordicon.com/bjgdeprq.json" trigger="hover" colors="primary:{{ request()->routeIs('tasks.*') ? '#a78bfa' : '#9ca3af' }},secondary:{{ request()->routeIs('tasks.*') ? '#c4b5fd' : '#d1d5db' }}" style="width:22px;height:22px"></lord-icon>
                    <span class="sidebar-label">Tasks</span>
                </a>
                
                <a href="{{ route('projects.index') }}" class="sidebar-nav-item {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                    <lord-icon src="https://cdn.lordicon.com/fhtaantg.json" trigger="hover" colors="primary:{{ request()->routeIs('projects.*') ? '#a78bfa' : '#9ca3af' }},secondary:{{ request()->routeIs('projects.*') ? '#c4b5fd' : '#d1d5db' }}" style="width:22px;height:22px"></lord-icon>
                    <span class="sidebar-label">Projects</span>
                </a>

                <div class="my-4 mx-5 border-t border-white/5"></div>
                <p class="sidebar-label text-[10px] font-bold uppercase tracking-widest text-white/25 px-5 mb-2">System</p>
                
                <a href="{{ route('settings.index') }}" class="sidebar-nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <lord-icon src="https://cdn.lordicon.com/hwuyodym.json" trigger="hover" colors="primary:{{ request()->routeIs('settings.*') ? '#a78bfa' : '#9ca3af' }},secondary:{{ request()->routeIs('settings.*') ? '#c4b5fd' : '#d1d5db' }}" style="width:22px;height:22px"></lord-icon>
                    <span class="sidebar-label">Pengaturan</span>
                </a>
            </nav>

            {{-- User Section --}}
            <div class="border-t border-white/5 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-500 to-indigo-400 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="sidebar-user-info flex-1 min-w-0">
                        <p class="text-white text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                        <p class="text-white/40 text-xs truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="sidebar-nav-item w-full text-red-400/70 hover:text-red-400 hover:bg-red-500/10 !mx-0">
                        <lord-icon src="https://cdn.lordicon.com/moscwhoj.json" trigger="hover" colors="primary:#f87171,secondary:#fca5a5" style="width:20px;height:20px"></lord-icon>
                        <span class="sidebar-label">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col md:ml-[240px] min-h-screen">
            {{-- Top Bar --}}
            <header class="topbar sticky top-0 z-20 px-4 md:px-6 py-3 flex items-center justify-between gap-4">
                {{-- Mobile Menu Toggle --}}
                <button class="md:hidden text-white/60 hover:text-white p-1" onclick="toggleMobileSidebar()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                {{-- Page Title --}}
                <div class="flex-1 min-w-0">
                    <h2 class="text-white font-semibold text-lg truncate">@yield('title', 'DailyTask')</h2>
                </div>

                {{-- Search Trigger --}}
                <button onclick="openSearchModal()" class="flex items-center gap-2 btn-ghost px-3 py-2 rounded-xl text-sm cursor-pointer" id="searchTrigger">
                    <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="hidden sm:inline text-white/40 text-xs">Cari...</span>
                    <kbd class="hidden sm:inline-flex items-center gap-0.5 rounded bg-white/5 px-1.5 py-0.5 text-[10px] text-white/30 border border-white/10">
                        Ctrl+K
                    </kbd>
                </button>

                {{-- User Avatar --}}
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-500 to-indigo-400 flex items-center justify-center text-white text-sm font-bold cursor-pointer" title="{{ Auth::user()->name }}">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto px-4 md:px-6 py-6 pb-24 md:pb-6">
                @yield('content')
            </main>
        </div>

        {{-- Mobile Sidebar Overlay --}}
        <div id="mobileSidebarOverlay" class="fixed inset-0 bg-black/60 z-40 hidden md:hidden" onclick="closeMobileSidebar()"></div>
        
        {{-- Mobile Sidebar --}}
        <aside id="mobileSidebar" class="fixed left-0 top-0 h-full w-[260px] z-50 hidden md:hidden transform -translate-x-full transition-transform duration-300 ease-in-out" style="background: linear-gradient(180deg, #1a1a3e 0%, #0f0f23 100%);">
            {{-- Logo --}}
            <div class="flex items-center justify-between px-5 py-5 border-b border-white/5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500 to-indigo-500 flex items-center justify-center">
                        <lord-icon src="https://cdn.lordicon.com/cwwqfdik.json" trigger="loop" delay="3000" colors="primary:#ffffff,secondary:#ffffff" style="width:20px;height:20px"></lord-icon>
                    </div>
                    <span class="text-white font-bold text-lg">DailyTask</span>
                </div>
                <button onclick="closeMobileSidebar()" class="text-white/40 hover:text-white p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 overflow-y-auto py-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <lord-icon src="https://cdn.lordicon.com/wmwqvixz.json" trigger="hover" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:22px;height:22px"></lord-icon>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('tasks.index') }}" class="sidebar-nav-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                    <lord-icon src="https://cdn.lordicon.com/bjgdeprq.json" trigger="hover" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:22px;height:22px"></lord-icon>
                    <span>Tasks</span>
                </a>
                <a href="{{ route('projects.index') }}" class="sidebar-nav-item {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                    <lord-icon src="https://cdn.lordicon.com/fhtaantg.json" trigger="hover" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:22px;height:22px"></lord-icon>
                    <span>Projects</span>
                </a>
                <div class="my-4 mx-5 border-t border-white/5"></div>
                <a href="{{ route('settings.index') }}" class="sidebar-nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <lord-icon src="https://cdn.lordicon.com/hwuyodym.json" trigger="hover" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:22px;height:22px"></lord-icon>
                    <span>Pengaturan</span>
                </a>
            </nav>

            {{-- User --}}
            <div class="border-t border-white/5 p-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-500 to-indigo-400 flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-nav-item w-full text-red-400/70 hover:text-red-400 hover:bg-red-500/10 !mx-0">
                        <lord-icon src="https://cdn.lordicon.com/moscwhoj.json" trigger="hover" colors="primary:#f87171,secondary:#fca5a5" style="width:20px;height:20px"></lord-icon>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Bottom Navigation (Mobile) --}}
        <nav class="bottom-nav fixed bottom-0 left-0 right-0 z-20 md:hidden flex items-end justify-around px-2 pb-[env(safe-area-inset-bottom)]">
            <a href="{{ route('dashboard') }}" class="bottom-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <lord-icon src="https://cdn.lordicon.com/wmwqvixz.json" trigger="hover" colors="primary:{{ request()->routeIs('dashboard') ? '#a78bfa' : '#6b7280' }},secondary:{{ request()->routeIs('dashboard') ? '#c4b5fd' : '#9ca3af' }}" style="width:22px;height:22px"></lord-icon>
                <span>Home</span>
            </a>
            <a href="{{ route('tasks.index') }}" class="bottom-nav-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                <lord-icon src="https://cdn.lordicon.com/bjgdeprq.json" trigger="hover" colors="primary:{{ request()->routeIs('tasks.*') ? '#a78bfa' : '#6b7280' }},secondary:{{ request()->routeIs('tasks.*') ? '#c4b5fd' : '#9ca3af' }}" style="width:22px;height:22px"></lord-icon>
                <span>Tasks</span>
            </a>
            <a href="{{ route('tasks.create') }}" class="bottom-nav-item">
                <div class="bottom-nav-fab">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <span class="mt-1">Tambah</span>
            </a>
            <a href="{{ route('projects.index') }}" class="bottom-nav-item {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                <lord-icon src="https://cdn.lordicon.com/fhtaantg.json" trigger="hover" colors="primary:{{ request()->routeIs('projects.*') ? '#a78bfa' : '#6b7280' }},secondary:{{ request()->routeIs('projects.*') ? '#c4b5fd' : '#9ca3af' }}" style="width:22px;height:22px"></lord-icon>
                <span>Projects</span>
            </a>
            <a href="{{ route('settings.index') }}" class="bottom-nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <lord-icon src="https://cdn.lordicon.com/hwuyodym.json" trigger="hover" colors="primary:{{ request()->routeIs('settings.*') ? '#a78bfa' : '#6b7280' }},secondary:{{ request()->routeIs('settings.*') ? '#c4b5fd' : '#9ca3af' }}" style="width:22px;height:22px"></lord-icon>
                <span>Setting</span>
            </a>
        </nav>
    </div>

    {{-- Search Modal --}}
    <div id="searchModal" class="fixed inset-0 z-[60] hidden">
        <div class="search-modal-backdrop absolute inset-0" onclick="closeSearchModal()"></div>
        <div class="relative flex items-start justify-center pt-[15vh] px-4">
            <div class="search-input-wrapper w-full max-w-lg p-2">
                <div class="flex items-center gap-3 px-4">
                    <svg class="w-5 h-5 text-violet-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input 
                        type="text" 
                        id="searchInput" 
                        class="flex-1 bg-transparent text-white text-base outline-none placeholder:text-white/30 py-3" 
                        placeholder="Cari task atau project..."
                        autocomplete="off"
                    >
                    <kbd class="rounded bg-white/5 px-2 py-1 text-[10px] text-white/30 border border-white/10">ESC</kbd>
                </div>
                <div id="searchResults" class="max-h-[50vh] overflow-y-auto"></div>
            </div>
        </div>
    </div>

    @else
    {{-- ===== GUEST LAYOUT (Login/Register) ===== --}}
    @yield('content')
    @endauth

    {{-- Toast Notifications --}}
    @if(session('success'))
    <div class="toast-container animate-fade-in" id="toastContainer">
        <div class="toast toast-success">
            <lord-icon src="https://cdn.lordicon.com/egiwmiit.json" trigger="in" colors="primary:#10b981,secondary:#10b981" style="width:22px;height:22px"></lord-icon>
            <span class="text-white text-sm font-medium">{{ session('success') }}</span>
            <button onclick="dismissToast()" class="ml-2 text-white/40 hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="toast-container animate-fade-in" id="toastContainer">
        <div class="toast toast-error">
            <lord-icon src="https://cdn.lordicon.com/wdnwtnyn.json" trigger="in" colors="primary:#ef4444,secondary:#ef4444" style="width:22px;height:22px"></lord-icon>
            <span class="text-white text-sm font-medium">{{ session('error') }}</span>
            <button onclick="dismissToast()" class="ml-2 text-white/40 hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif

    <script>
        // ===== Toast =====
        function dismissToast() {
            const container = document.getElementById('toastContainer');
            if (container) {
                container.style.opacity = '0';
                container.style.transform = 'translateX(100px)';
                container.style.transition = 'all 0.3s ease';
                setTimeout(() => container.remove(), 300);
            }
        }
        // Auto-dismiss toast after 4 seconds
        setTimeout(dismissToast, 4000);

        // ===== Mobile Sidebar =====
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('mobileSidebarOverlay');
            sidebar.classList.remove('hidden');
            overlay.classList.remove('hidden');
            requestAnimationFrame(() => {
                sidebar.style.transform = 'translateX(0)';
            });
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('mobileSidebarOverlay');
            sidebar.style.transform = 'translateX(-100%)';
            setTimeout(() => {
                sidebar.classList.add('hidden');
                overlay.classList.add('hidden');
            }, 300);
        }

        // ===== Search Modal =====
        function openSearchModal() {
            document.getElementById('searchModal').classList.remove('hidden');
            setTimeout(() => document.getElementById('searchInput').focus(), 100);
        }

        function closeSearchModal() {
            document.getElementById('searchModal').classList.add('hidden');
            document.getElementById('searchInput').value = '';
            document.getElementById('searchResults').innerHTML = '';
        }

        // Keyboard shortcut: Ctrl+K to open search
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                const modal = document.getElementById('searchModal');
                if (modal) {
                    if (modal.classList.contains('hidden')) {
                        openSearchModal();
                    } else {
                        closeSearchModal();
                    }
                }
            }
            if (e.key === 'Escape') {
                closeSearchModal();
            }
        });

        // Live search
        let searchTimer;
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimer);
                const query = this.value.trim();
                
                if (query.length < 2) {
                    document.getElementById('searchResults').innerHTML = '';
                    return;
                }

                searchTimer = setTimeout(() => {
                    // Search in tasks and projects via page content
                    performSearch(query);
                }, 250);
            });
        }

        function performSearch(query) {
            const resultsContainer = document.getElementById('searchResults');
            
            // Quick navigation shortcuts
            const shortcuts = [
                { label: 'Dashboard', url: '{{ route("dashboard") }}', icon: '🏠' },
                { label: 'Tasks', url: '{{ route("tasks.index") }}', icon: '📋' },
                { label: 'Tambah Task Baru', url: '{{ route("tasks.create") }}', icon: '➕' },
                { label: 'Projects', url: '{{ route("projects.index") }}', icon: '📁' },
                { label: 'Tambah Project', url: '{{ route("projects.create") }}', icon: '➕' },
                { label: 'Pengaturan', url: '{{ route("settings.index") }}', icon: '⚙️' },
            ];

            const q = query.toLowerCase();
            const matched = shortcuts.filter(s => s.label.toLowerCase().includes(q));

            if (matched.length === 0) {
                resultsContainer.innerHTML = `
                    <div class="px-4 py-8 text-center text-white/30 text-sm">
                        Tidak ditemukan hasil untuk "${query}"
                    </div>
                `;
                return;
            }

            resultsContainer.innerHTML = `
                <div class="border-t border-white/5 mt-1 pt-1">
                    <p class="px-4 py-2 text-[10px] text-white/25 font-bold uppercase tracking-widest">Navigasi</p>
                    ${matched.map(s => `
                        <a href="${s.url}" class="flex items-center gap-3 px-4 py-3 hover:bg-white/5 rounded-lg mx-1 transition text-white/70 hover:text-white">
                            <span class="text-base">${s.icon}</span>
                            <span class="text-sm">${s.label}</span>
                        </a>
                    `).join('')}
                </div>
            `;
        }
    </script>

    @stack('scripts')
</body>
</html>
