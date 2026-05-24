<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SahabatBuku - Belajar dari Buku Resmi Kemendikdasmen</title>
    <script type="module">
        import hotwireturbo from 'https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/dist/turbo.es2017.esm.js';
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        html { scroll-behavior: smooth; }

        /* Marquee */
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .marquee-inner {
            display: inline-flex;
            animation: marquee 20s linear infinite;
            white-space: nowrap;
        }

        /* Card hover */
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.08);
        }

        /* Fade up on scroll */
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Turbo transition */
        [data-turbo-body] {
            opacity: 1;
            transition: opacity 0.2s ease;
        }
        html.turbo-loading [data-turbo-body] {
            opacity: 0;
        }
    </style>
</head>
<body class="overflow-x-hidden antialiased bg-white">

<x-main-navbar />

<div data-turbo-body>

{{-- ===== HERO ===== --}}
<section class="bg-[#E5F8FF] pt-32 pb-24 px-6 lg:px-8">
    <div class="grid items-center max-w-6xl grid-cols-1 gap-16 mx-auto lg:grid-cols-2">

        {{-- Left --}}
        <div class="space-y-8">

            <h1 class="text-5xl lg:text-6xl font-extrabold text-slate-900 leading-[1.08] tracking-tight">
                Belajar Langsung<br>
                dari Buku Resmi<br>
                <span class="text-[#F4922A]">Kemendikdasmen</span>
            </h1>

            <p class="max-w-sm text-lg leading-relaxed text-slate-500">
                Pendamping belajar menuju ujian.
            </p>

            <div class="flex items-center gap-4">
                <a href="{{ route('register') }}" data-turbo="true"
                   class="bg-[#F4922A] text-white font-bold text-sm px-7 py-3.5 rounded-xl hover:bg-orange-600 transition-colors shadow-md shadow-orange-200">
                    Mulai Belajar Gratis
                </a>
                <a href="#features"
                   class="text-slate-600 font-semibold text-sm hover:text-[#F4922A] transition-colors">
                    Lihat Fitur →
                </a>
            </div>

            <div class="flex flex-wrap items-center gap-5 pt-1">
                @foreach(['100% Buku Resmi', 'Gratis untuk semua siswa', 'Kelas 10–12'] as $item)
                <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                    <div class="w-4 h-4 rounded-full bg-[#F4922A]/15 flex items-center justify-center flex-shrink-0">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#F4922A]"></div>
                    </div>
                    {{ $item }}
                </div>
                @endforeach
            </div>
        </div>

        {{-- Right --}}
        <div class="relative">
            <div class="absolute inset-0 bg-[#1E3A5F]/6 rounded-3xl rotate-1"></div>
            <img src="{{ asset('images/hero_student.png') }}"
                 class="relative z-10 w-full h-[460px] lg:h-[520px] object-cover rounded-3xl shadow-xl"
                 alt="Siswa SMA belajar bersama">

            {{-- Two clean info cards --}}
            <div class="absolute z-20 px-4 py-3 bg-white border shadow-lg -left-5 top-10 rounded-2xl border-slate-100">
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider mb-1">Sumber</p>
                <p class="text-sm font-bold text-slate-800">Berbasis Kurikulum Resmi</p>
            </div>

            <div class="absolute -right-5 bottom-10 z-20 bg-[#1E3A5F] rounded-2xl px-4 py-3 shadow-lg">
                <p class="text-[10px] text-blue-300 font-semibold uppercase tracking-wider mb-1">Gamifikasi</p>
                <p class="text-sm font-bold text-white">XP & Level System</p>
            </div>
        </div>

    </div>
</section>

{{-- ===== STATS BAR ===== --}}
<section class="bg-[#1E3A5F] py-10 px-6">
    <div class="grid max-w-4xl grid-cols-2 gap-8 mx-auto text-center lg:grid-cols-4">
        @foreach([
            ['4+', 'Fitur Belajar'],
            ['100%', 'Buku Resmi'],
            ['3', 'Kelas (X–XII)'],
            ['∞', 'Akses Gratis'],
        ] as [$num, $label])
        <div class="space-y-1.5">
            <p class="text-4xl font-extrabold text-white">{{ $num }}</p>
            <p class="text-xs font-semibold tracking-widest text-blue-300 uppercase">{{ $label }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ===== FEATURES ===== --}}
