{{-- sidebar user — dipakai di semua halaman user --}}
<aside class="w-[260px] h-screen sticky top-0 flex flex-col py-6 px-5 flex-shrink-0 bg-white/20 backdrop-blur-md border-r border-white/20 overflow-y-auto">

    {{-- logo --}}
    <img src="{{ asset('images/logo_1.png') }}" alt="SahabatBuku" class="h-8 self-start">

    {{-- xp & level section --}}
    @php
        use App\Services\XpService;
        $user = Auth::user();
        $currentLevel = $user->level;
        $progress = XpService::getProgressToNextLevel($user);
        $currentXp = XpService::getXpInCurrentLevel($user);
        $xpForNext = XpService::getXpForNextLevel($user);
    @endphp
    <div class="p-4 mt-6 text-white rounded-2xl bg-gradient-to-r from-orange-400 to-[#F4922A] shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <div>
                <div class="text-[10px] font-medium opacity-90 uppercase tracking-wider">Level</div>
                <div class="text-xl font-bold">{{ $currentLevel }}</div>
            </div>
            <div class="text-right">
                <div class="text-[10px] font-medium opacity-90 uppercase tracking-wider">XP</div>
                <div class="text-lg font-bold">{{ $user->total_xp }}</div>
            </div>
        </div>

        {{-- progress bar --}}
        <div class="mb-1">
            <div class="w-full h-1.5 rounded-full bg-white/30">
                <div class="h-1.5 transition-all duration-300 bg-white rounded-full" style="width: {{ $progress }}%"></div>
            </div>
        </div>
        <div class="text-[10px] opacity-90 text-right">{{ $currentXp }} / {{ $xpForNext }} XP</div>
    </div>

    {{-- navigasi --}}
    <nav class="flex flex-col gap-1 mt-8 flex-1">

        {{-- katalog --}}
        <a href="{{ route('user.katalog') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('user.katalog') ? 'text-[#F4922A] bg-white/40' : 'text-slate-700 hover:text-[#F4922A] hover:bg-white/20' }}">
            <i data-lucide="book-open" class="w-4 h-4"></i>
            <span>Katalog</span>
        </a>

        {{-- kategori --}}
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-3 px-4 py-2 text-sm font-medium text-slate-700">
                <i data-lucide="grid-3x3" class="w-4 h-4"></i>
                <span>Kategori</span>
            </div>
            <div class="flex flex-col gap-1 border-l-2 border-orange-200 pl-3 ml-6 my-1">
                @php $kategori = \App\Models\KategoriMapel::all(); @endphp
                @foreach($kategori as $k)
                    <a href="{{ route('user.katalog', ['kategori' => $k->id_kategori]) }}" class="px-2 py-1 rounded-lg text-xs font-medium text-slate-600 hover:text-[#F4922A] hover:bg-white/20 transition-all">
                        {{ $k->nama_kategori }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- profil --}}
        <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('user.profile') ? 'text-[#F4922A] bg-white/40' : 'text-slate-700 hover:text-[#F4922A] hover:bg-white/20' }}">
            <i data-lucide="user" class="w-4 h-4"></i>
            <span>Profil</span>
        </a>

    </nav>

    {{-- tombol bawah: keluar --}}
    <div class="mt-auto pt-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50/50 hover:text-red-600 transition-all">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>

</aside>

<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>