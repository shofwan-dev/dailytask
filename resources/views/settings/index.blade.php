@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="min-h-screen px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 animate-fade-in">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/hwuyodym.json"
                        trigger="loop"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:32px;height:32px">
                    </lord-icon>
                    <h1 class="text-4xl font-bold text-white">Pengaturan</h1>
                </div>
                <p class="text-purple-200">Kelola akun dan konfigurasi aplikasi</p>
            </div>
            <a href="{{ route('dashboard') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition backdrop-blur-sm border border-white/30 flex items-center space-x-2">
                <lord-icon
                    src="https://cdn.lordicon.com/jxwksgwv.json"
                    trigger="hover"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:20px;height:20px">
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
                    <div class="flex items-center justify-center filter drop-shadow-lg transition transform hover:scale-110">
                        <svg class="w-14 h-14 text-[#25D366]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
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
