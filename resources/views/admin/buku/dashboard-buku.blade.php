<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#F5F5F5]">
<div class="flex flex-col min-h-screen lg:flex-row">
    <x-admin-sidebar />
    <main class="flex-1 p-4 sm:p-6 lg:p-16">
        <h1 class="mb-6 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta lg:mb-10">
            Data Buku
        </h1>
        
        <!-- Header -->
        <div class="flex flex-col items-start justify-between gap-4 p-2 mb-6 bg-white shadow-md rounded-xl lg:p-2 lg:flex-row lg:items-center">
            <div class="text-2xl font-semibold lg:text-xl font-jakarta">
                Total Buku: <span class="ml-2">{{ $buku->count() }}</span>
            </div>
            <a href="{{ route('dashboard-buku.create') }}" 
               class="flex items-center gap-3 px-4 py-3 text-xl font-bold text-black bg-admin-orange rounded-xl hover:bg-opacity-90 lg:text-xl font-jakarta">
                <span>Tambah Buku</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 lg:w-8 lg:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14"/>
                </svg>
            </a>
        </div>

        <!-- Header Tabel Desktop -->
        <div class="hidden p-4 mb-4 bg-white shadow-md lg:block rounded-2xl">
            <div class="grid grid-cols-6 gap-4 text-xl font-semibold text-center font-jakarta">
                <div>Gambar</div>
                <div class="pl-2 text-left">Judul Buku</div>
                <div>Kategori</div>
                <div>Kelas</div>
                <div>Semester</div>
                <div></div>
            </div>
        </div>

        <!-- List Buku -->
        @forelse($buku as $b)
        <div class="p-4 mb-4 bg-white shadow-md rounded-xl sm:p-6 lg:p-4 lg:mb-2">
            
            <!-- Mobile View -->
            <div class="space-y-3 lg:hidden">
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">Judul:</span>
                    <span class="font-medium">{{ $b->judul_buku }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">Kategori:</span>
                    <span>{{ $b->kategori->nama_kategori ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">Kelas:</span>
                    <span>{{ $b->kelas }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">Semester:</span>
                    <span>{{ $b->semester }}</span>
                </div>
            </div>

            <!-- Desktop View -->
            <div class="items-center hidden grid-cols-6 gap-4 text-center text-l lg:grid font-jakarta">
                
                <!-- GAMBAR COVER -->
                <div class="flex justify-center">
                    @if($b->gambar)
                        <img src="{{ Storage::url($b->gambar) }}" 
                             alt="{{ $b->judul_buku }}" 
                             class="object-cover w-24 h-32 border border-gray-200 shadow-sm rounded-2xl"
                             style="aspect-ratio: 717 / 1027;">
                    @else
                        <div class="flex items-center justify-center w-24 h-32 text-4xl text-gray-300 bg-gray-100 border border-gray-200 rounded-2xl">
                            !
                        </div>
                    @endif
                </div>
                
                <!-- JUDUL BUKU -->
                <div class="pl-6 font-medium text-left">{{ $b->judul_buku }}</div>
                <div class="font-medium">{{ $b->kategori->nama_kategori ?? '-' }}</div>
                <div class="font-medium">{{ $b->kelas }}</div>
                <div class="font-medium">{{ $b->semester }}</div>
                
                <!-- Action -->
                <div class="flex justify-center gap-6">
                    <a href="{{ route('dashboard-buku.edit', $b->id_buku) }}" class="transition-opacity hover:opacity-80">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-admin-green">
                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                            <path d="m15 5 4 4"/>
                        </svg>
                    </a>
                    <form action="{{ route('dashboard-buku.destroy', $b->id_buku) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="transition-opacity hover:opacity-80">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-admin-red">
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
            <p class="text-2xl text-gray-500 font-jakarta">Belum ada data buku terdaftar</p>
        </div>
        @endforelse
    </main>
</div>
</body>
</html>