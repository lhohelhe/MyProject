@extends('layouts.admin')

@section('title', 'Simulasi Ujian - SahabatBuku')

@section('content')
        <h1 class="mb-6 text-3xl font-black text-black uppercase tracking-wider sm:text-3xl lg:text-4xl font-jakarta lg:mb-10">
            Simulasi Ujian
        </h1>
        
        <!-- Header -->
        <div class="flex flex-col items-start justify-between gap-4 p-2 mb-6 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl lg:p-2 lg:flex-row lg:items-center">
            <div class="text-2xl font-black text-black lg:text-xl font-jakarta">
                Total Simulasi: <span class="ml-2">{{ $simulasi->total() }}</span>
            </div>
            <a href="{{ route('simulasi.create') }}" 
               class="flex items-center gap-3 px-4 py-3 text-xl font-bold text-white bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all lg:text-xl font-jakarta">
                <span>Tambah Simulasi</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 lg:w-8 lg:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14"/>
                </svg>
            </a>
        </div>

        <!-- Header Tabel Desktop -->
        <div class="hidden p-4 mb-4 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl lg:block">
            <div class="grid grid-cols-8 gap-4 text-lg font-bold text-center text-black font-jakarta">
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
        <div class="p-4 mb-4 bg-white border-2 border-black rounded-xl sm:p-6 lg:p-4 lg:mb-2">
            
            <!-- Mobile View -->
            <div class="space-y-3 lg:hidden">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-black">No:</span>
                    <span class="font-bold text-black">{{ $simulasi->firstItem() + $loop->index }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-bold text-black">Judul:</span>
                    <span class="font-bold text-black">{{ $sim->judul_simulasi }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-bold text-black">Buku:</span>
                    <span class="font-bold text-black">{{ $sim->buku->judul_buku ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-bold text-black">Durasi:</span>
                    <span class="font-bold text-black">{{ $sim->durasi_menit }} menit</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-bold text-black">Jumlah Soal:</span>
                    <span class="font-bold text-black">{{ $sim->jumlah_soal }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-bold text-black">Status:</span>
                    <span class="px-3 py-1 text-white rounded-full text-sm font-bold {{ $sim->status === 'aktif' ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ $sim->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div class="flex items-center justify-end gap-3 mt-4">
                    <a href="/admin/simulasi/{{ $sim->id_simulasi }}/soal" class="px-4 py-2 text-sm font-bold text-white bg-blue-500 border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
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
                <div class="font-bold text-black">{{ $simulasi->firstItem() + $loop->index }}</div>
                
                <!-- JUDUL SIMULASI -->
                <div class="pl-4 font-bold text-black text-left">{{ $sim->judul_simulasi }}</div>
                
                <!-- BUKU -->
                <div class="font-bold text-black">{{ $sim->buku->judul_buku ?? '-' }}</div>
                
                <!-- DURASI -->
                <div class="font-black text-black">{{ $sim->durasi_menit }}</div>
                
                <!-- JUMLAH SOAL -->
                <div class="font-black text-black">{{ $sim->jumlah_soal }}</div>
                
                <!-- STATUS -->
                <div>
                    <span class="px-3 py-1 text-white rounded-full text-sm font-bold {{ $sim->status === 'aktif' ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ $sim->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                
                <!-- Action -->
                <div class="flex justify-center gap-2 items-center col-span-2">
                    <a href="{{ route('simulasi.edit', $sim->id_simulasi) }}"
                       class="px-3 py-1.5 text-xs font-black text-black bg-white border-2 border-black shadow-[2px_2px_0px_#000] rounded-lg hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Edit
                    </a>
                    <a href="{{ route('soal-simulasi.index', $sim->id_simulasi) }}"
                       class="px-3 py-1.5 text-xs font-black text-white bg-[#1E3A5F] border-2 border-black shadow-[2px_2px_0px_#000] rounded-lg hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Soal
                    </a>
                    <form action="{{ route('simulasi.destroy', $sim->id_simulasi) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus simulasi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1.5 text-xs font-black text-white bg-red-500 border-2 border-black shadow-[2px_2px_0px_#000] rounded-lg hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="p-6 text-center bg-white border-2 border-black rounded-xl">
            <p class="text-lg font-bold text-black">Belum ada data simulasi</p>
        </div>
        @endforelse

        <!-- Pagination -->
        @if($simulasi->hasPages())
        <div class="mt-8">
            {{ $simulasi->links() }}
        </div>
        @endif
@endsection

