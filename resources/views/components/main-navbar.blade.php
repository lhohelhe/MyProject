<header class="fixed top-0 left-0 right-0 z-50 w-full bg-white border-b-2 border-black py-3 px-8 flex items-center justify-between" id="main-navbar">
    <a href="/" data-turbo="true" class="flex items-center">
        <span class="font-black text-xl tracking-tight text-black border-2 border-black px-3 py-1">SahabatBuku</span>
    </a>

    {{-- Center tagline marquee (optional on mobile, hidden by default, flex on lg) --}}
    <div class="lg:flex hidden overflow-hidden w-64 border-l-2 border-r-2 border-black py-1">
        <div class="marquee-inner">
            <span class="text-[10px] font-bold uppercase tracking-widest text-black whitespace-nowrap">
                BELAJAR RESMI · SIAP UJIAN · XP & LEVEL · BELAJAR RESMI · SIAP UJIAN · XP & LEVEL · BELAJAR RESMI · SIAP UJIAN · XP & LEVEL · &nbsp;
            </span>
            <span class="text-[10px] font-bold uppercase tracking-widest text-black whitespace-nowrap">
                BELAJAR RESMI · SIAP UJIAN · XP & LEVEL · BELAJAR RESMI · SIAP UJIAN · XP & LEVEL · BELAJAR RESMI · SIAP UJIAN · XP & LEVEL · &nbsp;
            </span>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('login') }}"
           data-turbo="true"
           class="border-2 border-black bg-white text-black font-bold text-sm px-5 py-2 rounded-xl hover:bg-black hover:text-white transition-colors duration-150">
            Masuk
        </a>
        <a href="{{ route('register') }}"
           data-turbo="true"
           class="border-2 border-black bg-[#F4922A] text-black font-bold text-sm px-5 py-2 rounded-xl hover:bg-black hover:text-white hover:border-black transition-colors duration-150">
            ✦ Daftar Gratis
        </a>
    </div>
</header>

<style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .marquee-inner {
        display: inline-flex;
        animation: marquee 20s linear infinite;
        white-space: nowrap;
    }
</style>
