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

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .marquee-inner {
            display: inline-flex;
            animation: marquee 20s linear infinite;
            white-space: nowrap;
        }

        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        [data-turbo-body] {
            opacity: 1;
            transition: opacity 0.2s ease;
        }
        html.turbo-loading [data-turbo-body] {
            opacity: 0;
        }
    </style>
</head>
<body class="overflow-x-hidden antialiased bg-[#E5F8FF]">

<x-main-navbar />

<div data-turbo-body>

{{-- ===== HERO ===== --}}
<section class="bg-[#E5F8FF] pt-32 pb-24 px-6 lg:px-8">
    <div class="grid items-center max-w-6xl grid-cols-1 gap-16 mx-auto lg:grid-cols-2">

        {{-- Left --}}
        <div class="space-y-8">
            <div class="inline-block px-4 py-1.5 bg-[#F4922A] text-white text-xs font-black uppercase tracking-widest border-2 border-black rounded-full shadow-[3px_3px_0px_#000]">
                Platform Belajar Siswa SMA
            </div>

            <h1 class="text-5xl lg:text-6xl font-black text-black leading-[1.08] tracking-tight">
                Belajar Langsung<br>
                dari Buku Resmi<br>
                <span class="text-[#F4922A]">Kemendikdasmen</span>
            </h1>

            <p class="max-w-sm text-base font-bold text-slate-600">
                Pendamping belajar menuju ujian — lengkap dengan quiz, flashcard, simulasi, dan AI notes.
            </p>

            <div class="flex items-center gap-4">
                <a href="{{ route('register') }}" data-turbo="true"
                   class="bg-[#F4922A] text-white font-black text-sm px-7 py-3.5 rounded-xl border-2 border-black shadow-[4px_4px_0px_#000] hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all">
                    Mulai Belajar Gratis
                </a>
                <a href="{{ route('login') }}" data-turbo="true"
                   class="bg-white text-black font-black text-sm px-7 py-3.5 rounded-xl border-2 border-black shadow-[4px_4px_0px_#000] hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all">
                    Masuk
                </a>
            </div>

            <div class="flex flex-wrap items-center gap-4 pt-1">
                @foreach(['100% Buku Resmi', 'Gratis untuk semua siswa', 'Kelas 10–12'] as $item)
                <div class="flex items-center gap-2 px-3 py-1.5 bg-white border-2 border-black rounded-full shadow-[2px_2px_0px_#000] text-xs font-black text-black">
                    <div class="w-2 h-2 rounded-full bg-[#F4922A]"></div>
                    {{ $item }}
                </div>
                @endforeach
            </div>
        </div>

        {{-- Right --}}
        <div class="relative">
            <div class="absolute inset-0 bg-black rounded-3xl translate-x-2 translate-y-2"></div>
            <img src="{{ asset('images/kelas.jpeg') }}"
                 class="relative z-10 w-full h-[460px] lg:h-[520px] object-cover rounded-3xl border-2 border-black"
                 alt="Siswa SMA belajar bersama">

            {{-- Info cards --}}
            <div class="absolute z-20 px-4 py-3 bg-white border-2 border-black shadow-[3px_3px_0px_#000] -left-5 top-10 rounded-xl">
                <p class="text-[10px] text-slate-500 font-black uppercase tracking-wider mb-0.5">Sumber</p>
                <p class="text-sm font-black text-black">Berbasis Kurikulum Resmi</p>
            </div>

            <div class="absolute -right-5 bottom-10 z-20 bg-[#1E3A5F] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl px-4 py-3">
                <p class="text-[10px] text-blue-300 font-black uppercase tracking-wider mb-0.5">Gamifikasi</p>
                <p class="text-sm font-black text-white">XP & Level System</p>
            </div>
        </div>

    </div>
</section>

{{-- ===== MARQUEE ===== --}}
<div class="py-5 bg-[#F4922A] border-y-2 border-black overflow-hidden">
    <div class="marquee-inner">
        @foreach(array_fill(0, 8, ['Flashcard', 'Quiz Interaktif', 'Notes AI', 'Ujian Simulasi', 'XP & Level', 'Buku Resmi']) as $items)
            @foreach($items as $item)
            <span class="mx-6 text-white font-black text-sm uppercase tracking-widest">✦ {{ $item }}</span>
            @endforeach
        @endforeach
    </div>
