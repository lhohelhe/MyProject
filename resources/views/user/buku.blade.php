<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <div class="bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl p-6 mb-6">
            <div class="flex gap-6 items-start">
                {{-- Cover --}}
                <div class="flex-shrink-0">
                    @if($buku->gambar)
                        <img src="{{ asset('storage/' . $buku->gambar) }}"
                             alt="{{ $buku->judul_buku }}"
                             class="w-[120px] h-[160px] object-cover border-2 border-black rounded-xl shadow-[3px_3px_0px_#000]">
                    @else
                        <div class="w-[120px] h-[160px] bg-slate-100 border-2 border-black rounded-xl flex items-center justify-center">
                            <i data-lucide="book-open" class="w-10 h-10 text-slate-400"></i>
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl font-black text-black mb-2">{{ $buku->judul_buku }}</h1>

                    <span class="inline-block bg-[#F4922A] text-white text-xs font-black uppercase tracking-wider px-3 py-1 border-2 border-black rounded-full shadow-[2px_2px_0px_#000] mb-4">
                        Kelas {{ $buku->kelas }}
                    </span>

                    {{-- Progress keseluruhan buku --}}
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-black text-black uppercase tracking-wider">Progress Keseluruhan</span>
                            <span class="text-sm font-black text-black">{{ $progress }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 border-2 border-black rounded-full h-4 overflow-hidden bg-white">
                            <div class="progress-bar-inner h-full bg-[#F4922A] rounded-full"
                                 style="width: {{ $progress }}%"></div>
                        </div>
                        @if($progress == 0)
                            <p class="text-xs text-slate-500 font-bold mt-1">Belum ada progres — mulai dari Bab 1!</p>
                        @endif
                    </div>

                    {{-- Detail buku --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3 border-t-2 border-black">
                        @foreach([
                            ['Penerbit', $buku->penerbit ?? '-'],
                            ['ISBN', $buku->isbn ?? '-'],
                            ['Edisi', $buku->edisi ?? '-'],
                            ['Penulis', $buku->penulis ?? '-'],
                        ] as [$label, $val])
                        <div>
                            <p class="text-[10px] font-black text-black uppercase tracking-widest mb-0.5">{{ $label }}</p>
                            <p class="text-xs font-bold text-slate-800">{{ $val }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== SECTION 2: FITUR BELAJAR ===== --}}
        <div class="mb-6">
            <p class="text-xs font-black text-black uppercase tracking-wider mb-3">Fitur Belajar</p>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">

                {{-- Notes AI --}}
                <a href="{{ route('user.buku.ringkasan', ['id' => $buku->id_buku, 'id_bab' => $buku->bab->first()?->id_bab ?? 0]) }}"
                   class="bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl p-5 flex flex-col items-center gap-3 hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all group">
                    <div class="w-10 h-10 border-2 border-black rounded-xl bg-orange-50 flex items-center justify-center transition">
                        <i data-lucide="notebook-pen" class="w-5 h-5 text-[#F4922A]"></i>
                    </div>
                    <p class="text-sm font-black text-black">Notes AI</p>
                    <span class="text-[10px] text-black font-bold">Ringkasan materi</span>
                </a>

                {{-- Quiz --}}
                @if($buku->bab->isNotEmpty())
                <a href="{{ route('user.quiz.index', $buku->bab->first()->id_bab) }}"
                   class="bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl p-5 flex flex-col items-center gap-3 hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all group">
                    <div class="w-10 h-10 border-2 border-black rounded-xl bg-orange-50 flex items-center justify-center transition">
                        <i data-lucide="clipboard-list" class="w-5 h-5 text-[#F4922A]"></i>
                    </div>
                    <p class="text-sm font-black text-black">Quiz</p>
                    <span class="text-[10px] text-black font-bold">Latihan soal per bab</span>
                </a>
                @endif

                {{-- Flashcard --}}
                @if($buku->bab->isNotEmpty() && $buku->bab->first()->subab->isNotEmpty())
                <a href="{{ route('user.flashcard', $buku->bab->first()->subab->first()->id_subbab) }}"
                   class="bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl p-5 flex flex-col items-center gap-3 hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all group">
                    <div class="w-10 h-10 border-2 border-black rounded-xl bg-orange-50 flex items-center justify-center transition">
                        <i data-lucide="book-marked" class="w-5 h-5 text-[#F4922A]"></i>
                    </div>
                    <p class="text-sm font-black text-black">Flashcard</p>
                    <span class="text-[10px] text-black font-bold">Hafalan istilah</span>
                </a>
                @endif

                {{-- Ujian Simulasi --}}
                <a href="{{ route('user.simulasi.index', ['book' => $buku->id_buku]) }}"
                   class="bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl p-5 flex flex-col items-center gap-3 hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all group">
                    <div class="w-10 h-10 border-2 border-black rounded-xl bg-orange-50 flex items-center justify-center transition">
                        <i data-lucide="timer" class="w-5 h-5 text-[#F4922A]"></i>
                    </div>
                    <p class="text-sm font-black text-black">Ujian Simulasi</p>
                    <span class="text-[10px] text-black font-bold">Multi bab bertimer</span>
                </a>

            </div>
        </div>

        {{-- ===== SECTION 3: DAFTAR ISI (per Bab dengan progress) ===== --}}
        <div>
            <p class="text-xs font-black text-black uppercase tracking-wider mb-3">Daftar Isi</p>

            <div class="space-y-3">
                @forelse($buku->bab as $index => $bab)
                @php
                    $prog = $babProgress[$bab->id_bab] ?? ['overall_pct' => 0, 'quiz_pct' => 0, 'flash_pct' => 0, 'quiz_done' => 0, 'quiz_total' => 0, 'flash_done' => 0, 'flash_total' => 0];
                    $isStarted = $prog['overall_pct'] > 0;
                    $isDone = $prog['overall_pct'] >= 100;
                @endphp

                {{-- Bab card --}}
                <div class="bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl overflow-hidden mb-4"
                     x-data="{ open: {{ $index === 0 ? 'true' : 'false' }} }">

                    {{-- Bab header (clickable to expand) --}}
                    <button @click="open = !open"
                            class="w-full flex items-center gap-4 px-5 py-4 text-left hover:bg-slate-50 transition border-b-2 border-black">

                        {{-- BAB number badge --}}
                        <span class="flex-shrink-0 w-10 h-10 border-2 border-black rounded-xl bg-[#F4922A] text-white text-xs font-black flex items-center justify-center">
                            {{ $index + 1 }}
                        </span>

                        {{-- Title + progress --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1.5">
                                <p class="text-sm font-black text-black truncate pr-4">{{ $bab->judul_bab }}</p>
                                <span class="flex-shrink-0 text-xs font-black {{ $isDone ? 'text-green-600' : 'text-black' }}">
                                    {{ $prog['overall_pct'] }}%
                                </span>
                            </div>
                            {{-- Progress bar --}}
                            <div class="w-full bg-slate-100 border border-black rounded-full h-2 bg-white overflow-hidden">
                                <div class="progress-bar-inner h-full rounded-full {{ $isDone ? 'bg-green-500' : 'bg-[#F4922A]' }}"
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
                    <div x-show="open" x-collapse class="">

                        {{-- Mini progress per aktivitas --}}
                        <div class="px-5 py-3 bg-slate-50 grid grid-cols-2 gap-3 border-b-2 border-black">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] font-black text-black flex items-center gap-1">
                                        <i data-lucide="clipboard-list" class="w-3 h-3"></i> Quiz
                                    </span>
                                    <span class="text-[10px] font-black text-black">{{ $prog['quiz_done'] }}/{{ $prog['quiz_total'] }}</span>
                                </div>
                                <div class="w-full bg-white border border-black rounded-full h-2.5 overflow-hidden">
                                    <div class="h-full bg-blue-400 progress-bar-inner rounded-full"
                                         style="width: {{ $prog['quiz_pct'] }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] font-black text-black flex items-center gap-1">
                                        <i data-lucide="book-marked" class="w-3 h-3"></i> Flashcard
                                    </span>
                                    <span class="text-[10px] font-black text-black">{{ $prog['flash_done'] }}/{{ $prog['flash_total'] }}</span>
                                </div>
                                <div class="w-full bg-white border border-black rounded-full h-2.5 overflow-hidden">
                                    <div class="h-full bg-[#F4922A] progress-bar-inner rounded-full"
                                         style="width: {{ $prog['flash_pct'] }}%"></div>
                                </div>
                            </div>
                        </div>

                        {{-- AI Actions per Bab --}}
                        <div class="px-5 py-3 flex flex-wrap gap-2 border-b-2 border-black bg-slate-50">
                            {{-- Notes AI --}}
                            <button
                                onclick="generateNotes({{ $bab->id_bab }}, this)"
                                id="notes-btn-{{ $bab->id_bab }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#F4922A] text-white text-xs font-bold border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all disabled:opacity-60">
                                <i data-lucide="notebook-pen" class="w-3.5 h-3.5"></i>
                                Notes AI
                            </button>
                        </div>

                        {{-- Notes AI Result Box --}}
                        <div id="notes-result-{{ $bab->id_bab }}" class="hidden px-5 py-3 border-b-2 border-black bg-slate-50">
                            <div class="p-4 bg-white border-2 border-black rounded-xl text-sm text-black leading-relaxed notes-content">
                            </div>
                        </div>

                        {{-- Daftar materi --}}
                        <div class="px-5 py-3 space-y-2">
                            @forelse($bab->subab as $subbab)
                                <p class="text-[11px] font-black text-black uppercase tracking-wider pt-2 pb-1 border-b border-black/10">
                                    {{ $subbab->judul_subbab ?? 'Subbab' }}
                                </p>
                                @forelse($subbab->materi as $materi)
                                    <a href="{{ route('user.materi.baca', $materi->id_materi) }}"
                                       class="flex items-center gap-3 px-3 py-2 border border-transparent hover:border-black hover:bg-[#F4922A]/10 hover:text-black transition-all group rounded-xl">
                                        <i data-lucide="file-text" class="w-3.5 h-3.5 text-black flex-shrink-0"></i>
                                        <span class="text-sm text-black group-hover:font-bold transition-all">
                                            {{ $materi->judul_materi }}
                                        </span>
                                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-black ml-auto opacity-0 group-hover:opacity-100 transition-all"></i>
                                    </a>
                                @empty
                                    <p class="text-xs text-black px-3 py-1 font-bold">Tidak ada materi</p>
                                @endforelse
                            @empty
                                <p class="text-xs text-black py-2 font-bold">Tidak ada sub-bab</p>
                            @endforelse
                        </div>

                    </div>
                </div>
                @empty
                    <div class="bg-white border-2 border-black p-8 text-center rounded-xl">
                        <i data-lucide="inbox" class="w-10 h-10 text-black mx-auto mb-3"></i>
                        <p class="text-black font-bold text-sm">Belum ada bab</p>
                    </div>
                @endforelse
            </div>
        </div>

    </main>
</div>

<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();

    const BUKU_ID  = {{ $buku->id_buku }};
    const CACHE_PREFIX = 'notes_ai_buku{{ $buku->id_buku }}_bab_';

    // ── Helpers ─────────────────────────────────────────────────────────────

    function cacheKey(idBab) {
        return CACHE_PREFIX + idBab;
    }

    function saveToCache(idBab, html) {
        try {
            localStorage.setItem(cacheKey(idBab), JSON.stringify({
                html: html,
                savedAt: Date.now()
            }));
        } catch (e) { /* localStorage penuh / private mode */ }
    }

    function loadFromCache(idBab) {
        try {
            const raw = localStorage.getItem(cacheKey(idBab));
            return raw ? JSON.parse(raw) : null;
        } catch (e) { return null; }
    }

    function formatRingkasan(text) {
        const lines = text.split('\n').map(l => l.trim()).filter(l => l.length > 0);
        return lines.map(line => {
            if (line.startsWith('•') || line.startsWith('-') || line.startsWith('*')) {
                return `<div class="flex items-start gap-2 mb-1.5">
                    <span class="text-[#F4922A] font-bold mt-0.5 flex-shrink-0">•</span>
                    <span>${line.replace(/^[•\-\*]\s*/, '')}</span>
                </div>`;
            }
            return `<p class="mb-1.5 text-slate-600">${line}</p>`;
        }).join('');
    }

    // Restore cached
    function renderCached(idBab, cached) {
        const resultWrapper = document.getElementById('notes-result-' + idBab);
        const resultBox     = resultWrapper.querySelector('.notes-content');
        const btn           = document.getElementById('notes-btn-' + idBab);

        const ts = new Date(cached.savedAt).toLocaleString('id-ID', {
            day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit'
        });

        resultWrapper.classList.remove('hidden');
        resultBox.innerHTML =
            `<div class="flex items-center justify-between mb-2 pb-2 border-b border-orange-100">
                <span class="text-[10px] text-orange-400 font-semibold uppercase tracking-wide flex items-center gap-1">
                    ✨ Disimpan ${ts}
                </span>
                <button onclick="clearCache(${idBab}, this)"
                        class="text-[10px] text-slate-400 hover:text-red-400 transition-colors font-medium">
                    Buat ulang
                </button>
            </div>` + cached.html;

        if (btn) {
            btn.disabled = false;
            btn.innerHTML = iconPen() + ' Notes AI';
        }
    }

    function iconSpinner() {
        return `<svg class="animate-spin w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
        </svg>`;
    }

    function iconPen() {
        return `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
        </svg>`;
    }

    // Auto-restore
    document.addEventListener('DOMContentLoaded', () => {
        @foreach($buku->bab as $bab)
        (function() {
            const idBab  = {{ $bab->id_bab }};
            const cached = loadFromCache(idBab);
            if (cached && cached.html) {
                renderCached(idBab, cached);
            }
        })();
        @endforeach
    });

    // Clear cache
    function clearCache(idBab, triggerBtn) {
        try { localStorage.removeItem(cacheKey(idBab)); } catch(e) {}

        const resultWrapper = document.getElementById('notes-result-' + idBab);
        const resultBox     = resultWrapper.querySelector('.notes-content');
        resultBox.innerHTML = '';
        resultWrapper.classList.add('hidden');

        // trigger
        const btn = document.getElementById('notes-btn-' + idBab);
        if (btn) generateNotes(idBab, btn);
    }

    // Generate
    function generateNotes(idBab, btn) {
        const resultWrapper = document.getElementById('notes-result-' + idBab);
        const resultBox     = resultWrapper.querySelector('.notes-content');

        btn.disabled = true;
        btn.innerHTML = iconSpinner() + ' Sedang membuat...';

        resultWrapper.classList.remove('hidden');
        resultBox.innerHTML = '<span class="text-slate-400 italic text-xs">✨ AI sedang menyusun ringkasan...</span>';

        fetch(`/user/buku/${BUKU_ID}/notes-ai`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ id_bab: idBab })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const html = formatRingkasan(data.ringkasan);
                saveToCache(idBab, html);
                const ts = new Date().toLocaleString('id-ID', {
                    day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit'
                });
                resultBox.innerHTML =
                    `<div class="flex items-center justify-between mb-2 pb-2 border-b border-orange-100">
                        <span class="text-[10px] text-orange-400 font-semibold uppercase tracking-wide">
                            ✨ Disimpan ${ts}
                        </span>
                        <button onclick="clearCache(${idBab}, this)"
                                class="text-[10px] text-slate-400 hover:text-red-400 transition-colors font-medium">
                            Buat ulang
                        </button>
                    </div>` + html;
            } else {
                resultBox.innerHTML = `<span class="text-red-500 text-xs">${data.message ?? 'Gagal membuat ringkasan.'}</span>`;
            }
            btn.disabled = false;
            btn.innerHTML = iconPen() + ' Notes AI';
        })
        .catch(() => {
            resultBox.innerHTML = '<span class="text-red-500 text-xs">Gagal menghubungi server. Periksa koneksi internet.</span>';
            btn.disabled = false;
            btn.innerHTML = iconPen() + ' Notes AI';
        });
    }
</script>
</body>
</html>
