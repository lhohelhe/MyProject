<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $buku->judul_buku }} - SahabatBuku</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .progress-bar-inner {
            transition: width 0.6s ease;
        }
    </style>
</head>
<body class="antialiased bg-[#E5F8FF]">
<div class="flex min-h-screen">

    <x-user-sidebar />

    <main class="flex-1 px-8 py-6 overflow-y-auto">

        {{-- ===== SECTION 1: INFO BUKU ===== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
            <div class="flex gap-6 items-start">
                {{-- Cover --}}
                <div class="flex-shrink-0">
                    @if($buku->gambar)
                        <img src="{{ asset('storage/' . $buku->gambar) }}"
                             alt="{{ $buku->judul_buku }}"
                             class="w-[120px] h-[160px] object-cover rounded-xl shadow-md">
                    @else
                        <div class="w-[120px] h-[160px] bg-slate-100 rounded-xl flex items-center justify-center">
                            <i data-lucide="book-open" class="w-10 h-10 text-slate-300"></i>
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl font-extrabold text-slate-800 mb-2">{{ $buku->judul_buku }}</h1>

                    <span class="inline-block bg-[#F4922A] text-white text-xs font-bold px-3 py-1 rounded-lg mb-4">
                        Kelas {{ $buku->kelas }}
                    </span>

                    {{-- Progress keseluruhan buku --}}
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Progress Keseluruhan</span>
                            <span class="text-sm font-bold text-[#F4922A]">{{ $progress }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="progress-bar-inner h-2 rounded-full bg-[#F4922A]"
                                 style="width: {{ $progress }}%"></div>
                        </div>
                        @if($progress == 0)
                            <p class="text-xs text-slate-400 mt-1">Belum ada progres — mulai dari Bab 1!</p>
                        @endif
                    </div>

                    {{-- Detail buku --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3 border-t border-slate-100">
                        @foreach([
                            ['Penerbit', $buku->penerbit ?? '-'],
                            ['ISBN', $buku->isbn ?? '-'],
                            ['Edisi', $buku->edisi ?? '-'],
                            ['Penulis', $buku->penulis ?? '-'],
                        ] as [$label, $val])
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">{{ $label }}</p>
                            <p class="text-xs font-semibold text-slate-700">{{ $val }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== SECTION 2: FITUR BELAJAR ===== --}}
        <div class="mb-6">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Fitur Belajar</p>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">

                {{-- Notes AI --}}
                <a href="#"
                   class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col items-center gap-3 hover:shadow-md hover:border-orange-200 transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center group-hover:bg-orange-100 transition">
                        <i data-lucide="notebook-pen" class="w-5 h-5 text-[#F4922A]"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Notes AI</p>
                    <span class="text-[10px] text-slate-400 font-medium">Ringkasan materi</span>
                </a>

                {{-- Quiz --}}
                <a href="{{ route('user.quiz.index', $buku->bab->first()?->id_bab ?? 0) }}"
                   class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col items-center gap-3 hover:shadow-md hover:border-blue-200 transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition">
                        <i data-lucide="clipboard-list" class="w-5 h-5 text-blue-500"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Quiz</p>
                    <span class="text-[10px] text-slate-400 font-medium">Latihan soal per bab</span>
                </a>

                {{-- Flashcard --}}
                <a href="{{ route('user.flashcard', $buku->bab->first()?->subab->first()?->id_subbab ?? 0) }}"
                   class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col items-center gap-3 hover:shadow-md hover:border-purple-200 transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center group-hover:bg-purple-100 transition">
                        <i data-lucide="book-marked" class="w-5 h-5 text-purple-500"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Flashcard</p>
                    <span class="text-[10px] text-slate-400 font-medium">Hafalan istilah</span>
                </a>

                {{-- Ujian Simulasi --}}
                <a href="{{ route('user.simulasi.index', ['book' => $buku->id_buku]) }}"
                   class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col items-center gap-3 hover:shadow-md hover:border-green-200 transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center group-hover:bg-green-100 transition">
                        <i data-lucide="timer" class="w-5 h-5 text-green-500"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Ujian Simulasi</p>
                    <span class="text-[10px] text-slate-400 font-medium">Multi bab bertimer</span>
                </a>

            </div>
        </div>

        {{-- ===== SECTION 3: DAFTAR ISI (per Bab dengan progress) ===== --}}
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Daftar Isi</p>

            <div class="space-y-3">
                @forelse($buku->bab as $index => $bab)
                @php
                    $prog = $babProgress[$bab->id_bab] ?? ['overall_pct' => 0, 'quiz_pct' => 0, 'flash_pct' => 0, 'quiz_done' => 0, 'quiz_total' => 0, 'flash_done' => 0, 'flash_total' => 0];
                    $isStarted = $prog['overall_pct'] > 0;
                    $isDone = $prog['overall_pct'] >= 100;
                @endphp

                {{-- Bab card --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden"
                     x-data="{ open: {{ $index === 0 ? 'true' : 'false' }} }">

                    {{-- Bab header (clickable to expand) --}}
                    <button @click="open = !open"
                            class="w-full flex items-center gap-4 px-5 py-4 text-left hover:bg-slate-50 transition">

                        {{-- BAB number badge --}}
                        <span class="flex-shrink-0 w-10 h-10 rounded-xl bg-[#F4922A] text-white text-xs font-extrabold flex items-center justify-center">
                            {{ $index + 1 }}
                        </span>

                        {{-- Title + progress --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1.5">
                                <p class="text-sm font-bold text-slate-800 truncate pr-4">{{ $bab->judul_bab }}</p>
                                <span class="flex-shrink-0 text-xs font-bold {{ $isDone ? 'text-green-500' : 'text-[#F4922A]' }}">
                                    {{ $prog['overall_pct'] }}%
                                </span>
                            </div>
                            {{-- Progress bar --}}
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="progress-bar-inner h-1.5 rounded-full {{ $isDone ? 'bg-green-500' : 'bg-[#F4922A]' }}"
                                     style="width: {{ $prog['overall_pct'] }}%"></div>
                            </div>
                        </div>

                        {{-- Status icon --}}
                        <div class="flex-shrink-0">
                            @if($isDone)
                                <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                            @elseif($isStarted)
                                <i data-lucide="clock" class="w-5 h-5 text-orange-400"></i>
                            @else
                                <i data-lucide="circle" class="w-5 h-5 text-slate-300"></i>
                            @endif
                        </div>

                        {{-- Chevron --}}
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 transition-transform"
                           :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    {{-- Expanded content --}}
                    <div x-show="open" x-collapse class="border-t border-slate-100">

                        {{-- Mini progress per aktivitas --}}
                        <div class="px-5 py-3 bg-slate-50 grid grid-cols-2 gap-3">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] font-semibold text-slate-500 flex items-center gap-1">
                                        <i data-lucide="clipboard-list" class="w-3 h-3"></i> Quiz
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-600">{{ $prog['quiz_done'] }}/{{ $prog['quiz_total'] }}</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-1">
                                    <div class="h-1 rounded-full bg-blue-400 progress-bar-inner"
                                         style="width: {{ $prog['quiz_pct'] }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] font-semibold text-slate-500 flex items-center gap-1">
                                        <i data-lucide="book-marked" class="w-3 h-3"></i> Flashcard
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-600">{{ $prog['flash_done'] }}/{{ $prog['flash_total'] }}</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-1">
                                    <div class="h-1 rounded-full bg-purple-400 progress-bar-inner"
                                         style="width: {{ $prog['flash_pct'] }}%"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Daftar materi --}}
                        <div class="px-5 py-3 space-y-1">
                            @forelse($bab->subab as $subbab)
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pt-2 pb-1">
                                    {{ $subbab->judul_subbab ?? 'Subbab' }}
                                </p>
                                @forelse($subbab->materi as $materi)
                                    <a href="{{ route('user.materi.baca', $materi->id_materi) }}"
                                       class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[#E5F8FF] hover:text-[#F4922A] transition-all group">
                                        <i data-lucide="file-text" class="w-3.5 h-3.5 text-slate-300 group-hover:text-[#F4922A] flex-shrink-0"></i>
                                        <span class="text-sm text-slate-700 group-hover:text-[#F4922A] group-hover:font-medium transition-all">
                                            {{ $materi->judul_materi }}
                                        </span>
                                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-slate-300 group-hover:text-[#F4922A] ml-auto opacity-0 group-hover:opacity-100 transition-all"></i>
                                    </a>
                                @empty
                                    <p class="text-xs text-slate-400 px-3 py-1">Tidak ada materi</p>
                                @endforelse
                            @empty
                                <p class="text-xs text-slate-400 py-2">Tidak ada sub-bab</p>
                            @endforelse
                        </div>

                    </div>
                </div>
                @empty
                    <div class="bg-white rounded-2xl p-8 text-center border border-slate-100">
                        <i data-lucide="inbox" class="w-10 h-10 text-slate-300 mx-auto mb-3"></i>
                        <p class="text-slate-400 text-sm">Belum ada bab</p>
                    </div>
                @endforelse
            </div>
        </div>

    </main>
</div>

<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
</body>
</html>
