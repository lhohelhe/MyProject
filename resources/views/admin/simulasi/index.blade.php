@extends('layouts.admin')

@section('title', 'Simulasi Ujian - SahabatBuku')

@section('content')
        <h1 class="mb-6 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta lg:mb-10">
            Simulasi Ujian
        </h1>
        
        <!-- Header -->
        <div class="flex flex-col items-start justify-between gap-4 p-2 mb-6 bg-white shadow-md rounded-xl lg:p-2 lg:flex-row lg:items-center">
            <div class="text-2xl font-semibold lg:text-xl font-jakarta">
                Total Simulasi: <span class="ml-2">{{ $simulasi->total() }}</span>
            </div>
            <a href="{{ route('simulasi.create') }}" 
               class="flex items-center gap-3 px-4 py-3 text-xl font-bold text-black bg-admin-orange rounded-xl hover:bg-opacity-90 lg:text-xl font-jakarta">
                <span>Tambah Simulasi</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 lg:w-8 lg:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14"/>
                </svg>
            </a>
        </div>

        <!-- Header Tabel Desktop -->
        <div class="hidden p-4 mb-4 bg-white shadow-md lg:block rounded-2xl">
            <div class="grid grid-cols-8 gap-4 text-lg font-semibold text-center font-jakarta">
                <div>No</div>
                <div class="text-left">Judul Simulasi</div>
                <div>Buku</div>
                <div>Durasi (menit)</div>
                <div>Jumlah Soal</div>
                <div>Status</div>
                <div class="col-span-2">Aksi</div>
            </div>
        </div>

        <!-- List Simulasi -->
        @forelse($simulasi as $index => $sim)
        <div class="p-4 mb-4 bg-white shadow-md rounded-xl sm:p-6 lg:p-4 lg:mb-2">
            
            <!-- Mobile View -->
            <div class="space-y-3 lg:hidden">
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">No:</span>
                    <span class="font-medium">{{ $simulasi->firstItem() + $loop->index }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">Judul:</span>
                    <span class="font-medium">{{ $sim->judul_simulasi }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">Buku:</span>
                    <span>{{ $sim->buku->judul_buku ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">Durasi:</span>
                    <span>{{ $sim->durasi }} menit</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">Jumlah Soal:</span>
                    <span>{{ $sim->jumlah_soal }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">Status:</span>
                    <span class="px-3 py-1 text-white rounded-full text-sm font-semibold {{ $sim->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ $sim->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div class="flex items-center justify-end gap-3 mt-4">
                    <a href="/admin/simulasi/{{ $sim->id_simulasi }}/soal" class="px-4 py-2 text-sm font-semibold text-white transition bg-blue-500 rounded-xl hover:bg-opacity-90">
                        Kelola Soal
                    </a>
                    <a href="{{route('simulasi.edit', $sim->id_simulasi) }}" class="transition-opacity hover:opacity-80">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="text-admin-green fill-admin-green">
                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                            <path d="m15 5 4 4"/>
                        </svg>
                    </a>
                    <form action="{{ route('simulasi.destroy', $sim->id_simulasi) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus simulasi ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="transition-opacity hover:opacity-80">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="text-admin-red fill-admin-red">
                                <path d="M3 6h18"/>
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Desktop View -->
            <div class="items-center hidden grid-cols-8 gap-4 text-lg text-center lg:grid font-jakarta">
                
                <!-- NO -->
                <div class="font-medium">{{ $simulasi->firstItem() + $loop->index }}</div>
                
                <!-- JUDUL SIMULASI -->
                <div class="pl-4 font-medium text-left">{{ $sim->judul_simulasi }}</div>
                
                <!-- BUKU -->
                <div class="font-medium">{{ $sim->buku->judul_buku ?? '-' }}</div>
                
                <!-- DURASI -->
                <div class="font-medium">{{ $sim->durasi }}</div>
                
                <!-- JUMLAH SOAL -->
                <div class="font-medium">{{ $sim->jumlah_soal }}</div>
                
                <!-- STATUS -->
                <div>
                    <span class="px-3 py-1 text-white rounded-full text-sm font-semibold {{ $sim->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ $sim->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                
                <!-- Action -->
                <div class="flex justify-center gap-4 items-center col-span-2">
                    <a href="{{ route('simulasi.edit', $sim->id_simulasi) }}" class="transition-opacity hover:opacity-80">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="text-admin-green fill-admin-green">
                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                            <path d="m15 5 4 4"/>
                        </svg>
                    </a>
                    <a href="/admin/simulasi/{{ $sim->id_simulasi }}/soal" class="transition-opacity hover:opacity-80" title="Kelola Soal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-admin-blue fill-admin-blue">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </a>
                    <form action="{{ route('simulasi.destroy', $sim->id_simulasi) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus simulasi ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="transition-opacity hover:opacity-80">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="text-admin-red fill-admin-red">
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
        <div class="p-6 text-center bg-white shadow-md rounded-xl">
            <p class="text-lg text-gray-500">Belum ada data simulasi</p>
        </div>
        @endforelse

        <!-- Pagination -->
        @if($simulasi->hasPages())
        <div class="mt-8">
            {{ $simulasi->links() }}
        </div>
        @endif
@endsection
