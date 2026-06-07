<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ringkasan {{ $bab->judul_bab }} — SahabatBuku</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Merriweather:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ===== LAYOUT ===== */
        .page-wrapper { display: flex; min-height: 100vh; background: #E5F8FF; }
        .content-area { flex: 1; display: flex; gap: 0; overflow: hidden; }
        .main-scroll  { flex: 1; overflow-y: auto; padding: 2rem 2rem 4rem 2rem; max-width: 820px; }
        .toc-panel    { width: 260px; flex-shrink: 0; padding: 2rem 1rem 2rem 0; }
        .toc-sticky   { position: sticky; top: 2rem; background: white; border-radius: 1rem;
                        border: 1px solid #e2e8f0; padding: 1.25rem; max-height: calc(100vh - 4rem); overflow-y: auto; }

        /* ===== FADE IN ===== */
        .fade-in { animation: fadeIn 0.45s ease both; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
        .fade-in:nth-child(2) { animation-delay:.05s; }
        .fade-in:nth-child(3) { animation-delay:.10s; }
        .fade-in:nth-child(4) { animation-delay:.15s; }

        /* ===== BAB HEADER CARD ===== */
        .bab-hero {
            background: linear-gradient(135deg, #fff7ed 0%, #fff 60%);
            border: 1px solid #fed7aa;
            border-radius: 1.25rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        /* ===== SUBBAB SECTION ===== */
        .subbab-block {
            background: white;
            border-radius: 1.25rem;
            border: 1px solid #e2e8f0;
            margin-bottom: 1.5rem;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }
        .subbab-header {
            background: linear-gradient(90deg, #fff7ed, #fff);
            border-bottom: 2px solid #fed7aa;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: .75rem;
        }
        .subbab-number {
            width: 2rem; height: 2rem;
            background: #F4922A; color: white;
            border-radius: .5rem;
            font-size: .75rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .subbab-title {
            font-size: .9375rem;
            font-weight: 700;
            color: #1e293b;
        }

        /* ===== MATERI BLOCK ===== */
        .materi-block {
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem 1.5rem;
        }
        .materi-block:last-child { border-bottom: none; }

        .materi-label {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .7rem;
            font-weight: 700;
            color: #F4922A;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: .5rem;
        }
        .materi-title {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: .875rem;
            padding-bottom: .5rem;
            border-bottom: 1px dashed #e2e8f0;
        }

        /* ===== PROSE (rendered HTML from DB) ===== */
        .materi-prose {
            font-size: .875rem;
            color: #374151;
            line-height: 1.8;
        }
        .materi-prose h1,.materi-prose h2 {
            font-size: 1rem; font-weight: 700; color: #1e293b;
            margin: 1.25rem 0 .5rem; border-left: 3px solid #F4922A; padding-left: .6rem;
        }
        .materi-prose h3,.materi-prose h4 {
            font-size: .9375rem; font-weight: 700; color: #334155;
            margin: 1rem 0 .375rem;
        }
        .materi-prose p { margin-bottom: .75rem; }
        .materi-prose ul {
            list-style: none; padding: 0; margin: .5rem 0 .875rem;
        }
        .materi-prose ul li {
            position: relative;
            padding-left: 1.25rem;
            margin-bottom: .375rem;
            color: #374151;
        }
        .materi-prose ul li::before {
            content: "•";
            position: absolute; left: 0;
            color: #F4922A; font-weight: 700;
        }
        .materi-prose ol {
            padding-left: 1.5rem; margin: .5rem 0 .875rem;
            list-style-type: decimal;
        }
        .materi-prose ol li { margin-bottom: .375rem; }
        .materi-prose table {
            width: 100%; border-collapse: collapse;
            margin: .875rem 0; font-size: .8125rem;
            border-radius: .5rem; overflow: hidden;
        }
        .materi-prose th {
            background: #fff7ed; color: #c2410c;
            font-weight: 700; padding: .5rem .75rem; text-align: left;
            border: 1px solid #fed7aa;
        }
        .materi-prose td {
            padding: .5rem .75rem;
            border: 1px solid #e2e8f0; color: #374151;
        }
        .materi-prose tr:nth-child(even) td { background: #fafafa; }
        .materi-prose blockquote {
            border-left: 3px solid #F4922A;
            background: #fff7ed;
            padding: .75rem 1rem;
            border-radius: 0 .5rem .5rem 0;
            margin: .875rem 0;
            font-style: italic; color: #78350f;
        }
        .materi-prose strong { font-weight: 700; color: #0f172a; }
        .materi-prose em { font-style: italic; color: #475569; }
        .materi-prose img {
            max-width: 100%; border-radius: .625rem;
            margin: .75rem 0; box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }
        .materi-prose a { color: #ea580c; text-decoration: underline; }
        .materi-prose code {
            background: #f1f5f9; padding: .1em .35em;
            border-radius: .25rem; font-size: .8125rem; color: #dc2626;
        }

        /* ===== TOC ===== */
        .toc-title { font-size: .7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: .08em; margin-bottom: .75rem; }
        .toc-link {
            display: flex; align-items: flex-start; gap: .5rem;
            padding: .375rem .5rem; border-radius: .5rem;
            font-size: .75rem; color: #64748b; font-weight: 500;
            text-decoration: none; margin-bottom: .125rem;
            transition: background .15s, color .15s;
            cursor: pointer; border: none; background: transparent; width: 100%; text-align: left;
        }
        .toc-link:hover { background: #fff7ed; color: #ea580c; }
        .toc-link.active { background: #fff7ed; color: #F4922A; font-weight: 700; }
        .toc-dot {
            width: 1.25rem; height: 1.25rem; border-radius: .3rem;
            background: #f1f5f9; color: #94a3b8;
            font-size: .625rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            margin-top: .05rem;
        }
        .toc-link.active .toc-dot { background: #F4922A; color: white; }

        /* ===== PRINT ===== */
        @media print {
            .toc-panel, x-user-sidebar, nav { display: none !important; }
            .main-scroll { max-width: 100%; padding: 0; }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .toc-panel { display: none; }
        }
    </style>
</head>
<body class="antialiased bg-[#E5F8FF]">
<div class="page-wrapper">

    <x-user-sidebar />

    <div class="content-area flex-1 overflow-hidden flex">

        {{-- ===== MAIN CONTENT ===== --}}
        <div class="main-scroll" id="mainScroll">

            {{-- Back button --}}
            <a href="{{ route('user.buku.show', $buku->id_buku) }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-[#F4922A] transition-colors group mb-4 fade-in">
                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform"></i>
                Kembali ke {{ $buku->judul_buku }}
            </a>

            {{-- BAB HERO HEADER --}}
            <div class="bab-hero fade-in">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-xl bg-[#F4922A] flex items-center justify-center flex-shrink-0 shadow-md">
                        <i data-lucide="book-open-text" class="w-7 h-7 text-white"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-bold text-orange-400 uppercase tracking-widest mb-1">
                            Ringkasan Materi · {{ $buku->judul_buku }}
                        </p>
                        <h1 class="text-xl font-extrabold text-slate-800 leading-tight mb-2">
                            {{ $bab->judul_bab }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-3 mt-2">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-orange-600 bg-orange-100 px-3 py-1 rounded-full">
                                <i data-lucide="layers" class="w-3 h-3"></i>
                                {{ $subbabList->count() }} Sub-Bab
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                                <i data-lucide="file-text" class="w-3 h-3"></i>
                                {{ $subbabList->sum(fn($s) => $s->materi->count()) }} Materi
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== SUBBAB LOOP ===== --}}
            @forelse($subbabList as $si => $subbab)

            <div class="subbab-block fade-in" id="subbab-{{ $subbab->id_subbab }}">

                {{-- Subbab Header --}}
                <div class="subbab-header">
                    <div class="subbab-number">{{ $si + 1 }}</div>
                    <h2 class="subbab-title">{{ $subbab->judul_subbab }}</h2>
                </div>

                {{-- Materi Loop --}}
                @forelse($subbab->materi as $mi => $materi)
                <div class="materi-block" id="materi-{{ $materi->id_materi }}">

                    {{-- Materi label --}}
                    <div class="materi-label">
                        <i data-lucide="file-text" style="width:10px;height:10px;"></i>
                        Materi {{ $mi + 1 }}
                    </div>

                    {{-- Materi title --}}
                    <h3 class="materi-title">{{ $materi->judul_materi }}</h3>

                    {{-- Materi content: plain text split into paragraphs --}}
                    <div class="materi-prose">
                        @php
                            $paragraphs = preg_split('/\n{2,}/', trim($materi->isi ?? ''));
                        @endphp
                        @foreach($paragraphs as $para)
                            @if(trim($para))
                                <p class="text-slate-700 text-sm leading-relaxed mb-4">
                                    {!! nl2br(e(trim($para))) !!}
                                </p>
                            @endif
                        @endforeach
                    </div>

                </div>
                @empty
                <div class="materi-block">
                    <p class="text-sm text-slate-400 italic">Belum ada materi di subbab ini.</p>
                </div>
                @endforelse

            </div>

            @empty

            {{-- Empty state --}}
            <div class="bg-white rounded-2xl p-14 text-center border border-slate-100 fade-in">
                <i data-lucide="inbox" class="w-14 h-14 text-slate-200 mx-auto mb-4"></i>
                <p class="text-slate-500 font-bold text-base">Belum ada materi di bab ini</p>
                <p class="text-slate-300 text-sm mt-1">Materi akan muncul setelah ditambahkan oleh admin.</p>
            </div>

            @endforelse

            {{-- Footer note --}}
            @if($subbabList->isNotEmpty())
            <div class="mt-4 p-4 bg-white rounded-xl border border-slate-100 flex items-center gap-3 text-xs text-slate-400">
                <i data-lucide="info" class="w-4 h-4 text-slate-300 flex-shrink-0"></i>
                Ringkasan ini menampilkan seluruh materi Bab <strong class="text-slate-600">{{ $bab->judul_bab }}</strong>
                dari buku <strong class="text-slate-600">{{ $buku->judul_buku }}</strong>.
            </div>
            @endif

        </div>

        {{-- ===== TABLE OF CONTENTS ===== --}}
        @if($subbabList->isNotEmpty())
        <div class="toc-panel">
            <div class="toc-sticky">
                <p class="toc-title">Daftar Isi Bab</p>

                @foreach($subbabList as $si => $subbab)
                <button class="toc-link" onclick="scrollToSubbab('subbab-{{ $subbab->id_subbab }}')"
                        data-target="subbab-{{ $subbab->id_subbab }}">
                    <span class="toc-dot">{{ $si + 1 }}</span>
                    <span class="leading-tight">{{ $subbab->judul_subbab }}</span>
                </button>
                @endforeach

                {{-- Print button --}}
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <button onclick="window.print()"
                            class="w-full flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-500 text-xs font-semibold transition-colors">
                        <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                        Cetak / Simpan PDF
                    </button>
                </div>
            </div>
        </div>
        @endif

    </div>{{-- end content-area --}}

</div>{{-- end page-wrapper --}}

<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();

    // Smooth scroll to subbab
    function scrollToSubbab(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        // highlight active TOC link
        document.querySelectorAll('.toc-link').forEach(l => l.classList.remove('active'));
        const btn = document.querySelector(`[data-target="${id}"]`);
        if (btn) btn.classList.add('active');
    }

    // Highlight TOC on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.id;
                document.querySelectorAll('.toc-link').forEach(l => l.classList.remove('active'));
                const active = document.querySelector(`[data-target="${id}"]`);
                if (active) active.classList.add('active');
            }
        });
    }, { rootMargin: '-20% 0px -70% 0px' });

    document.querySelectorAll('.subbab-block').forEach(el => observer.observe(el));
</script>
</body>
</html>
