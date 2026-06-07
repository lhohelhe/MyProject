<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog - SahabatBuku</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="antialiased font-jakarta" style="background-color: #E5F8FF;">
<div class="flex min-h-screen">

    <x-user-sidebar />

    {{-- konten utama --}}
    <main class="flex-1 px-8 py-6 overflow-y-auto">

        {{-- judul halaman --}}
        <h1 class="mb-6 text-2xl font-black uppercase tracking-wider text-black border-b-4 border-black pb-2">Katalog Buku</h1>

        {{-- grid buku --}}
        @if($buku->isEmpty())
            <p class="italic text-gray-400 font-jakarta">belum ada buku yang tersedia.</p>
        @else
            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach($buku as $b)
<a href="{{ route('user.buku.show', $b->id_buku) }}" class="relative flex flex-col items-center bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl overflow-hidden cursor-pointer hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all">

    {{-- badge kelas — pojok kiri atas --}}
    <div class="absolute z-10 top-2 left-2 bg-[#F4922A] text-white border-2 border-black rounded-full px-3 py-0.5 shadow-[2px_2px_0px_#000]">
        <span class="text-[11px] font-bold font-jakarta">
            Kelas {{ $b->kelas }}
        </span>
    </div>

    {{-- cover buku --}}
    <div class="w-full overflow-hidden border-b-2 border-black" style="aspect-ratio: 3/4;">
        @if($b->gambar)
            <img src="{{ asset('storage/' . $b->gambar) }}"
                 alt="{{ $b->judul_buku }}"
                 class="object-cover w-full h-full">
        @else
            <div class="flex items-center justify-center w-full h-full text-5xl bg-gray-100">
                <i data-lucide="book-open" class="w-16 h-16 text-gray-400"></i>
            </div>
        @endif
    </div>

    {{-- judul buku --}}
    <div class="w-full px-3 py-3 text-center bg-white">
        <p class="text-[11px] font-bold leading-tight text-black font-jakarta">
            {{ $b->judul_buku }}
        </p>
    </div>

</a>
@endforeach
            </div>
        @endif

    </main>
</div>
<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
</body>
</html>
