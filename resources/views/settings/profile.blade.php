@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header & Back --}}
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 animate-fade-in">
        <div>
            <a href="{{ route('settings.index') }}" class="inline-flex items-center gap-2 text-white/40 hover:text-white/70 text-sm transition mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Pengaturan
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl md:text-3xl font-bold text-white leading-tight">Profil Pengguna</h1>
            </div>
            <p class="text-white/50 text-sm mt-2">Kelola informasi akun Anda</p>
        </div>
        
        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-ghost px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 text-red-400 hover:text-red-300 hover:bg-red-500/10 transition border border-transparent hover:border-red-500/20">
                    <lord-icon src="https://cdn.lordicon.com/moscwhoj.json" trigger="hover" colors="primary:#f87171,secondary:#fca5a5" style="width:18px;height:18px"></lord-icon>
                    Logout
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2 animate-fade-in">
        <lord-icon src="https://cdn.lordicon.com/egiwmiit.json" trigger="loop" colors="primary:#34d399,secondary:#34d399" style="width:20px;height:20px"></lord-icon>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Profile Form --}}
        <div class="glass-card p-6 md:p-8 animate-fade-in" style="animation-delay: 0.1s;">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-violet-500/15 flex items-center justify-center">
                    <lord-icon src="https://cdn.lordicon.com/dxjqoygy.json" trigger="hover" colors="primary:#a78bfa,secondary:#c4b5fd" style="width:24px;height:24px"></lord-icon>
                </div>
                <h2 class="text-xl font-bold text-white">Informasi Profil</h2>
            </div>
            
            <form method="POST" action="{{ route('settings.profile.update') }}" class="space-y-5">
                @csrf
                @method('PUT')
                
                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-white/60 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                           class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-white/20 focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm">
                    @error('name')
                    <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-white/60 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                           class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-white/20 focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm">
                    @error('email')
                    <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-medium text-white/60 mb-2">Nomor Telepon (WhatsApp)</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', Auth::user()->phone_number) }}" required
                           class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-white/20 focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm"
                           placeholder="628123456789">
                    <p class="text-white/30 text-xs mt-1.5">Format: 628xxxxxxxxx (tanpa +)</p>
                    @error('phone_number')
                    <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2 border-t border-white/5">
                    <button type="submit" class="w-full btn-primary text-white font-semibold py-3 rounded-xl text-sm flex items-center justify-center gap-2">
                        <lord-icon src="https://cdn.lordicon.com/sbiheqdr.json" trigger="loop" delay="3000" colors="primary:#ffffff,secondary:#ffffff" style="width:20px;height:20px"></lord-icon>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Password Form --}}
        <div class="glass-card p-6 md:p-8 animate-fade-in" style="animation-delay: 0.15s;">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-orange-500/15 flex items-center justify-center">
                    <lord-icon src="https://cdn.lordicon.com/rqqkvjqf.json" trigger="hover" colors="primary:#fb923c,secondary:#fdba74" style="width:24px;height:24px"></lord-icon>
                </div>
                <h2 class="text-xl font-bold text-white">Ubah Password</h2>
            </div>
            
            <form method="POST" action="{{ route('settings.password.update') }}" class="space-y-5">
                @csrf
                @method('PUT')
                
                {{-- Current Password --}}
                <div>
                    <label class="block text-sm font-medium text-white/60 mb-2">Password Saat Ini</label>
                    <input type="password" name="current_password" required
                           class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500/50 transition outline-none text-sm">
                    @error('current_password')
                    <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New Password --}}
                <div>
                    <label class="block text-sm font-medium text-white/60 mb-2">Password Baru</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500/50 transition outline-none text-sm">
                    <p class="text-white/30 text-xs mt-1.5">Minimal 8 karakter</p>
                    @error('password')
                    <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-sm font-medium text-white/60 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500/50 transition outline-none text-sm">
                </div>

                <div class="pt-2 border-t border-white/5">
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-400 hover:to-red-400 text-white font-semibold py-3 rounded-xl text-sm flex items-center justify-center gap-2 transition shadow-lg">
                        <lord-icon src="https://cdn.lordicon.com/rqqkvjqf.json" trigger="loop" delay="3000" colors="primary:#ffffff,secondary:#ffffff" style="width:20px;height:20px"></lord-icon>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
