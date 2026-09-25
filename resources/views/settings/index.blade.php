@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="animate-fade-in">
        <h1 class="text-2xl md:text-3xl font-bold text-white">Pengaturan</h1>
        <p class="text-white/30 text-sm mt-1">Kelola preferensi akun dan sistem</p>
    </div>

    {{-- Settings Menu Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
        {{-- Profile --}}
        <a href="{{ route('settings.profile') }}" class="glass-card p-6 card-hover block group animate-fade-in" style="animation-delay: 0.1s;">
            <div class="flex items-start gap-4 mb-5">
                <div class="w-12 h-12 rounded-2xl bg-violet-500/10 flex items-center justify-center flex-shrink-0 group-hover:bg-violet-500/20 transition">
                    <lord-icon src="https://cdn.lordicon.com/dxjqoygy.json" trigger="loop" delay="3000" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:28px;height:28px"></lord-icon>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white group-hover:text-violet-300 transition">Profil Pengguna</h3>
                    <p class="text-white/40 text-sm mt-0.5">Kelola informasi pribadi akun Anda</p>
                </div>
            </div>
            <ul class="space-y-2 pt-4 border-t border-white/5">
                <li class="flex items-center gap-2 text-white/30 text-xs">
                    <div class="w-1 h-1 rounded-full bg-white/20"></div> Ubah nama dan email
                </li>
                <li class="flex items-center gap-2 text-white/30 text-xs">
                    <div class="w-1 h-1 rounded-full bg-white/20"></div> Update nomor telepon
                </li>
                <li class="flex items-center gap-2 text-white/30 text-xs">
                    <div class="w-1 h-1 rounded-full bg-white/20"></div> Ganti password
                </li>
            </ul>
        </a>

        {{-- WhatsApp --}}
        <a href="{{ route('settings.whatsapp') }}" class="glass-card p-6 card-hover block group animate-fade-in" style="animation-delay: 0.15s;">
            <div class="flex items-start gap-4 mb-5">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-500/20 transition">
                    <lord-icon src="https://cdn.lordicon.com/vmxvhdko.json" trigger="loop" delay="3000" colors="primary:#34d399,secondary:#6ee7b7" style="width:28px;height:28px"></lord-icon>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white group-hover:text-emerald-300 transition">WhatsApp Gateway</h3>
                    <p class="text-white/40 text-sm mt-0.5">Konfigurasi notifikasi WhatsApp</p>
                </div>
            </div>
            <ul class="space-y-2 pt-4 border-t border-white/5">
                <li class="flex items-center gap-2 text-white/30 text-xs">
                    <div class="w-1 h-1 rounded-full bg-white/20"></div> Setup API Key & Sender
                </li>
                <li class="flex items-center gap-2 text-white/30 text-xs">
                    <div class="w-1 h-1 rounded-full bg-white/20"></div> Konfigurasi Base URL
                </li>
                <li class="flex items-center gap-2 text-white/30 text-xs">
                    <div class="w-1 h-1 rounded-full bg-white/20"></div> Test koneksi Fonnte
                </li>
            </ul>
        </a>
    </div>

    {{-- Account Info Summary --}}
    <div class="glass-card p-6 mt-6 animate-fade-in" style="animation-delay: 0.2s;">
        <h3 class="text-sm font-bold text-white/50 uppercase tracking-widest mb-5 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Informasi Sistem
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div>
                <p class="text-white/30 text-[10px] font-bold uppercase tracking-wider mb-1">Nama</p>
                <p class="font-semibold text-white text-sm">{{ Auth::user()->name }}</p>
            </div>
            <div>
                <p class="text-white/30 text-[10px] font-bold uppercase tracking-wider mb-1">Email</p>
                <p class="font-semibold text-white text-sm truncate" title="{{ Auth::user()->email }}">{{ Auth::user()->email }}</p>
            </div>
            <div>
                <p class="text-white/30 text-[10px] font-bold uppercase tracking-wider mb-1">WhatsApp</p>
                <p class="font-semibold text-white text-sm">{{ Auth::user()->phone_number ?? '-' }}</p>
            </div>
            <div>
                <p class="text-white/30 text-[10px] font-bold uppercase tracking-wider mb-1">Terdaftar</p>
                <p class="font-semibold text-white text-sm">{{ Auth::user()->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
