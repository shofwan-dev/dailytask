@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full animate-fade-in">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="inline-block p-4 bg-white rounded-2xl shadow-2xl mb-4 flex items-center justify-center">
                <lord-icon
                    src="https://cdn.lordicon.com/qiuoixfo.json"
                    trigger="loop"
                    colors="primary:#9333ea,secondary:#e9d5ff"
                    style="width:64px;height:64px">
                </lord-icon>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">DailyTask</h1>
            <p class="text-purple-200">Buat akun baru</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Akun</h2>

            @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
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
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <lord-icon
                                src="https://cdn.lordicon.com/dxjqoygy.json"
                                trigger="hover"
                                colors="primary:#9ca3af,secondary:#d1d5db"
                                style="width:20px;height:20px">
                            </lord-icon>
                        </div>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            placeholder="John Doe">
                    </div>
                </div>

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

                <!-- Phone Number -->
                <div>
                    <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <lord-icon
                                src="https://cdn.lordicon.com/tftaqjwp.json"
                                trigger="hover"
                                colors="primary:#9ca3af,secondary:#d1d5db"
                                style="width:20px;height:20px">
                            </lord-icon>
                        </div>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            placeholder="628123456789">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Format: 628xxx (untuk notifikasi WhatsApp)</p>
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
                            placeholder="Min. 8 karakter">
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <lord-icon
                                src="https://cdn.lordicon.com/rqqkvjqf.json"
                                trigger="hover"
                                colors="primary:#9ca3af,secondary:#d1d5db"
                                style="width:20px;height:20px">
                            </lord-icon>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            placeholder="Ulangi password">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full btn-primary text-white font-semibold py-3 rounded-lg shadow-lg mt-6">
                    Daftar Sekarang
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:text-purple-700 transition">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-purple-200 text-sm mt-8">
            © 2026 DailyTask. All rights reserved.
        </p>
    </div>
</div>
@endsection