<section id="features" class="px-6 py-24 bg-white lg:px-8">
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="mb-14 fade-up">
            <h2 class="text-4xl font-extrabold tracking-tight text-slate-900">Nikmati Keragaman Fitur</h2>
            <p class="max-w-md mt-3 text-base leading-relaxed text-slate-500">
                Semua yang kamu butuhkan untuk belajar terarah ada di sini.
            </p>
        </div>

        {{-- Bento Grid --}}
        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

            {{-- Card 1: Flashcard - light --}}
            <div class="card-hover fade-up bg-[#E5F8FF] rounded-2xl p-7 flex flex-col justify-between min-h-[280px]">
                <div>
                    <div class="w-11 h-11 rounded-xl bg-[#F4922A] flex items-center justify-center mb-5 shadow-sm shadow-orange-200">
                        <i data-lucide="book-marked" class="w-5 h-5 text-white"></i>
                    </div>
                    <p class="text-[#F4922A] text-[10px] font-bold uppercase tracking-widest mb-2">01</p>
                    <h3 class="mb-2 text-lg font-extrabold text-slate-800">Flashcard</h3>
                    <p class="text-sm leading-relaxed text-slate-500">
                        Istilah dan konsep penting dari materi buku tematik dibuat menjadi kartu belajar dua sisi.
                    </p>
                </div>
                <p class="text-[#F4922A] text-xs font-semibold mt-5">Otomatis dari konten buku →</p>
            </div>

            {{-- Card 2: Quiz - dark --}}
            <div class="card-hover fade-up md:col-span-2 bg-[#1E3A5F] rounded-2xl p-7 flex flex-col justify-between min-h-[280px]">
                <div>
                    <div class="flex items-center justify-center mb-5 w-11 h-11 rounded-xl bg-white/15">
                        <i data-lucide="clipboard-list" class="w-5 h-5 text-white"></i>
                    </div>
                    <p class="text-blue-300 text-[10px] font-bold uppercase tracking-widest mb-2">02</p>
                    <h3 class="mb-2 text-lg font-extrabold text-white">Quiz Interaktif</h3>
                    <p class="max-w-md text-sm leading-relaxed text-blue-200">
                        Latihan soal dari bank soal yang dikurasi per bab buku. Feedback langsung setelah menjawab untuk memperkuat pemahaman.
                    </p>
                </div>
                <p class="mt-5 text-xs font-semibold text-blue-300">Adaptive difficulty system →</p>
            </div>

            {{-- Card 3: Notes AI - dark --}}
            <div class="card-hover fade-up md:col-span-2 bg-[#1E3A5F] rounded-2xl p-7 flex flex-col justify-between min-h-[280px]">
                <div>
                    <div class="flex items-center justify-center mb-5 w-11 h-11 rounded-xl bg-white/15">
                        <i data-lucide="notebook-pen" class="w-5 h-5 text-white"></i>
                    </div>
                    <p class="text-blue-300 text-[10px] font-bold uppercase tracking-widest mb-2">03</p>
                    <h3 class="mb-2 text-lg font-extrabold text-white">Notes AI</h3>
                    <p class="max-w-md text-sm leading-relaxed text-blue-200">
                        Ringkasan poin inti dari buku dengan AI. Singkat, padat, dan mudah dicerna. Dilengkapi catatan manual pribadi siswa.
                    </p>
                </div>
                <p class="mt-5 text-xs font-semibold text-blue-300">Catatan manual + AI summarizer →</p>
            </div>

            {{-- Card 4: Simulasi - orange --}}
            <div class="card-hover fade-up bg-[#F4922A] rounded-2xl p-7 flex flex-col justify-between min-h-[280px]">
                <div>
                    <div class="flex items-center justify-center mb-5 w-11 h-11 rounded-xl bg-white/20">
                        <i data-lucide="timer" class="w-5 h-5 text-white"></i>
                    </div>
                    <p class="text-orange-100 text-[10px] font-bold uppercase tracking-widest mb-2">04</p>
                    <h3 class="mb-2 text-lg font-extrabold text-white">Ujian Simulasi</h3>
                    <p class="text-sm leading-relaxed text-orange-100">
                        Ujian multi bab bertimer dengan analisis performa. Siap PTS, PAS, dan UTBK.
                    </p>
                </div>
                <p class="mt-5 text-xs font-semibold text-white">Multi bab · Bertimer · Analisis →</p>
            </div>

        </div>
    </div>
</section>