</div>

{{-- ===== FEATURES ===== --}}
<section id="features" class="px-6 py-24 bg-[#E5F8FF] lg:px-8">
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="mb-12 fade-up">
            <p class="text-[#F4922A] text-xs font-black uppercase tracking-widest mb-3">Fitur Unggulan</p>
            <h2 class="text-4xl font-black tracking-tight text-black">Nikmati Keragaman Fitur</h2>
            <p class="max-w-md mt-3 text-sm font-bold leading-relaxed text-slate-600">
                Semua yang kamu butuhkan untuk belajar terarah ada di sini.
            </p>
        </div>

        {{-- Bento Grid --}}
        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

            {{-- Card 1: Flashcard --}}
            <div class="fade-up bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl p-6 flex flex-col justify-between min-h-[260px] hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all">
                <div>
                    <div class="w-11 h-11 rounded-xl bg-[#F4922A] border-2 border-black flex items-center justify-center mb-4 shadow-[2px_2px_0px_#000]">
                        <i data-lucide="book-marked" class="w-5 h-5 text-white"></i>
                    </div>
                    <p class="text-[#F4922A] text-[10px] font-black uppercase tracking-widest mb-2">01</p>
                    <h3 class="mb-2 text-lg font-black text-black">Flashcard</h3>
                    <p class="text-sm font-bold leading-relaxed text-slate-600">
                        Istilah dan konsep penting dari materi buku tematik dibuat menjadi kartu belajar dua sisi.
                    </p>
                </div>
                <p class="text-[#F4922A] text-xs font-black mt-5 uppercase tracking-wide">Otomatis dari konten buku →</p>
            </div>

            {{-- Card 2: Quiz --}}
            <div class="fade-up md:col-span-2 bg-[#1E3A5F] border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl p-6 flex flex-col justify-between min-h-[260px] hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all">
                <div>
                    <div class="flex items-center justify-center mb-4 w-11 h-11 rounded-xl bg-white/15 border-2 border-white/30">
                        <i data-lucide="clipboard-list" class="w-5 h-5 text-white"></i>
                    </div>
                    <p class="text-blue-300 text-[10px] font-black uppercase tracking-widest mb-2">02</p>
                    <h3 class="mb-2 text-lg font-black text-white">Quiz Interaktif</h3>
                    <p class="max-w-md text-sm font-bold leading-relaxed text-blue-200">
                        Latihan soal dari bank soal yang dikurasi per bab buku. Feedback langsung setelah menjawab untuk memperkuat pemahaman.
                    </p>
                </div>
                <p class="mt-5 text-xs font-black text-blue-300 uppercase tracking-wide">Adaptive difficulty system →</p>
            </div>

            {{-- Card 3: Notes AI --}}
            <div class="fade-up md:col-span-2 bg-[#1E3A5F] border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl p-6 flex flex-col justify-between min-h-[260px] hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all">
                <div>
                    <div class="flex items-center justify-center mb-4 w-11 h-11 rounded-xl bg-white/15 border-2 border-white/30">
                        <i data-lucide="notebook-pen" class="w-5 h-5 text-white"></i>
                    </div>
                    <p class="text-blue-300 text-[10px] font-black uppercase tracking-widest mb-2">03</p>
                    <h3 class="mb-2 text-lg font-black text-white">Notes AI</h3>
                    <p class="max-w-md text-sm font-bold leading-relaxed text-blue-200">
                        Ringkasan poin inti dari buku dengan AI. Singkat, padat, dan mudah dicerna.
                    </p>
                </div>
                <p class="mt-5 text-xs font-black text-blue-300 uppercase tracking-wide">Catatan manual + AI summarizer →</p>
            </div>

            {{-- Card 4: Simulasi --}}
            <div class="fade-up bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl p-6 flex flex-col justify-between min-h-[260px] hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all">
                <div>
                    <div class="w-11 h-11 rounded-xl bg-[#F4922A] border-2 border-black flex items-center justify-center mb-4 shadow-[2px_2px_0px_#000]">
                        <i data-lucide="timer" class="w-5 h-5 text-white"></i>
                    </div>
                    <p class="text-[#F4922A] text-[10px] font-black uppercase tracking-widest mb-2">04</p>
                    <h3 class="mb-2 text-lg font-black text-black">Ujian Simulasi</h3>
                    <p class="text-sm font-bold leading-relaxed text-slate-600">
                        Ujian multi bab bertimer dengan analisis performa. Siap PTS, PAS, dan UTBK.
                    </p>
                </div>
                <p class="mt-5 text-xs font-black text-[#F4922A] uppercase tracking-wide">Multi bab · Bertimer · Analisis →</p>
            </div>

        </div>
    </div>
