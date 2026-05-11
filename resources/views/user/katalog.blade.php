<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="antialiased font-jakarta" style="background-color: #E5F8FF;">
<div class="flex min-h-screen">

    <x-user-sidebar />

    {{-- konten utama --}}
    <main class="flex-1 px-8 py-8 overflow-y-auto">

        {{-- judul halaman --}}
        <h1 class="mb-6 text-2xl font-bold text-black font-jakarta">Katalog Buku</h1>

        {{-- grid buku --}}
        @if($buku->isEmpty())
            <p class="italic text-gray-400 font-jakarta">belum ada buku yang tersedia.</p>
        @else
            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach($buku as $b)
<a href="{{ route('user.buku.show', $b->id_buku) }}" class="relative flex flex-col items-center bg-white rounded-[12px] shadow-[0px_3px_10px_0px_rgba(0,0,0,0.15)] overflow-hidden cursor-pointer hover:shadow-[0px_6px_16px_0px_rgba(0,0,0,0.2)] transition-shadow">

    {{-- badge kelas — pojok kiri atas --}}
    <div class="absolute z-10 top-2 left-2 bg-[#F0924E] text-white rounded-[8px] px-2 py-1 shadow-[0px_3px_10px_0px_rgba(0,0,0,0.25)]">
        <span class="text-[13px] font-bold" style="font-family: 'Times New Roman', serif;">
            {{ $b->kelas }}
        </span>
    </div>

    {{-- cover buku --}}
    <div class="w-full overflow-hidden" style="aspect-ratio: 3/4;">
        @if($b->gambar)
            <img src="{{ Storage::url($b->gambar) }}"
                 alt="{{ $b->judul_buku }}"
                 class="object-cover w-full h-full">
        @else
            <div class="flex items-center justify-center w-full h-full text-5xl bg-gray-100">
                <i data-lucide="book-open" class="w-16 h-16 text-gray-400"></i>
            </div>
        @endif
    </div>

    {{-- judul buku --}}
    <div class="w-full px-3 py-3 text-center">
        <p class="text-[11px] font-light leading-tight text-black font-jakarta">
            {{ $b->judul_buku }}
        </p>
    </div>

</a>
@endforeach
            </div>
        @endif

    </main>
</div>
</body>
</html>
