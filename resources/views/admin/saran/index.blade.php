@extends('layouts.admin')

@section('title', 'Kelola Saran - SahabatBuku')

@section('content')
        <h1 class="mb-6 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta lg:mb-10 text-slate-800">
            Kelola Saran
        </h1>
        
        <!-- flash message -->
        @if(session('success'))
        <div class="px-4 py-3 mb-6 text-green-800 bg-green-100 rounded-xl font-jakarta">
            {{ session('success') }}
        </div>
        @endif

        <!-- Header Card -->
        <div class="flex flex-col items-start justify-between gap-4 p-4 mb-6 bg-white shadow-md rounded-xl lg:flex-row lg:items-center">
            <div class="text-2xl font-semibold lg:text-xl font-jakarta text-slate-700">
                Total Saran Belum Dibaca: <span class="ml-2 font-bold text-slate-800">{{ $sarans->total() }}</span>
            </div>
        </div>

        <!-- Header Tabel Desktop -->
        <div class="hidden p-4 mb-4 bg-white shadow-md lg:block rounded-2xl">
            <div class="grid grid-cols-8 gap-4 text-lg font-semibold text-center font-jakarta text-slate-600">
                <div>No</div>
                <div class="col-span-3 text-left">Saran</div>
                <div class="col-span-2">Tanggal</div>
                <div>Status</div>
                <div>Aksi</div>
            </div>
        </div>

        <!-- List Saran -->
        @forelse($sarans as $index => $saran)
        <div class="p-4 mb-4 bg-white shadow-md rounded-xl sm:p-6 lg:p-4 lg:mb-2 transition-transform hover:translate-y-[-2px] duration-200">
            
            <!-- Mobile View -->
            <div class="space-y-3 lg:hidden">
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-500">No:</span>
                    <span class="font-semibold text-slate-800">{{ $sarans->firstItem() + $index }}</span>
                </div>
                <div class="flex flex-col gap-1.5">
                    <span class="font-medium text-gray-500">Saran:</span>
                    <p class="font-medium text-slate-700 bg-slate-50 p-3 rounded-lg border border-slate-100 text-sm leading-relaxed whitespace-pre-line">
                        {{ $saran->isi }}
                    </p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-500">Tanggal:</span>
                    <span class="text-xs text-slate-400 font-semibold">{{ $saran->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-500">Status:</span>
                    <span class="px-3 py-1 text-white rounded-full text-xs font-bold {{ $saran->status === 'belum_dibaca' ? 'bg-orange-500' : 'bg-green-500' }}">
                        {{ $saran->status === 'belum_dibaca' ? 'Belum Dibaca' : 'Sudah Dibaca' }}
                    </span>
                </div>
                <div class="flex items-center justify-end gap-3 mt-4 pt-3 border-t border-slate-100">
                    @if($saran->status === 'belum_dibaca')
                    <form action="{{ route('admin.saran.read', $saran->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-4 py-2 text-xs font-bold text-white transition bg-blue-500 rounded-xl hover:bg-opacity-90 flex items-center gap-1">
                            Tandai Dibaca
                        </button>
                    </form>
                    @endif
                    <form action="{{ route('admin.saran.destroy', $saran->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus saran ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-xs font-bold text-white transition bg-red-500 rounded-xl hover:bg-opacity-90 flex items-center gap-1">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            <!-- Desktop View -->
            <div class="items-center hidden grid-cols-8 gap-4 text-base text-center lg:grid font-jakarta">
                
                <!-- NO -->
                <div class="font-semibold text-slate-800">{{ $sarans->firstItem() + $index }}</div>
                
                <!-- SARAN -->
                <div class="col-span-3 pl-4 text-left font-medium text-slate-700 text-sm leading-relaxed break-words whitespace-pre-line pr-4">
                    {{ $saran->isi }}
                </div>
                
                <!-- TANGGAL -->
                <div class="col-span-2 font-medium text-slate-500 text-sm">
                    {{ $saran->created_at->format('d M Y H:i') }}
                </div>
                
                <!-- STATUS -->
                <div>
                    <span class="px-3 py-1 text-white rounded-full text-xs font-bold {{ $saran->status === 'belum_dibaca' ? 'bg-[#F4922A]' : 'bg-green-500' }}">
                        {{ $saran->status === 'belum_dibaca' ? 'Belum Dibaca' : 'Sudah Dibaca' }}
                    </span>
                </div>
                
                <!-- ACTION -->
                <div class="flex justify-center gap-4 items-center">
                    @if($saran->status === 'belum_dibaca')
                    <form action="{{ route('admin.saran.read', $saran->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="transition-opacity hover:opacity-80" title="Tandai Dibaca">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-admin-blue fill-admin-blue">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </button>
                    </form>
                    @endif
                    
                    <form action="{{ route('admin.saran.destroy', $saran->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus saran ini?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="transition-opacity hover:opacity-80" title="Hapus Saran">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-admin-red fill-admin-red">
                                <path d="M3 6h18"/>
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="p-8 text-center bg-white shadow-md rounded-2xl">
            <p class="text-xl text-gray-500 font-jakarta">Belum ada saran terdaftar</p>
        </div>
        @endforelse

        <!-- Pagination -->
        @if($sarans->hasPages())
        <div class="mt-8 font-jakarta">
            {{ $sarans->links() }}
        </div>
        @endif
@endsection
