@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full animate-fade-in">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto rounded-3xl bg-violet-500/15 border border-violet-500/25 shadow-2xl mb-4 flex items-center justify-center">
                <lord-icon
                    src="https://cdn.lordicon.com/uphbloed.json"
                    trigger="loop"
                    colors="primary:#a78bfa,secondary:#c4b5fd"
                    style="width:52px;height:52px">
                </lord-icon>
            </div>
            <h1 class="text-4xl font-extrabold text-white tracking-tight mb-2">DailyTask</h1>
            <p class="text-slate-300 font-medium">Task & Reminder via WhatsApp</p>
        </div>

        <!-- Login Card -->
        <div class="glass-card p-8 border border-white/10 shadow-2xl">
            <div class="flex items-center space-x-3 mb-6">
                <div class="bg-violet-500/15 p-2.5 rounded-xl border border-violet-500/20 flex items-center justify-center">
                    <lord-icon
                        src="https://cdn.lordicon.com/dxjqoygy.json"
                        trigger="hover"
                        colors="primary:#a78bfa,secondary:#c4b5fd"
                        style="width:24px;height:24px">
                    </lord-icon>
                </div>
                <h2 class="text-2xl font-bold text-white">Masuk ke Akun</h2>
            </div>

            @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 p-4 mb-6 rounded-xl">
                <div class="flex items-center">
                    <div class="mr-2.5 flex-shrink-0">
                        <lord-icon
                            src="https://cdn.lordicon.com/bazyvshu.json"
                            trigger="loop"
                            colors="primary:#f87171,secondary:#fca5a5"
                            style="width:20px;height:20px">
                        </lord-icon>
                    </div>
                    <p class="text-red-400 text-sm font-medium">{{ $errors->first() }}</p>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

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
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-violet-600 bg-white/10 border-white/20 rounded focus:ring-violet-500">
                    <label for="remember" class="ml-2.5 text-sm text-slate-300 font-medium">Ingat saya</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full btn-primary text-white font-semibold py-3 rounded-xl shadow-lg flex items-center justify-center space-x-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/jxwksgwv.json"
                        trigger="hover"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <span>Masuk</span>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center text-slate-300 text-sm mt-8">
            © 2026 DailyTask. All rights reserved.
        </p>
    </div>
</div>
@endsection
