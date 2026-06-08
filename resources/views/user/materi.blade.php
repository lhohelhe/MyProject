<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $materi->judul_materi }} — SahabatBuku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ─── Layout shell ─────────────────────────────────── */
        html, body { height: 100%; overflow: hidden; background: #E5F8FF; }

        #reading-shell {
            display: grid;
            grid-template-columns: 240px 1fr 240px;
            grid-template-rows: 100vh;
            height: 100vh;
        }

        /* ─── Sidebars ─────────────────────────────────────── */
        .sidebar {
            height: 100vh;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }

        /* ─── Center scroll area ───────────────────────────── */
        #reading-scroll {
            height: 100vh;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }
        #reading-scroll::-webkit-scrollbar { width: 5px; }
        #reading-scroll::-webkit-scrollbar-track { background: transparent; }
        #reading-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }

        /* ─── Book page ────────────────────────────────────── */
        .book-page {
            font-family: 'Lora', Georgia, serif;
            font-size: 1.05rem;
            line-height: 1.85;
            color: #1e293b;
        }
        .book-page h1, .book-page h2, .book-page h3,
        .book-page h4, .book-page h5, .book-page h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: #0f172a;
            margin-top: 1.8em;
            margin-bottom: 0.6em;
            line-height: 1.3;
        }
        .book-page h2 { font-size: 1.35rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 0.4em; }
        .book-page h3 { font-size: 1.15rem; color: #1e3a5f; }
        .book-page p  { margin-bottom: 1.1em; }
        .book-page ul, .book-page ol { padding-left: 1.5em; margin-bottom: 1em; }
        .book-page li { margin-bottom: 0.35em; }
        .book-page blockquote {
            border-left: 4px solid #F4922A;
            padding: 0.6em 1em;
            margin: 1.2em 0;
            background: #fff7ed;
            border-radius: 0 0.5rem 0.5rem 0;
            color: #7c3311;
            font-style: italic;
        }
        .book-page table { width: 100%; border-collapse: collapse; margin: 1.2em 0; }
        .book-page th { background: #1e3a5f; color: #fff; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.8rem; padding: 0.5em 0.75em; text-align: left; }
        .book-page td { border: 1px solid #e2e8f0; padding: 0.5em 0.75em; font-size: 0.95rem; }
        .book-page tr:nth-child(even) td { background: #f8fafc; }
        .book-page img { max-width: 100%; border-radius: 0.75rem; margin: 1em 0; box-shadow: 0 4px 16px rgba(0,0,0,0.08); }

        /* ─── Key term popover ─────────────────────────────── */
        .term {
            border-bottom: 2px dotted #F4922A;
            color: #c05621;
            cursor: help;
            font-weight: 500;
            transition: background 0.15s;
            border-radius: 2px;
            padding: 0 1px;
        }
        .term:hover { background: #fff7ed; }

        .term-popover {
            position: fixed;
            z-index: 9999;
            background: #1e3a5f;
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.78rem;
            line-height: 1.5;
            padding: 0.55rem 0.8rem;
            border-radius: 0.6rem;
            max-width: 260px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.22);
            pointer-events: none;
            transition: opacity 0.12s;
        }
        .term-popover::before {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 12px;
            width: 10px;
            height: 10px;
            background: #1e3a5f;
            clip-path: polygon(0 0, 100% 0, 50% 100%);
        }

        /* ─── Progress ring ────────────────────────────────── */
        .progress-ring-circle {
            transition: stroke-dashoffset 0.6s ease;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        /* ─── Mobile overlay sidebars ──────────────────────── */
        @media (max-width: 1023px) {
            html, body { overflow: auto; }
            #reading-shell {
                display: block;
                height: auto;
            }
            #reading-scroll { height: auto; overflow-y: visible; }
            .sidebar { height: auto; overflow-y: visible; }
            #left-sidebar, #right-sidebar {
                position: fixed;
                top: 0; bottom: 0;
                width: 280px;
                z-index: 50;
                background: white;
                transition: transform 0.28s cubic-bezier(.4,0,.2,1);
                box-shadow: 4px 0 24px rgba(0,0,0,0.12);
            }
            #left-sidebar  { left: 0;  transform: translateX(-100%); }
            #right-sidebar { right: 0; transform: translateX(100%); }
            #left-sidebar.open  { transform: translateX(0); }
            #right-sidebar.open { transform: translateX(0); }
        }

        /* ─── Chapter map item active ──────────────────────── */
        .chapter-item-active {
            background: linear-gradient(90deg, #fff7ed 0%, transparent 100%);
            border-left: 3px solid #F4922A;
            color: #c05621;
            font-weight: 600;
        }
    </style>
</head>
<body class="antialiased" x-data="readingPage()" @mousemove="onMouseMove($event)" @keydown.escape.window="closeSidebars()">

    {{-- ═══════════════════════════════════════════════════════════════════
         MOBILE TOP BAR
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="lg:hidden fixed top-0 left-0 right-0 z-40 bg-white border-b border-slate-100 flex items-center gap-3 px-4 py-3">
        <button @click="leftOpen = !leftOpen" class="p-1.5 rounded-lg hover:bg-slate-100 transition">
            <i data-lucide="list" class="w-5 h-5 text-slate-600"></i>
        </button>
        <div class="flex-1 min-w-0">
            <p class="text-xs text-slate-400 truncate">{{ $bab->judul_bab }}</p>
            <p class="text-sm font-bold text-slate-800 truncate">{{ $materi->judul_materi }}</p>
        </div>
        <button @click="rightOpen = !rightOpen" class="p-1.5 rounded-lg hover:bg-slate-100 transition">
            <i data-lucide="bar-chart-2" class="w-5 h-5 text-slate-600"></i>
        </button>
    </div>

    {{-- Mobile overlay backdrop --}}
    <div x-show="leftOpen || rightOpen"
         @click="closeSidebars()"
         x-transition:enter="transition-opacity duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/30 z-40 lg:hidden"
         style="display:none;">
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════
         THREE-COLUMN READING SHELL
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div id="reading-shell">

        {{-- ═══════ LEFT SIDEBAR — Chapter Map ═══════ --}}
        <aside id="left-sidebar"
               class="sidebar bg-white border-r-2 border-black overflow-y-auto lg:static"
               :class="{ 'open': leftOpen }">

            <div class="p-5">
                {{-- Logo + Back --}}
                <div class="flex items-center gap-3 mb-6">
                    <a href="{{ route('user.buku.show', $materi->subab->bab->buku->id_buku) }}"
                       class="flex items-center gap-1.5 text-slate-500 hover:text-[#F4922A] transition text-xs font-semibold">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Kembali
                    </a>
                    <img src="{{ asset('images/logo_1.png') }}" alt="SahabatBuku" class="h-6 ml-auto opacity-60">
                </div>

                {{-- Bab heading --}}
                <div class="mb-5">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">
                        BAB {{ $bab->nomor_bab ?? '' }}
                    </p>
                    <h2 class="text-sm font-extrabold text-slate-800 leading-snug">{{ $bab->judul_bab }}</h2>
                    <p class="text-[11px] text-slate-400 mt-1">{{ $materi->subab->bab->buku->judul_buku }}</p>
                </div>

                <div class="h-px bg-slate-100 mb-4"></div>

                {{-- Chapter tree --}}
                @foreach($allSubbab as $subbab)
                    <div class="mb-4" x-data="{ open: {{ $subbab->id_subbab === $materi->id_subbab ? 'true' : 'false' }} }">

                        {{-- Subbab header --}}
                        <button @click="open = !open"
                                class="w-full flex items-center gap-2 text-left mb-1 group">
                            <i data-lucide="chevron-right"
                               class="w-3.5 h-3.5 text-slate-400 transition-transform flex-shrink-0"
                               :class="open ? 'rotate-90' : ''"></i>
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest group-hover:text-[#F4922A] transition">
                                {{ $subbab->nomor_subbab ? $subbab->nomor_subbab . '. ' : '' }}{{ $subbab->judul_subbab }}
                            </span>
                        </button>

                        {{-- Materi list --}}
                        <div x-show="open" x-collapse>
                            <div class="ml-5 border-l-2 border-slate-100 pl-3 space-y-0.5 mt-1">
                                @foreach($subbab->materi as $m)
                                    @php $isActive = $m->id_materi === $materi->id_materi; @endphp
                                    <a href="{{ route('user.materi.baca', $m->id_materi) }}"
                                       class="flex items-start gap-2 px-2 py-1.5 rounded-lg text-xs transition-all group
                                              {{ $isActive ? 'chapter-item-active' : 'text-slate-600 hover:text-[#F4922A] hover:bg-slate-50' }}">
                                        @if($isActive)
                                            <i data-lucide="book-open" class="w-3.5 h-3.5 mt-px flex-shrink-0 text-[#F4922A]"></i>
                                        @else
                                            <i data-lucide="file-text" class="w-3.5 h-3.5 mt-px flex-shrink-0 text-slate-300 group-hover:text-[#F4922A]"></i>
                                        @endif
                                        <span class="leading-snug">{{ $m->judul_materi }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </aside>

        {{-- ═══════ CENTER — Reading Area ═══════ --}}
        <div id="reading-scroll" class="lg:mt-0 mt-14">
            <div class="max-w-[700px] mx-auto px-4 py-10 lg:py-12">

                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-1.5 text-xs text-slate-400 mb-6 flex-wrap">
                    <a href="{{ route('user.katalog') }}" class="hover:text-[#F4922A] transition">Katalog</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="{{ route('user.buku.show', $materi->subab->bab->buku->id_buku) }}" class="hover:text-[#F4922A] transition truncate max-w-[160px]">
                        {{ $materi->subab->bab->buku->judul_buku }}
                    </a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-600 font-medium truncate max-w-[140px]">{{ $materi->judul_materi }}</span>
                </nav>

                {{-- Chapter label above title --}}
                <div class="flex items-center gap-2 mb-3">
                    <span class="inline-block bg-[#1e3a5f] text-white text-[10px] font-bold px-3 py-1 rounded-full tracking-widest uppercase">
                        {{ $materi->subab->nomor_subbab ? $materi->subab->nomor_subbab . ' · ' : '' }}{{ $materi->subab->judul_subbab }}
                    </span>
                </div>

                {{-- Title --}}
                <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 leading-tight mb-8">
                    {{ $materi->judul_materi }}
                </h1>

                {{-- ─── Book Page ─── --}}
                <div class="bg-white rounded-2xl border-2 border-black shadow-[4px_4px_0px_#000]">

                    {{-- Cover image --}}
                    @if($materi->gambar)
                        <div class="overflow-hidden rounded-t-2xl">
                            <img src="{{ asset('storage/' . $materi->gambar) }}"
                                 alt="{{ $materi->judul_materi }}"
                                 class="w-full max-h-72 object-cover">
                        </div>
                    @endif

                    {{-- Content --}}
                    <div class="px-8 lg:px-14 py-10 book-page" id="book-content">
                        @php
                            if (!empty($current)) {
                                $paragraphs[] = implode(' ', $current);
                            }
                            // Jika tidak ada paragraf terdeteksi, pecah per 4 baris
                            if (count($paragraphs) <= 1 && count($lines) > 4) {
                                $paragraphs = array_chunk($lines, 4);
                                $paragraphs = array_map(fn($chunk) => implode(' ', array_filter($chunk, fn($l) => trim($l) !== '')), $paragraphs);
                            }
                        @endphp
                        @foreach($paragraphs as $para)
                            @if(trim($para))
                                <p class="text-slate-700 text-base leading-relaxed mb-4">
                                    {!! nl2br(e(trim($para))) !!}
                                </p>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- ─── Prev / Next Navigation ─── --}}
                <div class="flex items-center gap-4 mt-10">
                    @if($prev)
                        <a href="{{ route('user.materi.baca', $prev->id_materi) }}"
                           class="flex-1 flex items-center gap-3 px-5 py-4 bg-white rounded-2xl border-2 border-black shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all group">
                            <div class="flex-shrink-0 w-8 h-8 rounded-xl bg-slate-100 border-2 border-black group-hover:bg-[#fff7ed] flex items-center justify-center transition">
                                <i data-lucide="arrow-left" class="w-4 h-4 text-slate-500 group-hover:text-[#F4922A]"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Sebelumnya</p>
                                <p class="text-sm font-semibold text-slate-700 group-hover:text-[#F4922A] truncate transition">{{ $prev->judul_materi }}</p>
                            </div>
                        </a>
                    @else
                        <div class="flex-1"></div>
                    @endif

                    @if($next)
                        <a href="{{ route('user.materi.baca', $next->id_materi) }}"
                           class="flex-1 flex items-center gap-3 px-5 py-4 bg-white rounded-2xl border-2 border-black shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all group text-right">
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Selanjutnya</p>
                                <p class="text-sm font-semibold text-slate-700 group-hover:text-[#F4922A] truncate transition">{{ $next->judul_materi }}</p>
                            </div>
                            <div class="flex-shrink-0 w-8 h-8 rounded-xl bg-[#F4922A] border-2 border-black shadow-[2px_2px_0px_#000] group-hover:shadow-none group-hover:translate-x-[2px] group-hover:translate-y-[2px] flex items-center justify-center transition">
                                <i data-lucide="arrow-right" class="w-4 h-4 text-white"></i>
                            </div>
                        </a>
                    @endif
                </div>

                <p class="text-center text-xs text-slate-300 mt-8 mb-4">— SahabatBuku · Belajar dari buku resmi —</p>

            </div>
        </div>

        {{-- ═══════ RIGHT SIDEBAR — Progress & Tools ═══════ --}}
        <aside id="right-sidebar"
               class="sidebar bg-white border-l-2 border-black overflow-y-auto lg:static"
               :class="{ 'open': rightOpen }">

            <div class="p-5">

                {{-- Close on mobile --}}
                <div class="flex items-center justify-between mb-5 lg:hidden">
                    <span class="text-sm font-bold text-slate-700">Progress</span>
                    <button @click="rightOpen = false" class="p-1 rounded-lg hover:bg-slate-100">
                        <i data-lucide="x" class="w-4 h-4 text-slate-500"></i>
                    </button>
                </div>

                {{-- Progress ring + percentage --}}
                @php
                    $readPct = $totalMateri > 0 ? round(100 / $totalMateri) : 0;
                    $circumference = 2 * pi() * 36; // r=36
                    $offset = $circumference - ($readPct / 100) * $circumference;
                @endphp

                <div class="bg-gradient-to-br from-[#1e3a5f] to-[#162a45] rounded-2xl p-5 mb-5 text-center relative overflow-hidden">
                    <div class="absolute w-32 h-32 bg-white/5 -top-6 -right-6 rounded-full"></div>
                    <p class="text-[10px] font-bold text-blue-300 uppercase tracking-widest mb-3">Progress Bab</p>

                    <div class="relative inline-flex items-center justify-center mb-3">
                        <svg width="88" height="88" viewBox="0 0 88 88">
                            <circle cx="44" cy="44" r="36" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="6"/>
                            <circle cx="44" cy="44" r="36" fill="none" stroke="#F4922A" stroke-width="6"
                                    stroke-linecap="round"
                                    stroke-dasharray="{{ $circumference }}"
                                    stroke-dashoffset="{{ $offset }}"
                                    class="progress-ring-circle"/>
                        </svg>
                        <div class="absolute text-center">
                            <p class="text-xl font-extrabold text-white leading-none">{{ $readPct }}%</p>
                        </div>
                    </div>

                    <p class="text-xs text-blue-200">
                        Materi ini <span class="text-white font-semibold">1 dari {{ $totalMateri }}</span> di bab ini
                    </p>
                </div>

                {{-- XP Card --}}
                <div class="bg-[#fff7ed] rounded-2xl p-4 mb-5 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#F4922A] flex items-center justify-center flex-shrink-0">
                        <i data-lucide="zap" class="w-5 h-5 text-white"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-orange-400 uppercase tracking-widest">Total XP kamu</p>
                        <p class="text-xl font-extrabold text-[#c05621]">{{ number_format($userXp) }} <span class="text-sm font-semibold">XP</span></p>
                    </div>
                </div>

                {{-- Divider --}}
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Aktivitas Bab</p>

                {{-- Flashcard shortcut --}}
                <a href="{{ route('user.flashcard', $materi->id_subbab) }}"
                   class="flex items-center gap-3 w-full px-4 py-3 bg-white rounded-xl border-2 border-black shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all group mb-3">
                    <div class="w-8 h-8 rounded-lg bg-orange-50 border-2 border-black flex items-center justify-center flex-shrink-0">
                        <i data-lucide="book-marked" class="w-4 h-4 text-[#F4922A]"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-700 group-hover:text-[#F4922A] transition">Flashcard</p>
                        <p class="text-[10px] text-slate-400">Hafalan istilah subbab ini</p>
                    </div>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-slate-300 group-hover:text-[#F4922A] transition"></i>
                </a>

                {{-- Quiz shortcut --}}
                <a href="{{ route('user.quiz.index', $bab->id_bab) }}"
                   class="flex items-center gap-3 w-full px-4 py-3 bg-white rounded-xl border-2 border-black shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all group mb-5">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 border-2 border-black flex items-center justify-center flex-shrink-0">
                        <i data-lucide="clipboard-list" class="w-4 h-4 text-blue-500"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-700 group-hover:text-blue-600 transition">Mulai Quiz</p>
                        <p class="text-[10px] text-slate-400">Latihan soal bab ini</p>
                    </div>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-slate-300 group-hover:text-blue-400 transition"></i>
                </a>

                {{-- Reading tip --}}
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-xs font-black text-black uppercase tracking-wider mb-3">Fitur Belajar</p>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Arahkan kursor ke kata bergaris bawah oranye untuk melihat definisinya.
                    </p>
                </div>

            </div>
        </aside>

    </div>

    {{-- ═══════════════════════════════════════════════════════════════════
         TERM POPOVER (Alpine-driven, follows mouse)
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div x-show="popover.visible"
         x-transition:enter="transition duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="term-popover"
         style="display:none;"
         :style="`top: ${popover.y}px; left: ${popover.x}px;`">
        <p class="font-bold text-xs text-orange-300 mb-0.5" x-text="popover.term"></p>
        <p x-text="popover.definisi"></p>
    </div>

    <script>
        function readingPage() {
            return {
                leftOpen: false,
                rightOpen: false,
                popover: { visible: false, x: 0, y: 0, term: '', definisi: '' },
                _popoverTarget: null,

                closeSidebars() {
                    this.leftOpen = false;
                    this.rightOpen = false;
                },

                onMouseMove(e) {
                    if (this.popover.visible) {
                        const pad = 12;
                        const pw  = 270;
                        let x = e.clientX + pad;
                        let y = e.clientY - 80;

                        if (x + pw > window.innerWidth) x = e.clientX - pw - pad;
                        if (y < 8) y = e.clientY + 16;

                        this.popover.x = x;
                        this.popover.y = y;
                    }
                },

                initTerms() {
                    document.querySelectorAll('#book-content .term, #book-content [data-definisi]').forEach(el => {
                        el.addEventListener('mouseenter', (e) => {
                            this.popover.term     = el.textContent.trim();
                            this.popover.definisi = el.dataset.definisi || '';
                            this.popover.visible  = true;
                        });
                        el.addEventListener('mouseleave', () => {
                            this.popover.visible = false;
                        });
                    });
                },

                init() {
                    this.$nextTick(() => {
                        this.initTerms();
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                    });
                }
            }
        }
    </script>

    <script>
        document.addEventListener('alpine:init', () => {
        });
        window.addEventListener('load', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>

</body>
</html>
