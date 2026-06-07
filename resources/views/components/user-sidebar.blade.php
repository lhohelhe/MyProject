{{-- sidebar user — dipakai di semua halaman user --}}
<aside class="w-[260px] h-screen sticky top-0 flex flex-col py-6 px-5 flex-shrink-0 bg-white border-r-2 border-black overflow-y-auto">

    {{-- logo --}}
    <div class="border-b-2 border-black/20 pb-4 w-full flex justify-start mb-6">
        <img src="{{ asset('images/logo_1.png') }}" alt="SahabatBuku" class="h-8">
    </div>

    {{-- xp & level section --}}
    @php
        use App\Services\XpService;
        $user = Auth::user();
        $currentLevel = $user->level;
        $progress = XpService::getProgressToNextLevel($user);
        $currentXp = XpService::getXpInCurrentLevel($user);
        $xpForNext = XpService::getXpForNextLevel($user);
    @endphp
    <div class="p-4 text-black border-2 border-black bg-[#F4922A] shadow-[4px_4px_0px_#000] rounded-xl mb-6">
        <div class="flex items-center justify-between mb-2">
            <div>
                <div class="text-[10px] font-black uppercase tracking-wider text-black">Level</div>
                <div class="text-xl font-black text-black leading-none">{{ $currentLevel }}</div>
            </div>
            <div class="text-right">
                <div class="text-[10px] font-black uppercase tracking-wider text-black">XP</div>
                <div class="text-lg font-black text-black leading-none">{{ $user->total_xp }}</div>
            </div>
        </div>

        {{-- progress bar --}}
        <div class="mb-1">
            <div class="w-full h-2.5 border-2 border-black bg-white rounded-full overflow-hidden">
                <div class="h-full transition-all duration-300 bg-black rounded-full" style="width: {{ $progress }}%"></div>
            </div>
        </div>
        <div class="text-[10px] font-black text-black text-right mt-1">{{ $currentXp }} / {{ $xpForNext }} XP</div>
    </div>

    {{-- navigasi --}}
    <nav class="flex flex-col gap-2 flex-1">

        {{-- katalog --}}
        <a href="{{ route('user.katalog') }}" class="flex items-center gap-3 px-4 py-2 transition-all rounded-xl {{ request()->routeIs('user.katalog') ? 'bg-[#F4922A] text-white border-2 border-black shadow-[2px_2px_0px_#000] font-black text-sm' : 'text-black font-bold border-2 border-transparent hover:border-black hover:bg-white/40 text-sm' }}">
            <i data-lucide="book-open" class="w-4 h-4"></i>
            <span>Katalog</span>
        </a>

        {{-- kategori --}}
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-3 px-4 py-2 text-sm font-black text-black uppercase tracking-wider">
                <i data-lucide="grid-3x3" class="w-4 h-4"></i>
                <span>Kategori</span>
            </div>
            <div class="flex flex-col gap-1 border-l-2 border-black pl-3 ml-6 my-1">
                @php $kategori = \App\Models\KategoriMapel::all(); @endphp
                @foreach($kategori as $k)
                    <a href="{{ route('user.katalog', ['kategori' => $k->id_kategori]) }}" class="px-2 py-1 rounded-xl text-xs font-bold text-black border border-transparent hover:border-black hover:bg-white/40 transition-all">
                        {{ $k->nama_kategori }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- profil --}}
        <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-4 py-2 transition-all rounded-xl {{ request()->routeIs('user.profile') ? 'bg-[#F4922A] text-white border-2 border-black shadow-[2px_2px_0px_#000] font-black text-sm' : 'text-black font-bold border-2 border-transparent hover:border-black hover:bg-white/40 text-sm' }}">
            <i data-lucide="user" class="w-4 h-4"></i>
            <span>Profil</span>
        </a>

    </nav>

    {{-- tombol bawah: keluar --}}
    <div class="mt-auto pt-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-bold text-red-600 border-2 border-black bg-white hover:bg-red-50 hover:shadow-[2px_2px_0px_#000] transition-all">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>

</aside>

<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>