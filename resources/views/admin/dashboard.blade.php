<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#F5F5F5]">
<div class="flex flex-col min-h-screen lg:flex-row">
    <x-admin-sidebar />
    <main class="flex-1 p-4 sm:p-6 lg:p-16">

        <h1 class="mb-6 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta lg:mb-10">
            dashboard admin
        </h1>

        {{-- flash message --}}
        @if(session('success'))
        <div class="px-4 py-3 mb-6 text-green-800 bg-green-100 rounded-xl font-jakarta">
            {{ session('success') }}
        </div>
        @endif

        {{-- 4 kartu statistik --}}
        <div class="grid grid-cols-2 gap-4 mb-10 lg:grid-cols-4">

            <div class="p-6 bg-white shadow-md rounded-xl">
                <p class="mb-1 text-sm text-gray-500 font-jakarta">total buku</p>
                <p class="text-4xl font-extrabold font-jakarta">{{ $total_buku }}</p>
            </div>

            <div class="p-6 bg-white shadow-md rounded-xl">
                <p class="mb-1 text-sm text-gray-500 font-jakarta">total pengguna</p>
                <p class="text-4xl font-extrabold font-jakarta">{{ $total_user }}</p>
            </div>

            <div class="p-6 bg-white shadow-md rounded-xl">
                <p class="mb-1 text-sm text-gray-500 font-jakarta">total kategori</p>
                <p class="text-4xl font-extrabold font-jakarta">{{ $total_kategori }}</p>
            </div>

            <div class="p-6 bg-white shadow-md rounded-xl">
                <p class="mb-1 text-sm text-gray-500 font-jakarta">total bab</p>
                <p class="text-4xl font-extrabold font-jakarta">{{ $total_bab }}</p>
            </div>

        </div>

        {{-- buku terbaru --}}
        <div class="p-6 bg-white shadow-md rounded-xl">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold font-jakarta">buku terbaru ditambahkan</h2>
                <a href="{{ route('dashboard-buku.index') }}"
                   class="flex items-center gap-1 text-sm text-gray-400 font-jakarta hover:text-black">
                    lihat lainnya <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            @forelse($buku_terbaru as $buku)
            <div class="flex items-center gap-4 py-3 border-b last:border-b-0">

                {{-- cover buku --}}
                @if($buku->gambar)
                    <img src="{{ asset('storage/' . $buku->gambar) }}"
                         class="object-cover w-12 h-16 rounded-lg"
                         alt="{{ $buku->judul_buku }}">
                @else
                    <div class="flex items-center justify-center w-12 h-16 bg-gray-100 rounded-lg">
                        <i data-lucide="book-open" class="w-6 h-6 text-gray-400"></i>
                    </div>
                @endif

                {{-- info buku --}}
                <div class="flex-1">
                    <p class="font-semibold font-jakarta">{{ $buku->judul_buku }}</p>
                    <p class="text-sm text-gray-500 font-jakarta">
                        {{ $buku->kategori->nama_kategori ?? '-' }} · kelas {{ $buku->kelas }} · semester {{ $buku->semester }}
                    </p>
                </div>

            </div>
            @empty
            <p class="text-gray-400 font-jakarta">belum ada buku yang ditambahkan.</p>
            @endforelse
        </div>

    </main>
</div>
</body>
</html>