@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="min-h-screen px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header - Responsive -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8 animate-fade-in">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/hwuyodym.json"
                        trigger="loop"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:32px;height:32px">
                    </lord-icon>
                    <h1 class="text-3xl md:text-4xl font-bold text-white">Pengaturan</h1>
                </div>
                <p class="text-purple-200 text-sm md:text-base">Kelola akun dan konfigurasi aplikasi</p>
            </div>
            <a href="{{ route('dashboard') }}" class="bg-white/20 hover:bg-white/30 text-white px-3 md:px-4 py-2 rounded-lg transition backdrop-blur-sm border border-white/30 flex items-center space-x-2 text-sm md:text-base w-fit">
                <lord-icon
                    src="https://cdn.lordicon.com/jxwksgwv.json"
                    trigger="hover"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:18px;height:18px">
                </lord-icon>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Settings Menu -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- User Profile -->
            <a href="{{ route('settings.profile') }}" class="bg-white rounded-xl p-8 shadow-lg card-hover animate-fade-in" style="animation-delay: 0.1s;">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-purple-100 p-4 rounded-lg flex items-center justify-center">
                        <lord-icon
                            src="https://cdn.lordicon.com/dxjqoygy.json"
                            trigger="hover"
                            colors="primary:#9333ea,secondary:#e9d5ff"
                            style="width:40px;height:40px">
                        </lord-icon>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Profil Pengguna</h3>
                        <p class="text-gray-600 text-sm">Kelola informasi akun Anda</p>
                    </div>
                </div>
                <div class="border-t pt-4">
                    <p class="text-sm text-gray-500">• Ubah nama dan email</p>
                    <p class="text-sm text-gray-500">• Update nomor telepon</p>
                    <p class="text-sm text-gray-500">• Ganti password</p>
                </div>
            </a>

            <!-- WhatsApp Gateway -->
            <a href="{{ route('settings.whatsapp') }}" class="bg-white rounded-xl p-8 shadow-lg card-hover animate-fade-in" style="animation-delay: 0.2s;">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-green-100 p-4 rounded-lg flex items-center justify-center">
                        <lord-icon
                            src="https://cdn.lordicon.com/vmxvhdko.json"
                            trigger="hover"
                            colors="primary:#25D366,secondary:#128C7E"
                            style="width:40px;height:40px">
                        </lord-icon>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">WhatsApp Gateway</h3>
                        <p class="text-gray-600 text-sm">Konfigurasi notifikasi WhatsApp</p>
                    </div>
                </div>
                <div class="border-t pt-4">
                    <p class="text-sm text-gray-500">• API Key dan Sender</p>
                    <p class="text-sm text-gray-500">• Base URL Gateway</p>
                    <p class="text-sm text-gray-500">• Test koneksi</p>
                </div>
            </a>
        </div>

        <!-- Current User Info -->
        <div class="mt-8 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-6 text-white animate-fade-in" style="animation-delay: 0.3s;">
            <h3 class="text-lg font-semibold mb-3 flex items-center space-x-2">
                <lord-icon
                    src="https://cdn.lordicon.com/dxjqoygy.json"
                    trigger="loop"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:24px;height:24px">
                </lord-icon>
                <span>Informasi Akun</span>
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-purple-200 text-sm">Nama</p>
                    <p class="font-semibold">{{ Auth::user()->name }}</p>
                </div>
                <div>
                    <p class="text-purple-200 text-sm">Email</p>
                    <p class="font-semibold">{{ Auth::user()->email }}</p>
                </div>
                <div>
                    <p class="text-purple-200 text-sm">Nomor Telepon</p>
                    <p class="font-semibold">{{ Auth::user()->phone_number }}</p>
                </div>
                <div>
                    <p class="text-purple-200 text-sm">Terdaftar Sejak</p>
                    <p class="font-semibold">{{ Auth::user()->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
