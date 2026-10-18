@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full animate-fade-in">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto rounded-3xl bg-violet-500/15 border border-violet-500/25 shadow-2xl mb-4 flex items-center justify-center">
                <lord-icon
                    src="https://cdn.lordicon.com/qiuoixfo.json"
                    trigger="loop"
                    colors="primary:#a78bfa,secondary:#c4b5fd"
                    style="width:52px;height:52px">
                </lord-icon>
            </div>
            <h1 class="text-4xl font-extrabold text-white tracking-tight mb-2">DailyTask</h1>
            <p class="text-slate-300 font-medium">Buat akun baru</p>
        </div>

        <!-- Register Card -->
        <div class="glass-card p-8 border border-white/10 shadow-2xl">
            <h2 class="text-2xl font-bold text-white mb-6">Daftar Akun</h2>

            @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 p-4 mb-6 rounded-xl">
                <ul class="list-disc list-inside text-red-400 text-sm space-y-1 font-medium">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-200 mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <lord-icon
                                src="https://cdn.lordicon.com/dxjqoygy.json"
                                trigger="hover"
                                colors="primary:#cbd5e1,secondary:#94a3b8"
                                style="width:18px;height:18px">
                            </lord-icon>
                        </div>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-slate-400 focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm"
                            placeholder="John Doe">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-200 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <lord-icon
                                src="https://cdn.lordicon.com/tkgyrmwc.json"
                                trigger="hover"
                                colors="primary:#cbd5e1,secondary:#94a3b8"
                                style="width:18px;height:18px">
                            </lord-icon>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-slate-400 focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone_number" class="block text-sm font-semibold text-slate-200 mb-2">Nomor WhatsApp</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <lord-icon
                                src="https://cdn.lordicon.com/tftaqjwp.json"
                                trigger="hover"
                                colors="primary:#cbd5e1,secondary:#94a3b8"
                                style="width:18px;height:18px">
                            </lord-icon>
                        </div>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                            class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-slate-400 focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm"
                            placeholder="628123456789">
                    </div>
                    <p class="mt-1.5 text-xs text-slate-300 font-medium">Format: 628xxx (untuk notifikasi WhatsApp)</p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-200 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <lord-icon
                                src="https://cdn.lordicon.com/rqqkvjqf.json"
                                trigger="hover"
                                colors="primary:#cbd5e1,secondary:#94a3b8"
                                style="width:18px;height:18px">
                            </lord-icon>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-slate-400 focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm"
                            placeholder="Min. 8 karakter">
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-200 mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <lord-icon
                                src="https://cdn.lordicon.com/rqqkvjqf.json"
                                trigger="hover"
                                colors="primary:#cbd5e1,secondary:#94a3b8"
                                style="width:18px;height:18px">
                            </lord-icon>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-slate-400 focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50 transition outline-none text-sm"
                            placeholder="Ulangi password">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full btn-primary text-white font-semibold py-3 rounded-xl shadow-lg mt-6">
                    Daftar Sekarang
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-slate-300 text-sm">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-violet-400 font-semibold hover:text-violet-300 transition">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-slate-300 text-sm mt-8">
            © 2026 DailyTask. All rights reserved.
        </p>
    </div>
</div>
@endsection
