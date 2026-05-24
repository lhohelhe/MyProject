<!DOCTYPE html> 
<html lang="id"> 
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SahabatBuku</title> 
    <script type="module">
      import hotwireturbo from 'https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/dist/turbo.es2017.esm.js';
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head> 
<body class="min-h-screen bg-[#E5F8FF] antialiased">

    <x-main-navbar />

    <div data-turbo-body class="flex min-h-screen pt-16">
        <!-- Left Column (Form) -->
        <div class="flex flex-col justify-center w-full px-6 py-12 lg:w-1/2 bg-[#E5F8FF] sm:px-12">
            <div class="w-full max-w-md mx-auto">
                
                <!-- Floating Card -->
                <div class="bg-white rounded-[2rem] shadow-xl border-2 border-black p-8 sm:p-10 transition-all duration-300 hover:shadow-2xl">
                    
                    <!-- Header -->
                    <div class="mb-8 text-center">
                        <!-- Logo -->
                        <div class="flex justify-center mb-6">
                            <img src="{{ asset('images/logo_1.png') }}" alt="SahabatBuku Logo" class="h-10">
                        </div>
                        <p class="mt-2 text-sm text-slate-500">Masuk ke akun SahabatBuku kamu</p>
                    </div>
                    
                    <!-- Form -->
                    <form method="POST" action="{{ route('login') }}" data-turbo="false" class="space-y-6">
                        @csrf
                        
                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold tracking-widest uppercase text-slate-500">Email</label>
                            <div class="relative flex items-center">
                                <i data-lucide="mail" class="absolute left-3.5 w-5 h-5 text-slate-400"></i>
                                <input type="email" name="email" value="{{ old('email') }}" required 
                                       placeholder="email@sekolah.sch.id" 
                                       class="w-full bg-white border border-slate-200 rounded-2xl py-3.5 pl-12 pr-4 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#F4922A] focus:ring-1 focus:ring-[#F4922A] transition-all">
                            </div>
                            @error('email')
                                <p class="mt-2 text-xs font-semibold text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold tracking-widest uppercase text-slate-500">Password</label>
                            <div class="relative flex items-center">
                                <i data-lucide="lock" class="absolute left-3.5 w-5 h-5 text-slate-400"></i>
                                <input type="password" name="password" required 
                                       placeholder="••••••••" 
                                       class="w-full bg-white border border-slate-200 rounded-2xl py-3.5 pl-12 pr-4 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#F4922A] focus:ring-1 focus:ring-[#F4922A] transition-all">
                            </div>
                            @error('password')
                                <p class="mt-2 text-xs font-semibold text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between text-xs font-medium text-slate-600">
                            <label class="flex items-center gap-2.5 cursor-pointer hover:text-slate-800 transition-colors">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded text-[#F4922A] focus:ring-[#F4922A] border-slate-300 transition-colors">
                                <span>Ingat saya</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-[#F4922A] hover:text-orange-600 font-bold transition-colors">
                                Lupa password?
                            </a>
                        </div>
                        
                        <!-- Submit -->
                        <button type="submit" class="w-full bg-[#F4922A] text-white rounded-2xl py-4 font-bold hover:bg-orange-600 transition-all text-sm shadow-lg shadow-orange-200 hover:shadow-orange-300 hover:translate-y-[-1px] active:translate-y-[1px] duration-150">
                            Masuk
                        </button>
                        
                        <!-- Register Link -->
                        <p class="mt-8 text-xs font-medium text-center text-slate-500">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="text-[#F4922A] font-bold hover:text-orange-600 transition-colors ml-1">
                                Daftar Gratis
                            </a>
                        </p>
                    </form>
                </div>
                
            </div>
        </div>
        
        <!-- Right Column (Illustration) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#1E3A5F] via-[#162a45] to-[#0f1d30] rounded-l-[3.5rem] flex-col justify-center items-center p-12 shadow-2xl relative overflow-hidden">
            
            <!-- Glowing mesh spots -->
            <div class="absolute rounded-full pointer-events-none w-96 h-96 bg-blue-500/10 -top-20 -right-20 blur-3xl"></div>
            <div class="absolute rounded-full pointer-events-none w-96 h-96 bg-orange-400/5 -bottom-20 -left-20 blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col items-center w-full max-w-md">
                <img src="{{ asset('images/Mobile login-rafiki 1.png') }}" alt="Login Illustration" class="w-4/5 h-auto transition-transform duration-700 drop-shadow-2xl hover:scale-105 hover:rotate-1">
                
                <h3 class="mt-10 text-3xl font-extrabold leading-snug tracking-tight text-center text-white">
                    Belajar lebih terarah,<br>
                    <span class="text-[#F4922A]">bersama SahabatBuku</span>
                </h3>
                <p class="max-w-xs mt-3 text-sm font-medium text-center text-blue-200">
                    Temukan rangkuman, kuis, dan simulasi belajar terlengkap berbasis buku kurikulum resmi.
                </p>
            </div>
        </div>
    </div>
    
    <script>
        function initLucide() {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }
        initLucide();
        document.addEventListener('turbo:render', initLucide);
    </script>
</body> 
</html>