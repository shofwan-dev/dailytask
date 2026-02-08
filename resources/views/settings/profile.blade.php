@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<div class="min-h-screen px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8 animate-fade-in">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/dxjqoygy.json"
                        trigger="loop"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:40px;height:40px">
                    </lord-icon>
                    <h1 class="text-3xl md:text-4xl font-bold text-white">Profil Pengguna</h1>
                </div>
                <p class="text-purple-200">Kelola informasi akun Anda</p>
            </div>
            <a href="{{ route('settings.index') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition backdrop-blur-sm border border-white/30 flex items-center space-x-2 self-start md:self-auto">
                <lord-icon
                    src="https://cdn.lordicon.com/jxwksgwv.json"
                    trigger="hover"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:20px;height:20px">
                </lord-icon>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Update Profile Form -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-6 animate-fade-in" style="animation-delay: 0.1s;">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Profil</h2>
            
            <form method="POST" action="{{ route('settings.profile.update') }}">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               required>
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon (WhatsApp)</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', Auth::user()->phone_number) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('phone_number') border-red-500 @enderror"
                               placeholder="628123456789"
                               required>
                        <p class="text-sm text-gray-500 mt-1">Format: 628xxxxxxxxx (tanpa +)</p>
                        @error('phone_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn-primary text-white px-6 py-3 rounded-lg font-semibold shadow-lg w-full flex items-center justify-center space-x-2">
                        <lord-icon
                            src="https://cdn.lordicon.com/sbiheqdr.json"
                            trigger="loop"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:24px;height:24px">
                        </lord-icon>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password Form -->
        <div class="bg-white rounded-xl shadow-lg p-8 animate-fade-in" style="animation-delay: 0.2s;">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Ubah Password</h2>
            
            <form method="POST" action="{{ route('settings.password.update') }}">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <!-- Current Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('current_password') border-red-500 @enderror"
                               required>
                        @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                        <input type="password" name="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-500 @enderror"
                               required>
                        <p class="text-sm text-gray-500 mt-1">Minimal 8 karakter</p>
                        @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               required>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-gradient-to-r from-orange-500 to-red-600 text-white px-6 py-3 rounded-lg font-semibold shadow-lg w-full hover:shadow-xl transition transform hover:scale-105 flex items-center justify-center space-x-2">
                        <lord-icon
                            src="https://cdn.lordicon.com/rqqkvjqf.json"
                            trigger="loop"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:24px;height:24px">
                        </lord-icon>
                        <span>Ubah Password</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
