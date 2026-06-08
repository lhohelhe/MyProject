<!-- Admin Sidebar -->
<div x-data="{ open: false }" @keydown.escape.window="open = false">

    {{-- Mobile toggle button --}}
    <button @click="open = !open"
            class="lg:hidden fixed top-4 left-4 z-50 w-10 h-10 flex items-center justify-center bg-[#1E3A5F] border-2 border-black shadow-[2px_2px_0px_#000] text-white">
        <i data-lucide="menu" class="w-5 h-5" x-show="!open"></i>
        <i data-lucide="x"    class="w-5 h-5" x-show="open" x-cloak></i>
    </button>

    {{-- Backdrop (mobile only) --}}
    <div x-show="open"
         x-cloak
         @click="open = false"
         x-transition:enter="transition-opacity duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="lg:hidden fixed inset-0 z-30 bg-black/50">
    </div>

    {{-- Sidebar panel --}}
    <aside class="fixed top-0 left-0 z-40 h-screen w-60 bg-[#1E3A5F] flex flex-col overflow-y-auto
                  transition-transform duration-200
                  lg:translate-x-0 lg:static lg:z-auto lg:h-screen lg:sticky lg:top-0 lg:flex-shrink-0"
           :class="open ? 'translate-x-0' : '-translate-x-full'"
           x-cloak
           style="display: flex;">

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

            <p class="text-white/30 text-[10px] font-bold uppercase tracking-widest px-3 mb-3">Utama</p>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold transition-all border border-transparent
                      {{ request()->routeIs('admin.dashboard') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <i data-lucide="layout-dashboard" class="w-4 h-4 flex-shrink-0"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('dashboard-user.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold transition-all border border-transparent
                      {{ request()->routeIs('dashboard-user.*') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <i data-lucide="users" class="w-4 h-4 flex-shrink-0"></i>
                <span>Data User</span>
            </a>

            <div class="pt-4 pb-1">
                <p class="text-white/30 text-[10px] font-bold uppercase tracking-widest px-3 mb-3">Konten</p>
            </div>

            {{-- Data Buku --}}
            <a href="{{ route('dashboard-buku.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold transition-all border border-transparent
                      {{ request()->routeIs('dashboard-buku.*') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <i data-lucide="book-open" class="w-4 h-4 flex-shrink-0"></i>
                <span>Data Buku</span>
            </a>

            {{-- Kelola Bab — masuk via pilih buku --}}
            <a href="{{ route('dashboard-buku.index') }}"
               onclick="sessionStorage.setItem('goto','bab');"
               class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold transition-all border border-transparent
                      {{ request()->routeIs('bab.*') || request()->routeIs('subab.*') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <i data-lucide="layers" class="w-4 h-4 flex-shrink-0"></i>
                <div class="min-w-0">
                    <span class="block">Kelola Bab & Subbab</span>
                    <span class="block text-[10px] opacity-50">Pilih buku terlebih dahulu</span>
                </div>
            </a>

            {{-- Semua Materi --}}
            <a href="{{ route('materi.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold transition-all border border-transparent
                      {{ request()->routeIs('materi.*') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <i data-lucide="file-text" class="w-4 h-4 flex-shrink-0"></i>
                <div class="min-w-0">
                    <span class="block">Data Materi</span>
                    <span class="block text-[10px] opacity-50">Cari &amp; edit isi materi</span>
                </div>
            </a>

            <div class="pt-4 pb-1">
                <p class="text-white/30 text-[10px] font-bold uppercase tracking-widest px-3 mb-3">Evaluasi</p>
            </div>

            <a href="{{ route('simulasi.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold transition-all border border-transparent
                      {{ request()->routeIs('simulasi.*') || request()->routeIs('soal-simulasi.*') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <i data-lucide="graduation-cap" class="w-4 h-4 flex-shrink-0"></i>
                <span>Simulasi Ujian</span>
            </a>

            <a href="{{ route('admin.quiz.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold transition-all border border-transparent
                      {{ request()->is('admin/quiz*') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <i data-lucide="clipboard-list" class="w-4 h-4 flex-shrink-0"></i>
                <span>Data Quiz</span>
            </a>

            <a href="{{ route('admin.flashcard.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold transition-all border border-transparent
                      {{ request()->is('admin/flashcard*') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <i data-lucide="list" class="w-4 h-4 flex-shrink-0"></i>
                <span>Flashcard</span>
            </a>

            <div class="pt-4 pb-1">
                <p class="text-white/30 text-[10px] font-bold uppercase tracking-widest px-3 mb-3">Lainnya</p>
            </div>

            <a href="{{ route('admin.saran.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold transition-all border border-transparent
                      {{ request()->routeIs('admin.saran.*') ? 'bg-[#F4922A] text-white border-black shadow-[2px_2px_0px_#000]' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <i data-lucide="message-square" class="w-4 h-4 flex-shrink-0"></i>
                <span>Saran</span>
            </a>

        </nav>

        {{-- User info + Logout --}}
        <div class="px-4 py-5 border-t border-white/10 mt-auto">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 bg-[#F4922A] border-2 border-black flex items-center justify-center flex-shrink-0">
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
</div>

<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
