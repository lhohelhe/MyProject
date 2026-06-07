<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SahabatBuku</title>
    <script>
        // Immediately redirect to login page with register mode
        // Store intent in sessionStorage so login.blade knows to show register form
        sessionStorage.setItem('show_register', '1');
        if (typeof Turbo !== 'undefined') {
            Turbo.visit('{{ route("login") }}', { action: 'replace' });
        } else if (window.Turbo) {
            window.Turbo.visit('{{ route("login") }}', { action: 'replace' });
        } else {
            window.location.replace('{{ route("login") }}');
        }
    </script>
</head>
<body></body>
</html>
