<!-- Admin Sidebar -->
<aside class="flex-shrink-0 w-full lg:w-60 lg:h-screen lg:sticky lg:top-0 bg-[#1E3A5F] flex flex-col overflow-y-auto">

    {{-- Logo --}}
    <div class="px-6 pt-7 pb-8 border-b border-white/10">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <div class="border-2 border-white/30 px-2.5 py-1">
                <span class="text-white font-black text-base tracking-tight leading-none">SahabatBuku</span>
            </div>
            <span class="text-[#F4922A] text-[10px] font-bold uppercase tracking-widest leading-none mt-0.5">Admin</span>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-4 py-6 space-y-1">

        {{-- Section label --}}
        <p class="text-white/30 text-[10px] font-bold uppercase tracking-widest px-3 mb-3">Utama</p>

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-none text-sm font-semibold transition-all border border-transparent
                  {{ request()->routeIs('admin.dashboard') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
            <i data-lucide="layout-dashboard" class="w-4 h-4 flex-shrink-0"></i>
            <span>Dashboard</span>
        </a>

        {{-- Data User --}}
        <a href="{{ route('dashboard-user.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-none text-sm font-semibold transition-all border border-transparent
                  {{ request()->routeIs('dashboard-user.*') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
            <i data-lucide="users" class="w-4 h-4 flex-shrink-0"></i>
            <span>Data User</span>
        </a>

        <div class="pt-4 pb-1">
            <p class="text-white/30 text-[10px] font-bold uppercase tracking-widest px-3 mb-3">Konten</p>
        </div>

        {{-- Data Buku --}}
        <a href="{{ route('dashboard-buku.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-none text-sm font-semibold transition-all border border-transparent
                  {{ (request()->routeIs('dashboard-buku.*') && (!request()->has('active_menu') || request()->input('active_menu') === 'buku')) ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
            <i data-lucide="book-open" class="w-4 h-4 flex-shrink-0"></i>
            <span>Data Buku</span>
        </a>

        {{-- Kelola Bab --}}
        <a href="{{ route('dashboard-buku.index', ['active_menu' => 'bab']) }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-none text-sm font-semibold transition-all border border-transparent
                  {{ (request()->input('active_menu') === 'bab' || (request()->routeIs('bab.*') && request()->input('active_menu', 'bab') === 'bab')) ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
            <i data-lucide="layers" class="w-4 h-4 flex-shrink-0"></i>
            <span>Kelola Bab</span>
        </a>

        {{-- Kelola Subbab --}}
        <a href="{{ route('dashboard-buku.index', ['active_menu' => 'subab']) }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-none text-sm font-semibold transition-all border border-transparent
                  {{ (request()->input('active_menu') === 'subab') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
            <i data-lucide="book-marked" class="w-4 h-4 flex-shrink-0"></i>
            <span>Kelola Subbab</span>
        </a>

        {{-- Kelola Materi --}}
        <a href="{{ route('dashboard-buku.index', ['active_menu' => 'materi']) }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-none text-sm font-semibold transition-all border border-transparent
                  {{ (request()->input('active_menu') === 'materi') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
            <i data-lucide="file-text" class="w-4 h-4 flex-shrink-0"></i>
            <span>Kelola Materi</span>
        </a>

        <div class="pt-4 pb-1">
            <p class="text-white/30 text-[10px] font-bold uppercase tracking-widest px-3 mb-3">Evaluasi</p>
        </div>

        {{-- Simulasi Ujian --}}
        <a href="{{ route('simulasi.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-none text-sm font-semibold transition-all border border-transparent
                  {{ request()->routeIs('simulasi.*') || request()->routeIs('soal-simulasi.*') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
            <i data-lucide="graduation-cap" class="w-4 h-4 flex-shrink-0"></i>
            <span>Simulasi Ujian</span>
        </a>

        {{-- Data Quiz --}}
        <a href="/admin/quiz"
           class="flex items-center gap-3 px-3 py-2.5 rounded-none text-sm font-semibold transition-all border border-transparent
                  {{ request()->is('admin/quiz*') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
            <i data-lucide="clipboard-list" class="w-4 h-4 flex-shrink-0"></i>
            <span>Data Quiz</span>
        </a>

        <div class="pt-4 pb-1">
            <p class="text-white/30 text-[10px] font-bold uppercase tracking-widest px-3 mb-3">Lainnya</p>
        </div>

        {{-- Saran --}}
        <a href="{{ route('admin.saran.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-none text-sm font-semibold transition-all border border-transparent
                  {{ request()->routeIs('admin.saran.*') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
            <i data-lucide="message-square" class="w-4 h-4 flex-shrink-0"></i>
            <span>Saran</span>
        </a>

    </nav>

    {{-- User info + Logout --}}
    <div class="px-4 py-5 border-t border-white/10 mt-auto">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-[#F4922A] border-2 border-black flex items-center justify-center flex-shrink-0">
                <i data-lucide="user" class="w-4 h-4 text-white"></i>
            </div>
            <div class="min-w-0">
                <p class="text-white text-xs font-bold truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                <p class="text-white/40 text-[10px] truncate">Administrator</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-2 px-3 py-2 text-xs font-bold text-red-400 hover:text-white hover:bg-red-500/20 transition-all border border-transparent hover:border-red-500/30">
                <i data-lucide="log-out" class="w-4 h-4 flex-shrink-0"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>

</aside>

<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>