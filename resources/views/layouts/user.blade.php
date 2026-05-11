<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#F5F5F5] min-h-screen">
    @yield('content')
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
