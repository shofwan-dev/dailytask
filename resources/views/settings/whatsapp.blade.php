@extends('layouts.app')

@section('title', 'Pengaturan WhatsApp')

@section('content')
<div class="min-h-screen px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8 animate-fade-in">
            <div>
                <div class="flex items-center space-x-2 mb-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/vmxvhdko.json"
                        trigger="loop"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:32px;height:32px">
                    </lord-icon>
                    <h1 class="text-3xl md:text-4xl font-bold text-white">WhatsApp Gateway</h1>
                </div>
                <p class="text-purple-200">Konfigurasi notifikasi WhatsApp untuk reminder task</p>
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

        <!-- WhatsApp Settings Form -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-6 animate-fade-in" style="animation-delay: 0.1s;">
            <div class="flex items-center space-x-2 mb-6">
                <lord-icon
                    src="https://cdn.lordicon.com/hwuyodym.json"
                    trigger="loop"
                    colors="primary:#1f2937,secondary:#1f2937"
                    style="width:28px;height:28px">
                </lord-icon>
                <h2 class="text-2xl font-bold text-gray-800">Konfigurasi Gateway</h2>
            </div>
            
            <form method="POST" action="{{ route('settings.whatsapp.update') }}">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <!-- API Key -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">API Key</label>
                        <input type="text" name="wa_api_key" value="{{ old('wa_api_key', $waApiKey) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('wa_api_key') border-red-500 @enderror"
                               placeholder="Masukkan API Key dari WhatsApp Gateway"
                               required>
                        <p class="text-sm text-gray-500 mt-1">Dapatkan API Key dari dashboard WhatsApp Gateway Anda</p>
                        @error('wa_api_key')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sender -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Pengirim (Sender)</label>
                        <input type="text" name="wa_sender" value="{{ old('wa_sender', $waSender) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('wa_sender') border-red-500 @enderror"
                               placeholder="628123456789"
                               required>
                        <p class="text-sm text-gray-500 mt-1">Nomor WhatsApp yang terhubung dengan gateway (format: 628xxx)</p>
                        @error('wa_sender')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Base URL -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Base URL Gateway</label>
                        <input type="url" name="wa_base_url" value="{{ old('wa_base_url', $waBaseUrl) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('wa_base_url') border-red-500 @enderror"
                               placeholder="https://mpwa.mutekar.com"
                               required>
                        <p class="text-sm text-gray-500 mt-1">URL endpoint WhatsApp Gateway API</p>
                        @error('wa_base_url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Recipient -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Penerima Notifikasi</label>
                        <input type="text" name="wa_recipient" value="{{ old('wa_recipient', $waRecipient) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('wa_recipient') border-red-500 @enderror"
                               placeholder="628123456789 atau ID Group"
                               required>
                        <p class="text-sm text-gray-500 mt-1">Masukkan nomor WhatsApp (628xxx) atau ID Group (@g.us)</p>
                        @error('wa_recipient')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full btn-primary text-white px-6 py-3 rounded-lg font-semibold shadow-lg flex items-center justify-center space-x-2">
                        <lord-icon
                            src="https://cdn.lordicon.com/sbiheqdr.json"
                            trigger="loop"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:24px;height:24px">
                        </lord-icon>
                        <span>Simpan Konfigurasi</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Test Connection -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-6 animate-fade-in" style="animation-delay: 0.15s;">
            <div class="flex items-center space-x-2 mb-4">
                <lord-icon
                    src="https://cdn.lordicon.com/yqzmiobz.json"
                    trigger="loop"
                    colors="primary:#1f2937,secondary:#ec4899"
                    style="width:28px;height:28px">
                </lord-icon>
                <h2 class="text-2xl font-bold text-gray-800">Test Koneksi</h2>
            </div>
            <p class="text-gray-600 mb-4">Kirim pesan test untuk memastikan konfigurasi WhatsApp Gateway sudah benar</p>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Penerima Test (Opsional)</label>
                    <input type="text" id="testNumber" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                           placeholder="{{ $waRecipient ?: '628123456789' }}"
                           value="{{ $waRecipient }}">
                    <p class="text-sm text-gray-500 mt-1">Kosongkan untuk menggunakan nomor penerima default</p>
                </div>
                
                <button type="button" onclick="testWhatsApp()" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition flex items-center justify-center space-x-2">
                    <lord-icon
                        src="https://cdn.lordicon.com/lbqloinw.json"
                        trigger="loop"
                        colors="primary:#ffff,secondary:#ffff"
                        style="width:24px;height:24px">
                    </lord-icon>
                    <span>Kirim Pesan Test</span>
                </button>
            </div>
        </div>

        <!-- Info Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 animate-fade-in" style="animation-delay: 0.2s;">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 mt-1">
                    <lord-icon
                        src="https://cdn.lordicon.com/vacmyjrh.json"
                        trigger="hover"
                        colors="primary:#2563eb,secondary:#bfdbfe"
                        style="width:24px;height:24px">
                    </lord-icon>
                </div>
                <div>
                    <h3 class="font-semibold text-blue-900 mb-2 flex items-center space-x-2">
                        <span>Informasi Penting</span>
                    </h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Pastikan nomor WhatsApp Anda sudah terhubung dengan gateway</li>
                        <li>• API Key dapat diperoleh dari dashboard WhatsApp Gateway</li>
                        <li>• Gunakan tombol "Test Koneksi" untuk memastikan konfigurasi sudah benar</li>
                        <li>• Notifikasi akan dikirim ke nomor telepon yang terdaftar di profil Anda</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Test Result -->
        <div id="testResult" class="mt-6 hidden">
            <div class="rounded-xl p-6 shadow-lg">
                <div class="flex items-center space-x-3">
                    <div id="testIconWrapper">
                        <!-- Icon will be injected here -->
                    </div>
                    <p id="testMessage" class="font-semibold"></p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function testWhatsApp() {
    const resultDiv = document.getElementById('testResult');
    const iconWrapper = document.getElementById('testIconWrapper');
    const message = document.getElementById('testMessage');
    
    const testNumber = document.getElementById('testNumber').value;
    
    // Show loading
    resultDiv.className = 'mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6';
    resultDiv.classList.remove('hidden');
    iconWrapper.innerHTML = '<lord-icon src="https://cdn.lordicon.com/xjovhxra.json" trigger="loop" colors="primary:#2563eb,secondary:#bfdbfe" style="width:24px;height:24px"></lord-icon>';
    message.textContent = 'Mengirim pesan test...';
    message.className = 'font-semibold text-blue-900';
    
    fetch("{{ route('settings.whatsapp.test') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            test_number: testNumber
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.className = 'mt-6 bg-green-50 border border-green-200 rounded-xl p-6';
            iconWrapper.innerHTML = '<lord-icon src="https://cdn.lordicon.com/egiwmiit.json" trigger="in" colors="primary:#16a34a,secondary:#bbf7d0" style="width:24px;height:24px"></lord-icon>';
            message.textContent = '✅ ' + data.message;
            message.className = 'font-semibold text-green-900';
        } else {
            resultDiv.className = 'mt-6 bg-red-50 border border-red-200 rounded-xl p-6';
            iconWrapper.innerHTML = '<lord-icon src="https://cdn.lordicon.com/bazyvshu.json" trigger="in" colors="primary:#dc2626,secondary:#fecaca" style="width:24px;height:24px"></lord-icon>';
            message.textContent = '❌ ' + data.message;
            message.className = 'font-semibold text-red-900';
        }
        
        // Hide after 5 seconds
        setTimeout(() => {
            resultDiv.classList.add('hidden');
        }, 5000);
    })
    .catch(error => {
        resultDiv.className = 'mt-6 bg-red-50 border border-red-200 rounded-xl p-6';
        iconWrapper.innerHTML = '<lord-icon src="https://cdn.lordicon.com/bazyvshu.json" trigger="in" colors="primary:#dc2626,secondary:#fecaca" style="width:24px;height:24px"></lord-icon>';
        message.textContent = '❌ Error: ' + error.message;
        message.className = 'font-semibold text-red-900';
    });
}
</script>
@endpush
@endsection
