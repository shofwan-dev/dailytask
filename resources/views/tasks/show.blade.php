@extends('layouts.app')

@section('title', 'Detail Task')

@section('content')
<div class="min-h-screen px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6 animate-fade-in">
            <a href="{{ route('tasks.index') }}" class="inline-flex items-center space-x-2 text-white hover:text-purple-200 transition">
                <lord-icon
                    src="https://cdn.lordicon.com/jxwksgwv.json"
                    trigger="hover"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:20px;height:20px">
                </lord-icon>
                <span>Kembali ke List</span>
            </a>
        </div>

        <!-- Task Detail Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden animate-fade-in" style="animation-delay: 0.1s;">
            <!-- Header Status -->
            <div class="p-6 {{ $task->status === 'done' ? 'bg-green-50' : ($task->isOverdue() ? 'bg-red-50' : 'bg-purple-50') }} border-b border-gray-100">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="flex items-center space-x-3 mb-2">
                             @if($task->status === 'done')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold flex items-center">
                                <lord-icon src="https://cdn.lordicon.com/egiwmiit.json" trigger="loop" colors="primary:#15803d,secondary:#15803d" style="width:16px;height:16px;margin-right:4px"></lord-icon>
                                Selesai
                            </span>
                            @elseif($task->isOverdue())
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold flex items-center">
                                <lord-icon src="https://cdn.lordicon.com/wdnwtnyn.json" trigger="loop" colors="primary:#b91c1c,secondary:#b91c1c" style="width:16px;height:16px;margin-right:4px"></lord-icon>
                                Terlambat
                            </span>
                            @else
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold flex items-center">
                                <lord-icon src="https://cdn.lordicon.com/kbtmbyzy.json" trigger="loop" colors="primary:#b45309,secondary:#b45309" style="width:16px;height:16px;margin-right:4px"></lord-icon>
                                Pending
                            </span>
                            @endif
                            
                            @if($task->project)
                            <a href="{{ route('projects.show', $task->project) }}" class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold flex items-center hover:bg-purple-200 transition">
                                <lord-icon src="https://cdn.lordicon.com/fhtaantg.json" trigger="hover" colors="primary:#7e22ce,secondary:#7e22ce" style="width:16px;height:16px;margin-right:4px"></lord-icon>
                                {{ $task->project->name }}
                            </a>
                            @endif
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 break-words">{{ $task->title }}</h1>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6 md:p-8 space-y-6">
                <!-- Date & Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start space-x-4">
                        <div class="bg-blue-50 p-3 rounded-xl flex-shrink-0">
                            <lord-icon
                                src="https://cdn.lordicon.com/kbtmbyzy.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#2563eb,secondary:#60a5fa"
                                style="width:32px;height:32px">
                            </lord-icon>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Tenggat Waktu</p>
                            <p class="text-lg font-bold text-gray-800">{{ $task->due_date->format('l, d F Y') }}</p>
                            <p class="text-blue-600 font-semibold">{{ $task->due_time }} WIB</p>
                        </div>
                    </div>
                    
                     <div class="flex items-start space-x-4">
                        <div class="bg-indigo-50 p-3 rounded-xl flex-shrink-0">
                             <lord-icon
                                src="https://cdn.lordicon.com/qjuahhae.json" 
                                trigger="loop"
                                delay="3000"
                                colors="primary:#4f46e5,secondary:#818cf8"
                                style="width:32px;height:32px">
                            </lord-icon>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Pengulangan</p>
                            @if($task->recurrence_type !== 'none')
                            <p class="text-lg font-bold text-gray-800 capitalize">{{ $task->recurrence_type }}</p>
                            <p class="text-indigo-600 font-semibold">
                                @if($task->recurrence_end_date)
                                Sampai {{ $task->recurrence_end_date->format('d M Y') }}
                                @else
                                Selamanya
                                @endif
                            </p>
                            @else
                            <p class="text-lg font-bold text-gray-400">Tidak Berulang</p>
                            @endif
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Description -->
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                        <lord-icon src="https://cdn.lordicon.com/wuvorxbv.json" trigger="in" delay="500" colors="primary:#4b5563,secondary:#4b5563" style="width:24px;height:24px;margin-right:8px"></lord-icon>
                        Deskripsi
                    </h3>
                    <div class="bg-gray-50 rounded-xl p-6 text-gray-700 leading-relaxed whitespace-pre-line border border-gray-100">
                        {{ $task->description ?: 'Tidak ada deskripsi untuk task ini.' }}
                    </div>
                </div>
                
                 <!-- WhatsApp Status -->
                @if($task->wa_notified)
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center space-x-3">
                    <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#16a34a,secondary:#16a34a" style="width:24px;height:24px"></lord-icon>
                    <div>
                        <p class="text-green-800 font-semibold">Notifikasi WhatsApp Terkirim</p>
                        <p class="text-green-600 text-sm">Pengingat telah dikirim ke nomor Anda.</p>
                    </div>
                </div>
                @endif

                <!-- Actions Footer -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                    <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full justify-center flex items-center space-x-2 px-6 py-3 rounded-xl font-bold text-white transition transform hover:scale-[1.02] active:scale-95 shadow-lg {{ $task->status === 'done' ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }}">
                             @if($task->status === 'done')
                            <lord-icon src="https://cdn.lordicon.com/kbtmbyzy.json" trigger="loop" colors="primary:#ffffff,secondary:#ffffff" style="width:24px;height:24px"></lord-icon>
                            <span>Tandai Belum Selesai</span>
                            @else
                            <lord-icon src="https://cdn.lordicon.com/egiwmiit.json" trigger="loop" colors="primary:#ffffff,secondary:#ffffff" style="width:24px;height:24px"></lord-icon>
                            <span>Tandai Selesai</span>
                            @endif
                        </button>
                    </form>
                    
                    <a href="{{ route('tasks.edit', $task) }}" class="flex-1 justify-center flex items-center space-x-2 px-6 py-3 rounded-xl font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 transition border border-blue-200">
                         <lord-icon src="https://cdn.lordicon.com/wuvorxbv.json" trigger="hover" colors="primary:#2563eb,secondary:#2563eb" style="width:24px;height:24px"></lord-icon>
                        <span>Edit Task</span>
                    </a>
                    
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus task ini?');" class="sm:flex-none">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full sm:w-auto justify-center flex items-center space-x-2 px-6 py-3 rounded-xl font-bold text-red-600 bg-red-50 hover:bg-red-100 transition border border-red-200">
                             <lord-icon src="https://cdn.lordicon.com/kfzfxczd.json" trigger="hover" colors="primary:#dc2626,secondary:#dc2626" style="width:24px;height:24px"></lord-icon>
                             <span class="sm:hidden">Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
