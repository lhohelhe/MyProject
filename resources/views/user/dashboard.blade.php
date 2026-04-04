<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="antialiased bg-sky-50">
    <div class="min-h-screen">
        
        {{-- Navigation / Header --}}
        <div class="flex items-center justify-between px-6 py-6 bg-white shadow-sm">
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-bold text-black font-jakarta">SahabatBuku</h1>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('user.profile') }}" class="text-sm font-jakarta text-gray-600 hover:text-black">
                    profil
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-jakarta text-gray-600 hover:text-black">
                        keluar
                    </button>
                </form>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            
            {{-- Greeting --}}
            <div class="mb-12">
                <h2 class="text-3xl font-extrabold text-black font-jakarta sm:text-4xl">
                    halo, {{ $user->name }}! 👋
                </h2>
                <p class="mt-2 text-lg text-gray-600 font-jakarta">
                    selamat datang di sahabatbuku. mulai belajar sekarang juga.
                </p>
            </div>

            {{-- Statistics Card --}}
            <div class="mb-12">
                <div class="p-8 bg-white shadow-md rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-jakarta">total buku tersedia</p>
                            <p class="text-5xl font-extrabold text-black font-jakarta mt-2">{{ $total_buku }}</p>
                        </div>
                        <div class="text-6xl">📚</div>
                    </div>
                </div>
            </div>

            {{-- Categories Section --}}
            <div class="mb-12">
                <h3 class="mb-6 text-2xl font-bold text-black font-jakarta">jelajahi kategori</h3>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
                    @forelse($kategori as $kat)
                        <a href="#" class="block p-4 text-center text-white transition-colors bg-orange-400 rounded-xl hover:bg-orange-500 font-jakarta">
                            <p class="font-medium truncate">{{ $kat->nama_kategori }}</p>
                        </a>
                    @empty
                        <p class="col-span-full text-gray-500 font-jakarta">belum ada kategori</p>
                    @endforelse
                </div>
            </div>

            {{-- Latest Books Section --}}
            <div>
                <h3 class="mb-6 text-2xl font-bold text-black font-jakarta">buku terbaru</h3>
                
                @if($buku_terbaru->isEmpty())
                    <div class="p-8 text-center bg-white rounded-xl">
                        <p class="text-gray-500 font-jakarta">belum ada buku yang ditambahkan</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                        @foreach($buku_terbaru as $buku)
                            <a href="#" class="group">
                                <div class="overflow-hidden bg-white shadow-md rounded-xl hover:shadow-lg transition-shadow">
                                    
                                    {{-- Cover --}}
                                    @if($buku->gambar)
                                        <img src="{{ asset('storage/' . $buku->gambar) }}"
                                             alt="{{ $buku->judul_buku }}"
                                             class="object-cover w-full h-56 group-hover:opacity-90 transition-opacity"
                                             style="aspect-ratio: 717 / 1027;">
                                    @else
                                        <div class="flex items-center justify-center w-full h-56 text-5xl bg-gray-100 text-gray-300">
                                            📖
                                        </div>
                                    @endif

                                    {{-- Info --}}
                                    <div class="p-3">
                                        <p class="font-semibold text-sm text-black line-clamp-2 font-jakarta">
                                            {{ $buku->judul_buku }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-2 font-jakarta">
                                            {{ $buku->kategori->nama_kategori ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

    </div>
</body>
</html>
