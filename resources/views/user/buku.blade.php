<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $buku->judul_buku }} - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="antialiased font-jakarta" style="background-color: #E5F8FF;">
<div class="flex min-h-screen">

    <x-user-sidebar />

    {{-- konten utama --}}
    <main class="flex-1 px-8 py-8 overflow-y-auto">

        <div class="p-6 mb-12 bg-white rounded-2xl shadow-[0px_3px_10px_0px_rgba(0,0,0,0.15)]">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                {{-- Gambar cover --}}
                <div class="flex justify-center md:justify-start">
                    @if($buku->gambar)
                        <img src="{{ Storage::url($buku->gambar) }}" alt="{{ $buku->judul_buku }}" class="object-cover shadow-md rounded-xl" style="height: 280px; width: 200px;">
                    @else
                        <div class="flex items-center justify-center w-48 bg-gray-200 h-72 rounded-xl">
                            <span class="text-sm text-gray-400 font-jakarta">Tidak ada cover</span>
                        </div>
                    @endif
                </div>

                {{-- Info detail --}}
                <div class="md:col-span-2">
                    {{-- Judul --}}
                    <h1 class="mb-4 text-2xl font-bold text-black font-jakarta">{{ $buku->judul_buku }}</h1>

                    {{-- Badge kelas --}}
                    <div class="inline-block mb-6">
                        <span class="px-3 py-1 text-sm font-bold text-white rounded-lg font-jakarta" style="background-color: #F0924E;">
                            Kelas {{ $buku->kelas }}
                        </span>
                    </div>

                    {{-- Garis pemisah --}}
                    <div class="mb-6 border-t border-gray-200"></div>

                    {{-- Detail Buku (4 kolom) --}}
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                        <div>
                            <p class="mb-2 text-xs font-semibold text-gray-600 font-jakarta">Penerbit</p>
                            <p class="text-sm font-bold text-gray-800 font-jakarta">{{ $buku->penerbit ?? 'Tidak tersedia' }}</p>
                        </div>
                        <div>
                            <p class="mb-2 text-xs font-semibold text-gray-600 font-jakarta">ISBN</p>
                            <p class="text-sm font-bold text-gray-800 font-jakarta">{{ $buku->isbn ?? 'Tidak tersedia' }}</p>
                        </div>
                        <div>
                            <p class="mb-2 text-xs font-semibold text-gray-600 font-jakarta">Edisi</p>
                            <p class="text-sm font-bold text-gray-800 font-jakarta">{{ $buku->edisi ?? 'Tidak tersedia' }}</p>
                        </div>
                        <div>
                            <p class="mb-2 text-xs font-semibold text-gray-600 font-jakarta">Penulis</p>
                            <p class="text-sm font-bold text-gray-800 font-jakarta">{{ $buku->penulis ?? 'Tidak tersedia' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Progress Bar ===== --}}
        <div class="mb-12">
            <div class="flex items-center gap-3 p-4 bg-white rounded-2xl shadow-[0px_3px_10px_0px_rgba(0,0,0,0.15)]">
                {{-- Icon bookmark --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor" class="text-blue-500">
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                </svg>
                {{-- Progress text --}}
                <span class="font-semibold text-gray-800 font-jakarta">
                    @if($progress == 0)
                        Belum ada progres, mari mulai!
                    @else
                        Progres: {{ $progress }}%
                    @endif
                </span>
            </div>
        </div>

        {{-- ===== 4 Tombol Fitur (Grid 4 Kolom) ===== --}}
        <div class="mb-12">
            <h2 class="mb-6 text-lg font-bold text-black font-jakarta">Fitur Belajar</h2>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                {{-- Notes AI --}}
                <a href="#" class="p-6 bg-white rounded-2xl shadow-[0px_3px_10px_0px_rgba(0,0,0,0.15)] hover:shadow-lg transition text-center">
                    <div class="mb-4 text-3xl">📝</div>
                    <p class="mb-3 text-sm font-bold text-gray-800 font-jakarta">Notes AI</p>
                    <div class="flex justify-center gap-1">
                        <span class="text-xl text-gray-300">⭐</span>
                        <span class="text-xl text-gray-300">⭐</span>
                        <span class="text-xl text-gray-300">⭐</span>
                    </div>
                </a>

                {{-- Quiz --}}
                <a href="{{ route('user.quiz.index', $buku->bab->first()?->id_bab ?? '#') }}" class="p-6 bg-white rounded-2xl shadow-[0px_3px_10px_0px_rgba(0,0,0,0.15)] hover:shadow-lg transition text-center">
                    <div class="mb-4 text-3xl">❓</div>
                    <p class="mb-3 text-sm font-bold text-gray-800 font-jakarta">Quiz</p>
                    <div class="flex justify-center gap-1">
                        <span class="text-xl text-gray-300">⭐</span>
                        <span class="text-xl text-gray-300">⭐</span>
                        <span class="text-xl text-gray-300">⭐</span>
                    </div>
                </a>

                {{-- Flashcard --}}
                <a href="{{ route('user.flashcard', $buku->bab->first()?->subbab->first()?->id_subbab ?? '#') }}" class="p-6 bg-white rounded-2xl shadow-[0px_3px_10px_0px_rgba(0,0,0,0.15)] hover:shadow-lg transition text-center">
                    <div class="mb-4 text-3xl">🎴</div>
                    <p class="mb-3 text-sm font-bold text-gray-800 font-jakarta">Flashcard</p>
                    <div class="flex justify-center gap-1">
                        <span class="text-xl text-gray-300">⭐</span>
                        <span class="text-xl text-gray-300">⭐</span>
                        <span class="text-xl text-gray-300">⭐</span>
                    </div>
                </a>

                {{-- Ujian Simulasi --}}
                <a href="{{ route('user.simulasi.index', ['book' => $buku->id_buku]) }}" class="p-6 bg-white rounded-2xl shadow-[0px_3px_10px_0px_rgba(0,0,0,0.15)] hover:shadow-lg transition text-center">
                    <div class="mb-4 text-3xl">📋</div>
                    <p class="mb-3 text-sm font-bold text-gray-800 font-jakarta">Ujian Simulasi</p>
                    <div class="flex justify-center gap-1">
                        <span class="text-xl text-gray-300">⭐</span>
                        <span class="text-xl text-gray-300">⭐</span>
                        <span class="text-xl text-gray-300">⭐</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- ===== SECTION 4: Daftar Isi ===== --}}
        <div>
            <div class="flex items-center gap-2 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="text-blue-500">
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                </svg>
                <h2 class="text-lg font-bold text-black font-jakarta">Daftar Isi</h2>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @forelse($buku->bab as $index => $bab)
                    <div class="p-6 bg-white rounded-2xl shadow-[0px_3px_10px_0px_rgba(0,0,0,0.15)] relative overflow-hidden">
                        {{-- Badge BAB N --}}
                        <div class="absolute top-0 left-0 px-3 py-1 font-bold text-white rounded-br-lg font-jakarta" style="background-color: #F0924E;">
                            BAB {{ $index + 1 }}
                        </div>

                        {{-- Daftar materi dalam bab --}}
                        <div class="pt-8">
                            <p class="mb-4 text-sm font-bold text-gray-600 uppercase font-jakarta">{{ $bab->judul_bab }}</p>
                            <ul class="space-y-2">
                                @forelse($bab->subbab as $subbab)
                                    @forelse($subbab->materi as $materi)
                                        <li>
                                            <a href="{{ route('user.materi.show', $materi->id_materi) }}" class="text-sm text-gray-700 hover:text-[#F0924E] transition font-jakarta">
                                                • {{ $materi->judul_materi ?? 'Materi' }}
                                            </a>
                                        </li>
                                    @empty
                                        <li class="text-sm text-gray-400 font-jakarta">Tidak ada materi</li>
                                    @endforelse
                                @empty
                                    <li class="text-sm text-gray-400 font-jakarta">Tidak ada sub-bab</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center bg-white col-span-full rounded-2xl">
                        <p class="text-gray-400 font-jakarta">Belum ada bab</p>
                    </div>
                @endforelse
            </div>
        </div>

    </main>

</div>
</body>
</html>