{{-- ===== CTA BANNER ===== --}}
<section class="px-6 py-16 lg:px-8">
    <div class="max-w-6xl mx-auto bg-[#1E3A5F] rounded-3xl p-10 lg:p-14 flex flex-col lg:flex-row items-center justify-between gap-8">
        <div>
            <p class="text-[#F4922A] text-xs font-bold uppercase tracking-widest mb-3">Bergabung Sekarang</p>
            <h2 class="text-3xl font-extrabold leading-tight text-white">Siap Belajar Lebih Terarah?</h2>
            <p class="max-w-md mt-3 text-sm leading-relaxed text-blue-200">
                Mulai perjalanan belajarmu dari buku resmi Kemendikdasmen. Gratis untuk semua siswa SMA.
            </p>
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('register') }}" data-turbo="true"
               class="inline-block bg-[#F4922A] text-white font-bold text-sm px-8 py-4 rounded-xl hover:bg-orange-600 transition-colors shadow-lg shadow-orange-900/20">
                Daftar Sekarang
            </a>
        </div>
    </div>
</section>

{{-- ===== FOOTER ===== --}}
<footer class="bg-[#1E3A5F] py-14 px-6 lg:px-8">
    <div class="grid items-center max-w-6xl grid-cols-1 gap-12 mx-auto lg:grid-cols-2">

        {{-- Left --}}
        <div>
            <img src="{{ asset('images/logo_2.png') }}" class="h-8 mb-3" alt="SahabatBuku">
            <p class="text-[#F4922A] text-sm font-semibold mb-6">Belajar di mana pun, kapanpun!</p>
            <div class="w-32 h-px mb-6 bg-slate-600"></div>
            <nav class="flex flex-wrap gap-5">
                @foreach(['About', 'Menu', 'Services', 'FAQ', 'Support'] as $link)
                <a href="#" class="text-slate-400 hover:text-[#F4922A] text-sm font-medium transition-colors">{{ $link }}</a>
                @endforeach
            </nav>
        </div>

        {{-- Right: Saran --}}
        <div class="overflow-hidden bg-white shadow-lg rounded-2xl">
            <div class="bg-[#F4922A] px-5 py-3 flex items-center gap-2">
                <i data-lucide="bookmark" class="flex-shrink-0 w-4 h-4 text-white"></i>
                <p class="text-sm font-semibold text-white">Beri saran agar kami semakin berkembang!</p>
            </div>
            <div class="px-5 py-5">
                <p class="mb-4 text-sm font-bold text-slate-800">Kirimkan saran lewat sini!</p>

                @if(session('saran_success'))
                <div class="flex items-center gap-2 px-4 py-3 mb-4 text-xs text-green-700 border border-green-200 bg-green-50 rounded-xl">
                    <i data-lucide="check-circle" class="flex-shrink-0 w-4 h-4"></i>
                    {{ session('saran_success') }}
                </div>
                @endif

                <form action="{{ route('saran.store') }}" method="POST" data-turbo="false">
                    @csrf
                    <div class="flex gap-2">
                        <input type="text" name="isi" required
                               placeholder="Tulis saranmu di sini..."
                               class="flex-1 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#F4922A] transition-colors">
                        <button type="submit" id="saran-btn"
                                class="bg-[#F4922A] hover:bg-orange-600 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-colors flex-shrink-0 min-w-[80px]">
                            Submit
                        </button>
                    </div>
                    @error('isi')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>

    </div>
</footer>

{{-- Copyright --}}
<div class="py-4 text-center bg-white border-t border-slate-100">
    <p class="text-xs text-slate-400">© 2026 SahabatBuku.</p>
</div>

</div>{{-- end data-turbo-body --}}

{{-- Scripts --}}
<script>
    function initLucide() {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }
    initLucide();
    document.addEventListener('turbo:render', initLucide);
</script>

<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => entry.target.classList.add('visible'), i * 100);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/TextPlugin.min.js"></script>
<script>
gsap.registerPlugin(TextPlugin);

const saranBtn = document.getElementById('saran-btn');
const saranForm = saranBtn ? saranBtn.closest('form') : null;

if (saranBtn && saranForm) {
    const btnTL = gsap.timeline({ paused: true })
        .to(saranBtn, { duration: 0.7, text: { value: 'Mengirim...', type: 'diff' }, ease: 'sine.in' })
        .to(saranBtn, { duration: 0.35, text: { value: 'Mengirim', type: 'diff' }, ease: 'sine.inOut', repeat: 3, yoyo: true })
        .to(saranBtn, {
            text: 'Terkirim! 🙏',
            ease: 'none',
            onComplete: () => { saranBtn.disabled = false; saranForm.submit(); }
        }, '+=0.3');

    saranForm.addEventListener('submit', function(e) {
        const input = saranForm.querySelector('input[name="isi"]');
        if (!input || !input.value.trim()) return;
        e.preventDefault();
        saranBtn.disabled = true;
        btnTL.play(0);
    });
}
</script>

</body>
</html>