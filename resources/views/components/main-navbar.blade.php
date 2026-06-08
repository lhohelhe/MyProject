<header class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between w-full px-8 py-3 bg-white border-b-2 border-black" id="main-navbar">
    <a href="/" data-turbo="true" class="flex items-center">
        <span class="px-3 py-1 text-xl font-black tracking-tight text-black border-2 border-black">SahabatBuku</span>
    </a>

    <div class="flex items-center gap-3">
        <a href="{{ route('login') }}"
           data-turbo="true"
           class="px-5 py-2 text-sm font-bold text-black transition-colors duration-150 bg-white border-2 border-black rounded-xl hover:bg-black hover:text-white">
            Masuk
        </a>
        <a href="{{ route('register') }}"
           data-turbo="true"
           class="border-2 border-black bg-[#F4922A] text-black font-bold text-sm px-5 py-2 rounded-xl hover:bg-black hover:text-white hover:border-black transition-colors duration-150">
            Daftar Gratis
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
