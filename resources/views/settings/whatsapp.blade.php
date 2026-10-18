@extends('layouts.app')

@section('title', 'Pengaturan WhatsApp')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header & Back --}}
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 animate-fade-in">
        <div>
            <a href="{{ route('settings.index') }}" class="inline-flex items-center gap-2 text-slate-300 hover:text-white text-sm font-medium transition mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Pengaturan
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl md:text-3xl font-bold text-white leading-tight">WhatsApp Gateway</h1>
            </div>
            <p class="text-slate-300 text-sm mt-2">Konfigurasi notifikasi WhatsApp untuk reminder task</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2 animate-fade-in font-medium">
        <lord-icon src="https://cdn.lordicon.com/egiwmiit.json" trigger="loop" colors="primary:#34d399,secondary:#34d399" style="width:20px;height:20px"></lord-icon>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        {{-- Left Col: Form --}}
        <div class="lg:col-span-3 space-y-6">
            {{-- Main Form --}}
            <div class="glass-card p-6 md:p-8 animate-fade-in" style="animation-delay: 0.1s;">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/15 flex items-center justify-center">
                        <lord-icon src="https://cdn.lordicon.com/hwuyodym.json" trigger="hover" colors="primary:#34d399,secondary:#6ee7b7" style="width:24px;height:24px"></lord-icon>
                    </div>
                    <h2 class="text-xl font-bold text-white">Konfigurasi Gateway</h2>
                </div>
                
                <form method="POST" action="{{ route('settings.whatsapp.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')
                    
                    {{-- API Key --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">API Key</label>
                        <div class="relative">
                            <input type="password" id="wa_api_key_input" name="wa_api_key" value="{{ old('wa_api_key', $waApiKey) }}" required
                                   class="w-full px-4 py-3 pr-11 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition outline-none text-sm font-mono"
                                   placeholder="Contoh: v#_9s8df7234...">
                            <button type="button" onclick="const el = document.getElementById('wa_api_key_input'); el.type = el.type === 'password' ? 'text' : 'password';" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 hover:text-white transition p-1" title="Lihat/Sembunyikan API Key">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        @error('wa_api_key')
                        <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sender --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">Nomor Pengirim (Sender)</label>
                        <input type="text" name="wa_sender" value="{{ old('wa_sender', $waSender) }}" required
                               class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition outline-none text-sm"
                               placeholder="628123456789">
                        @error('wa_sender')
                        <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Base URL --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">Base URL Gateway</label>
                        <input type="url" name="wa_base_url" value="{{ old('wa_base_url', $waBaseUrl) }}" required
                               class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition outline-none text-sm font-mono"
                               placeholder="https://api.fonnte.com">
                        @error('wa_base_url')
                        <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Recipient --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">Nomor Penerima Default</label>
                        <input type="text" name="wa_recipient" value="{{ old('wa_recipient', $waRecipient) }}" required
                               class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition outline-none text-sm"
                               placeholder="628123456789">
                        <p class="text-slate-300 text-xs mt-1.5 font-medium">Nomor (628xxx) atau ID Group (@g.us)</p>
                        @error('wa_recipient')
                        <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2 border-t border-white/10">
                        <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-400 text-white font-semibold py-3 rounded-xl text-sm flex items-center justify-center gap-2 transition shadow-lg">
                            <lord-icon src="https://cdn.lordicon.com/sbiheqdr.json" trigger="loop" delay="3000" colors="primary:#ffffff,secondary:#ffffff" style="width:20px;height:20px"></lord-icon>
                            Simpan Konfigurasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right Col: Test & Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Info Card --}}
            <div class="bg-blue-500/10 border border-blue-500/20 rounded-2xl p-5 animate-fade-in" style="animation-delay: 0.15s;">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                        <lord-icon src="https://cdn.lordicon.com/vacmyjrh.json" trigger="loop" delay="4000" colors="primary:#60a5fa,secondary:#93c5fd" style="width:20px;height:20px"></lord-icon>
                    </div>
                    <div>
                        <h3 class="font-bold text-blue-300 mb-2">Informasi Penting</h3>
                        <ul class="text-xs text-blue-200/90 space-y-2 font-medium">
                            <li class="flex gap-2">
                                <span class="text-blue-400">•</span>
                                Pastikan nomor sender aktif dan terhubung ke Fonnte/Gateway Anda.
                            </li>
                            <li class="flex gap-2">
                                <span class="text-blue-400">•</span>
                                Nomor telepon diinput tanpa tanda (+) dan diawali 62.
                            </li>
                            <li class="flex gap-2">
                                <span class="text-blue-400">•</span>
                                Test koneksi di bawah ini untuk memastikan API merespons.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Test Connection --}}
            <div class="glass-card p-6 animate-fade-in" style="animation-delay: 0.2s;">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-pink-500/15 flex items-center justify-center">
                        <lord-icon src="https://cdn.lordicon.com/yqzmiobz.json" trigger="hover" colors="primary:#ec4899,secondary:#f472b6" style="width:24px;height:24px"></lord-icon>
                    </div>
                    <h2 class="text-lg font-bold text-white">Test Koneksi</h2>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-200 mb-2">Kirim ke Nomor</label>
                        <input type="text" id="testNumber" 
                               class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder:text-slate-400 focus:ring-2 focus:ring-pink-500/50 focus:border-pink-500/50 transition outline-none text-sm"
                               placeholder="{{ $waRecipient ?: '628123456789' }}"
                               value="{{ $waRecipient }}">
                    </div>
                    
                    <button type="button" onclick="testWhatsApp()" class="w-full bg-white/10 hover:bg-white/20 text-white font-semibold py-2.5 rounded-xl text-sm flex items-center justify-center gap-2 transition border border-white/10">
                        <lord-icon src="https://cdn.lordicon.com/lbqloinw.json" trigger="loop" delay="2000" colors="primary:#ffffff,secondary:#ffffff" style="width:18px;height:18px"></lord-icon>
                        Kirim Pesan Test
                    </button>
                </div>

                {{-- Test Result --}}
                <div id="testResult" class="mt-4 hidden p-4 rounded-xl border text-sm flex items-start gap-3">
                    <div id="testIconWrapper" class="flex-shrink-0 mt-0.5"></div>
                    <p id="testMessage" class="leading-relaxed"></p>
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
    
    // UI Loading state
    resultDiv.className = 'mt-4 p-4 rounded-xl border text-sm flex items-start gap-3 bg-blue-500/10 border-blue-500/20 text-blue-400';
    resultDiv.classList.remove('hidden');
    iconWrapper.innerHTML = '<lord-icon src="https://cdn.lordicon.com/xjovhxra.json" trigger="loop" colors="primary:#60a5fa,secondary:#93c5fd" style="width:20px;height:20px"></lord-icon>';
    message.textContent = 'Mengirim pesan test ke Gateway...';
    
    fetch("{{ route('settings.whatsapp.test') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ test_number: testNumber })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.className = 'mt-4 p-4 rounded-xl border text-sm flex items-start gap-3 bg-emerald-500/10 border-emerald-500/20 text-emerald-400';
            iconWrapper.innerHTML = '<lord-icon src="https://cdn.lordicon.com/egiwmiit.json" trigger="in" colors="primary:#34d399,secondary:#6ee7b7" style="width:20px;height:20px"></lord-icon>';
            message.textContent = data.message;
        } else {
            resultDiv.className = 'mt-4 p-4 rounded-xl border text-sm flex items-start gap-3 bg-red-500/10 border-red-500/20 text-red-400';
            iconWrapper.innerHTML = '<lord-icon src="https://cdn.lordicon.com/bazyvshu.json" trigger="in" colors="primary:#f87171,secondary:#fca5a5" style="width:20px;height:20px"></lord-icon>';
            message.textContent = 'Gagal: ' + data.message;
        }
        
        setTimeout(() => {
            resultDiv.classList.add('hidden');
        }, 8000);
    })
    .catch(error => {
        resultDiv.className = 'mt-4 p-4 rounded-xl border text-sm flex items-start gap-3 bg-red-500/10 border-red-500/20 text-red-400';
        iconWrapper.innerHTML = '<lord-icon src="https://cdn.lordicon.com/bazyvshu.json" trigger="in" colors="primary:#f87171,secondary:#fca5a5" style="width:20px;height:20px"></lord-icon>';
        message.textContent = 'Error koneksi: ' + error.message;
    });
}
</script>
@endpush
@endsection
