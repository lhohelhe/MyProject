<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - SahabatBuku')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }

        /* Sidebar active highlight */
        .sidebar-link-active {
            background: #F4922A;
            color: #fff !important;
            box-shadow: 3px 3px 0px #000;
            border: 1.5px solid #000;
        }
        .sidebar-link-active i { color: #fff !important; }
        css[x-cloak] { display: none !important; }
</style>
</head>
<body class="bg-[#F8FAFC] antialiased">
    <div class="flex min-h-screen">
        <x-admin-sidebar />
        <main class="flex-1 min-w-0 px-4 py-8 sm:px-8 lg:px-10">
            @yield('content')
        </main>
    </div>
    <script>
        if (typeof lucide !== 'undefined') lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