</section>

{{-- ===== CTA BANNER ===== --}}
<section class="px-6 py-16 lg:px-8">
    <div class="max-w-6xl mx-auto bg-[#1E3A5F] border-2 border-black shadow-[6px_6px_0px_#000] rounded-xl p-10 lg:p-14 flex flex-col lg:flex-row items-center justify-between gap-8">
        <div>
            <p class="text-[#F4922A] text-xs font-black uppercase tracking-widest mb-3">Bergabung Sekarang</p>
            <h2 class="text-3xl font-black leading-tight text-white">Siap Belajar Lebih Terarah?</h2>
            <p class="max-w-md mt-3 text-sm font-bold leading-relaxed text-blue-200">
                Mulai perjalanan belajarmu dari buku resmi Kemendikdasmen. Gratis untuk semua siswa SMA.
            </p>
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('register') }}" data-turbo="true"
               class="inline-block bg-[#F4922A] text-white font-black text-sm px-8 py-4 rounded-xl border-2 border-black shadow-[4px_4px_0px_#000] hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all">
                Daftar Sekarang
            </a>
        </div>
    </div>
</section>

{{-- ===== FOOTER ===== --}}
<footer class="bg-[#1E3A5F] border-t-2 border-black py-14 px-6 lg:px-8">
    <div class="grid items-center max-w-6xl grid-cols-1 gap-12 mx-auto lg:grid-cols-2">

        {{-- Left --}}
        <div>
            <img src="{{ asset('images/logo_2.png') }}" class="h-8 mb-3" alt="SahabatBuku">
            <p class="text-[#F4922A] text-sm font-black mb-6">Belajar di mana pun, kapanpun!</p>
            <div class="w-32 h-0.5 mb-6 bg-slate-600"></div>
            <nav class="flex flex-wrap gap-4">
                @foreach(['About', 'Menu', 'Services', 'FAQ', 'Support'] as $link)
                <a href="#" class="text-slate-400 hover:text-[#F4922A] text-sm font-bold transition-colors">{{ $link }}</a>
                @endforeach
            </nav>
        </div>

        {{-- Right: Saran --}}
        <div class="overflow-hidden bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl">
            <div class="bg-[#F4922A] border-b-2 border-black px-5 py-3 flex items-center gap-2">
                <i data-lucide="bookmark" class="flex-shrink-0 w-4 h-4 text-white"></i>
                <p class="text-sm font-black text-white">Beri saran agar kami semakin berkembang!</p>
            </div>
            <div class="px-5 py-5">
                <p class="mb-4 text-sm font-black text-black">Kirimkan saran lewat sini!</p>

                @if(session('saran_success'))
                <div class="flex items-center gap-2 px-4 py-3 mb-4 text-xs font-bold text-green-700 border-2 border-black bg-green-50 rounded-xl">
                    <i data-lucide="check-circle" class="flex-shrink-0 w-4 h-4"></i>
                    {{ session('saran_success') }}
                </div>
                @endif

                <form action="{{ route('saran.store') }}" method="POST" data-turbo="false">
                    @csrf
                    <div class="flex gap-2">
                        <input type="text" name="isi" required
                               placeholder="Tulis saranmu di sini..."
                               class="flex-1 border-2 border-black rounded-xl px-4 py-2.5 text-sm font-bold text-black placeholder-slate-400 focus:outline-none focus:border-[#F4922A] transition-colors">
                        <button type="submit" id="saran-btn"
                                class="bg-[#F4922A] text-white text-sm font-black px-5 py-2.5 rounded-xl border-2 border-black shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all flex-shrink-0 min-w-[80px]">
                            Submit
                        </button>
                    </div>
                    @error('isi')
                    <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>

    </div>
</footer>

{{-- Copyright --}}
<div class="py-4 text-center bg-[#1E3A5F] border-t-2 border-black/30">
    <p class="text-xs font-bold text-slate-400">© 2026 SahabatBuku.</p>
</div>

</div>

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
            text: 'Terkirim!',
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
