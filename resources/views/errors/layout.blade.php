<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Terjadi Kesalahan') — SahabatBuku</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#E5F8FF] min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md text-center">

        {{-- Code badge --}}
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white border-2 border-black shadow-[5px_5px_0px_#000] rounded-2xl mb-6 mx-auto">
            <span class="text-3xl font-black text-black">@yield('code')</span>
        </div>

        {{-- Card --}}
        <div class="bg-white border-2 border-black shadow-[6px_6px_0px_#000] rounded-2xl p-8 mb-6">
            <h1 class="text-xl font-black text-black uppercase tracking-wider mb-3">
                @yield('heading')
            </h1>
            <p class="text-sm font-bold text-slate-500 leading-relaxed">
                @yield('message')
            </p>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : '/' }}"
               class="px-6 py-3 text-sm font-black text-black bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all">
                Kembali
            </a>
            <a href="{{ auth()->check() ? route('user.profile') : '/' }}"
               class="px-6 py-3 text-sm font-black text-white bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all">
                Ke Beranda
            </a>
        </div>

        <p class="mt-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">SahabatBuku</p>
    </div>

    <script>if (typeof lucide !== 'undefined') lucide.createIcons();</script>
</body>
</html>
