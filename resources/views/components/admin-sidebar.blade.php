<!-- Sidebar -->
<aside class="flex-shrink-0 w-full lg:w-52 bg-admin-sidebar">
    <div class="p-4 lg:p-6">
        <!-- Logo -->
        <div class="flex items-center gap-2 mb-6 lg:mb-12">
            <img src="\MyProject\public\images\logo_2.png" alt="SahabatBuku Logo" class="w-5 h-5 lg:w-5 lg:h-5"/>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
            </svg>
        </div>

        <!-- Menu -->
        <nav class="space-y-4">
            <a href="/dashboard" class="block text-base text-white transition lg:text-lg font-jakarta hover:text-admin-orange {{ request()->is('dashboard') ? 'font-bold text-admin-orange' : '' }}">
                Dashboard
            </a>
            
            <a href="/users" class="block text-base text-white transition lg:text-lg font-jakarta hover:text-admin-orange {{ request()->is('users*') ? 'font-bold text-admin-orange' : '' }}">
                Data User
            </a>

            <a href="/admin" class="block text-base text-white transition lg:text-lg font-jakarta hover:text-admin-orange {{ request()->is('users*') ? 'font-bold text-admin-orange' : '' }}">
                Data Admin
            </a>

            <!-- TAMBAHKAN MENU BARU DI SINI -->
            <a href="/books" class="block text-base text-white transition lg:text-lg font-jakarta hover:text-admin-orange {{ request()->is('books*') ? 'font-bold text-admin-orange' : '' }}">
                Data Buku
            </a>

            <a href="/quiz" class="block text-base text-white transition lg:text-lg font-jakarta hover:text-admin-orange {{ request()->is('quiz*') ? 'font-bold text-admin-orange' : '' }}">
                Data Quiz
            </a>

            <a href="/flashcards" class="block text-base text-white transition lg:text-lg font-jakarta hover:text-admin-orange {{ request()->is('flashcards*') ? 'font-bold text-admin-orange' : '' }}">
                Data Flashcard
            </a>
        </nav>
    </div>
</aside>