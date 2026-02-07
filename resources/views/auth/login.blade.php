@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full animate-fade-in">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="inline-block p-4 bg-white rounded-2xl shadow-2xl mb-4 flex items-center justify-center">
                <lord-icon
                    src="https://cdn.lordicon.com/uphbloed.json"
                    trigger="loop"
                    colors="primary:#9333ea,secondary:#e9d5ff"
                    style="width:64px;height:64px">
                </lord-icon>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">DailyTask</h1>
            <p class="text-purple-200">Task & Reminder via WhatsApp</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <div class="flex items-center space-x-3 mb-6">
                <div class="bg-purple-100 p-3 rounded-lg flex items-center justify-center">
                    <lord-icon
                        src="https://cdn.lordicon.com/dxjqoygy.json"
                        trigger="hover"
                        colors="primary:#9333ea,secondary:#e9d5ff"
                        style="width:28px;height:28px">
                    </lord-icon>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Masuk ke Akun</h2>
            </div>

            @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                <div class="flex items-center">
                    <div class="mr-2 flex-shrink-0">
                        <lord-icon
                            src="https://cdn.lordicon.com/bazyvshu.json"
                            trigger="loop"
                            colors="primary:#ef4444,secondary:#fecaca"
                            style="width:20px;height:20px">
                        </lord-icon>
                    </div>
                    <p class="text-red-700 text-sm font-medium">{{ $errors->first() }}</p>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <lord-icon
                                src="https://cdn.lordicon.com/tkgyrmwc.json"
                                trigger="hover"
                                colors="primary:#9ca3af,secondary:#d1d5db"
                                style="width:20px;height:20px">
                            </lord-icon>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <lord-icon
                                src="https://cdn.lordicon.com/rqqkvjqf.json"
                                trigger="hover"
                                colors="primary:#9ca3af,secondary:#d1d5db"
                                style="width:20px;height:20px">
                            </lord-icon>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <label for="remember" class="ml-2 text-sm text-gray-700">Ingat saya</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full btn-primary text-white font-semibold py-3 rounded-lg shadow-lg flex items-center justify-center space-x-2">
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
        <p class="text-center text-purple-200 text-sm mt-8">
            © 2026 DailyTask. All rights reserved.
        </p>
    </div>
</div>
@endsection
