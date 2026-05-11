<!-- Sidebar -->
<aside class="flex-shrink-0 w-full lg:w-52 lg:h-screen lg:sticky lg:top-0 bg-admin-sidebar overflow-y-auto">
    <div class="p-4 lg:p-6">
        <!-- Logo -->
        <div class="flex items-center gap-2 mb-6 lg:mb-12">
            <img src="{{ asset('images/logo_2.png') }}" alt="SahabatBuku Logo" class="w-5 h-5 lg:w-5 lg:h-5"/>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
            </svg>
        </div>
        <nav class="space-y-4">
            {{-- dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="block text-base text-white transition lg:text-lg font-jakarta hover:text-admin-orange {{ request()->routeIs('admin.dashboard') ? 'font-bold text-admin-orange' : '' }}">
                Dashboard
            </a>

            {{-- data user --}}
            <a href="{{ route('dashboard-user.index') }}" class="block text-base text-white transition lg:text-lg font-jakarta hover:text-admin-orange {{ request()->routeIs('dashboard-user.*') ? 'font-bold text-admin-orange' : '' }}">
                Data User
            </a>

            {{-- data buku --}}
            <a href="{{ route('dashboard-buku.index') }}" class="block text-base text-white transition lg:text-lg font-jakarta hover:text-admin-orange {{ request()->routeIs('dashboard-buku.*') ? 'font-bold text-admin-orange' : '' }}">
                Data Buku
            </a>

            {{-- simulasi ujian --}}
            <a href="{{ route('simulasi.index') }}" class="block text-base text-white transition lg:text-lg font-jakarta hover:text-admin-orange {{ request()->routeIs('simulasi.*') || request()->routeIs('soal-simulasi.*') ? 'font-bold text-admin-orange' : '' }}">
                Simulasi Ujian
            </a>

            {{-- quiz --}}
            <a href="/admin/quiz" class="block text-base text-white transition lg:text-lg font-jakarta hover:text-admin-orange {{ request()->is('admin/quiz*') ? 'font-bold text-admin-orange' : '' }}">
                Data Quiz
            </a>

            {{-- flashcard --}}
            <a href="/admin/flashcard" class="block text-base text-white transition lg:text-lg font-jakarta hover:text-admin-orange {{ request()->is('admin/flashcard*') ? 'font-bold text-admin-orange' : '' }}">
                Data Flashcard
            </a>
        </nav>
    </div>
</aside>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>