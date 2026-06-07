<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SahabatBuku</title>
    <script type="module">
        import hotwireturbo from 'https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/dist/turbo.es2017.esm.js';
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        #auth-container {
            position: relative;
            min-height: calc(100vh - 64px);
            overflow: hidden;
        }

        /* Both panels absolutely positioned, full width each = 200% total */
        #form-panel {
            position: absolute;
            top: 0; bottom: 0;
            width: 50%;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 2.5rem 3rem;
            background: #E5F8FF;
            z-index: 10;
            overflow-y: auto; /* Enable internal scroll if form exceeds viewport */
        }

        #illustration-panel {
            position: absolute;
            top: 0; bottom: 0;
            width: 50%;
            right: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            background: linear-gradient(135deg, #1E3A5F 0%, #162a45 60%, #0f1d30 100%);
            border-radius: 3.5rem 0 0 3.5rem;
            overflow: hidden;
            z-index: 10;
        }

        @media (min-width: 1024px) {
            html, body {
                overflow: hidden;
                height: 100vh;
            }
        }

        @media (max-width: 1023px) {
            #auth-container {
                overflow: visible;
            }
            #form-panel {
                position: relative;
                width: 100%;
                left: auto;
                padding: 2rem 1.5rem;
            }
            #illustration-panel {
                display: none;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-[#E5F8FF] antialiased" id="auth-body">

    <x-main-navbar />

    <div id="auth-container" class="mt-16">

        {{-- FORM PANEL --}}
        <div id="form-panel">
            <div class="w-full max-w-md py-8 mx-auto my-auto">

                {{-- LOGIN FORM CARD --}}
                <div id="login-form-card" class="bg-white border-2 border-black shadow-[6px_6px_0px_#000] rounded-2xl p-8 sm:p-10">
                    <div class="mb-8 text-center">
                        <img src="{{ asset('images/logo_1.png') }}" class="h-10 mx-auto mb-4" alt="SahabatBuku">
                    </div>

                    <form method="POST" action="{{ route('login') }}" data-turbo="false" class="space-y-5">
                        @csrf

                        <div class="space-y-1.5">
                            <label class="text-xs font-black tracking-widest uppercase text-black">Email</label>
                            <div class="relative flex items-center">
                                <i data-lucide="mail" class="absolute left-3.5 w-5 h-5 text-slate-400"></i>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       placeholder="email yang kamu daftarkan"
                                       class="w-full border-2 border-black rounded-xl py-3.5 pl-12 pr-4 text-sm font-bold focus:outline-none focus:border-[#F4922A] transition-all">
                            </div>
                            @error('email')<p class="text-xs font-bold text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-black tracking-widest uppercase text-black">Password</label>
                            <div class="relative flex items-center">
                                <i data-lucide="lock" class="absolute left-3.5 w-5 h-5 text-slate-400"></i>
                                <input type="password" name="password" required
                                       placeholder="••••••••"
                                       class="w-full border-2 border-black rounded-xl py-3.5 pl-12 pr-4 text-sm font-bold focus:outline-none focus:border-[#F4922A] transition-all">
                            </div>
                            @error('password')<p class="text-xs font-bold text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex items-center justify-between text-xs font-bold text-black">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-2 border-black text-[#F4922A]">
                                <span>Ingat saya</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-[#F4922A] font-black hover:text-orange-600 transition-colors">
                                Lupa password?
                            </a>
                        </div>

                        <button type="submit"
                                class="w-full bg-[#F4922A] text-white rounded-xl py-3.5 font-black border-2 border-black shadow-[4px_4px_0px_#000] hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all text-sm">
                            Masuk
                        </button>

                        <p class="pt-2 text-xs text-center font-bold text-slate-600">
                            Belum punya akun?
                            <button type="button" onclick="switchToRegister()"
                                    class="text-[#F4922A] font-black hover:text-orange-600 ml-1">
                                Daftar Gratis
                            </button>
                        </p>
                    </form>
                </div>

                {{-- REGISTER FORM CARD (hidden initially) --}}
                <div id="register-form-card" class="bg-white border-2 border-black shadow-[6px_6px_0px_#000] rounded-2xl p-8 sm:p-10" style="display:none;">
                    <div class="mb-6 text-center">
                        <img src="{{ asset('images/logo_1.png') }}" class="h-10 mx-auto mb-4" alt="SahabatBuku">
                        <p class="text-sm font-bold text-slate-600">Mulai petualangan belajarmu di SahabatBuku</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" data-turbo="false" class="space-y-4">
                        @csrf

                        <div class="space-y-1.5">
                            <label class="text-xs font-black tracking-widest uppercase text-black">Nama</label>
                            <div class="relative flex items-center">
                                <i data-lucide="user" class="absolute left-3.5 w-5 h-5 text-slate-400"></i>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       placeholder="Nama Lengkap"
                                       class="w-full border-2 border-black rounded-xl py-3 pl-12 pr-4 text-sm font-bold focus:outline-none focus:border-[#F4922A] transition-all">
                            </div>
                            @error('name')<p class="text-xs font-bold text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-black tracking-widest uppercase text-black">Email</label>
                            <div class="relative flex items-center">
                                <i data-lucide="mail" class="absolute left-3.5 w-5 h-5 text-slate-400"></i>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       placeholder="email yang kamu daftarkan"
                                       class="w-full border-2 border-black rounded-xl py-3 pl-12 pr-4 text-sm font-bold focus:outline-none focus:border-[#F4922A] transition-all">
                            </div>
                            @error('email')<p class="text-xs font-bold text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-black tracking-widest uppercase text-black">Kelas</label>
                            <div class="relative flex items-center">
                                <i data-lucide="graduation-cap" class="absolute left-3.5 w-5 h-5 text-slate-400"></i>
                                <select name="kelas" required
                                        class="w-full border-2 border-black rounded-xl py-3 pl-12 pr-4 text-sm font-bold focus:outline-none focus:border-[#F4922A] bg-white appearance-none">
                                    <option value="" disabled selected>Pilih Kelas</option>
                                    <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>Kelas 10</option>
                                    <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>Kelas 11</option>
                                    <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>Kelas 12</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-black tracking-widest uppercase text-black">Password</label>
                            <div class="relative flex items-center">
                                <i data-lucide="lock" class="absolute left-3.5 w-5 h-5 text-slate-400"></i>
                                <input type="password" name="password" required placeholder="••••••••"
                                       class="w-full border-2 border-black rounded-xl py-3 pl-12 pr-4 text-sm font-bold focus:outline-none focus:border-[#F4922A] transition-all">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-black tracking-widest uppercase text-black">Konfirmasi Password</label>
                            <div class="relative flex items-center">
                                <i data-lucide="lock" class="absolute left-3.5 h-5 w-5 text-slate-400"></i>
                                <input type="password" name="password_confirmation" required placeholder="••••••••"
                                       class="w-full border-2 border-black rounded-xl py-3 pl-12 pr-4 text-sm font-bold focus:outline-none focus:border-[#F4922A] transition-all">
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full bg-[#F4922A] text-white rounded-xl py-3.5 font-black border-2 border-black shadow-[4px_4px_0px_#000] hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all text-sm mt-2">
                            Daftar Sekarang
                        </button>

                        <p class="pt-1 text-xs text-center font-bold text-slate-600">
                            Sudah punya akun?
                            <button type="button" onclick="switchToLogin()"
                                    class="text-[#F4922A] font-black hover:text-orange-600 ml-1">
                                Masuk di sini
                            </button>
                        </p>
                    </form>
                </div>

            </div>
        </div>

        {{-- ILLUSTRATION PANEL --}}
        <div id="illustration-panel">
            <div class="absolute rounded-full pointer-events-none w-96 h-96 bg-blue-500/10 -top-20 -right-20 blur-3xl"></div>
            <div class="absolute rounded-full pointer-events-none w-96 h-96 bg-orange-400/5 -bottom-20 -left-20 blur-3xl"></div>

            <div id="illus-content" class="relative z-10 flex flex-col items-center w-full max-w-md">
                <img id="illus-img" src="{{ asset('images/Mobile login-rafiki 1.png') }}"
                     class="w-4/5 h-auto drop-shadow-2xl" alt="Illustration">
                <h3 id="illus-title" class="mt-10 text-3xl font-extrabold leading-snug tracking-tight text-center text-white">
                    Belajar lebih terarah,<br>
                    <span class="text-[#F4922A]">bersama SahabatBuku</span>
                </h3>
                <p id="illus-subtitle" class="max-w-xs mt-3 text-sm font-medium text-center text-blue-200">
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

    <script>
        const formPanel = document.getElementById('form-panel');
        const illusPanel = document.getElementById('illustration-panel');
        const loginCard = document.getElementById('login-form-card');
        const registerCard = document.getElementById('register-form-card');
        const illusImg = document.getElementById('illus-img');
        const illusTitle = document.getElementById('illus-title');
        const illusSubtitle = document.getElementById('illus-subtitle');

        let isLogin = true;
        const DURATION = 0.55;
        const EASE = 'power3.inOut';

        function initLucide() {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }
        initLucide();

        function checkRegisterIntent() {
            if (sessionStorage.getItem('show_register') === '1') {
                sessionStorage.removeItem('show_register');
                switchToRegister(false);
            }
            @if(session('show_register') || (old('name') && $errors->any()))
            switchToRegister(false);
            @endif
        }

        // Check sessionStorage for register intent and validation errors
        window.addEventListener('DOMContentLoaded', checkRegisterIntent);
        document.addEventListener('turbo:load', checkRegisterIntent);

        // Browser back/forward navigation support
        window.addEventListener('popstate', () => {
            const path = window.location.pathname;
            if (path.endsWith('/register')) {
                switchToRegister(true);
            } else if (path.endsWith('/login')) {
                switchToLogin(true);
            }
        });

        // Intercept navbar link clicks when already on this page
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (!link) return;
            
            const href = link.getAttribute('href');
            if (!href) return;
            
            if (href.endsWith('/register') || href === '{{ route("register") }}') {
                e.preventDefault();
                switchToRegister(true);
            } else if (href.endsWith('/login') || href === '{{ route("login") }}') {
                e.preventDefault();
                switchToLogin(true);
            }
        });

        function switchToRegister(animate = true) {
            if (!isLogin) return;
            isLogin = false;

            if (animate) {
                history.pushState(null, '', '{{ route("register") }}');

                // Swap card content with fade animation
                gsap.to(loginCard, {
                    opacity: 0, duration: 0.15,
                    onComplete: () => {
                        loginCard.style.display = 'none';
                        registerCard.style.display = 'block';
                        gsap.set(registerCard, { opacity: 0 });
                        initLucide();
                        gsap.to(registerCard, { opacity: 1, duration: 0.2 });
                    }
                });
            } else {
                // Swap card content instantly
                loginCard.style.display = 'none';
                registerCard.style.display = 'block';
                gsap.set(registerCard, { opacity: 1 });
                initLucide();
            }

            if (animate && window.innerWidth >= 1024) {
                // Slide form panel: LEFT side → goes to RIGHT side
                gsap.to(formPanel, {
                    left: '50%',
                    duration: DURATION,
                    ease: EASE
                });

                // Slide illustration panel: RIGHT side → goes to LEFT side
                gsap.to(illusPanel, {
                    right: '50%',
                    borderRadius: '0 3.5rem 3.5rem 0',
                    duration: DURATION,
                    ease: EASE,
                    onComplete: () => {
                        // Update illustration content after slide
                        gsap.to('#illus-content', {
                            opacity: 0, duration: 0.2,
                            onComplete: () => {
                                illusTitle.innerHTML = 'Bergabung sekarang,<br><span class="text-[#F4922A]">mulai belajar hari ini</span>';
                                illusSubtitle.textContent = 'Daftar gratis dan akses semua buku pelajaran resmi Kemendikdasmen.';
                                illusImg.src = '{{ asset("images/Sign up-amico 1.png") }}';
                                gsap.to('#illus-content', { opacity: 1, duration: 0.3 });
                            }
                        });
                    }
                });
            } else if (!animate) {
                // Instantly move panels for non-animated load/mobile
                if (window.innerWidth >= 1024) {
                    gsap.set(formPanel, { left: '50%' });
                    gsap.set(illusPanel, {
                        right: '50%',
                        borderRadius: '0 3.5rem 3.5rem 0'
                    });
                    illusTitle.innerHTML = 'Bergabung sekarang,<br><span class="text-[#F4922A]">mulai belajar hari ini</span>';
                    illusSubtitle.textContent = 'Daftar gratis dan akses semua buku pelajaran resmi Kemendikdasmen.';
                    illusImg.src = '{{ asset("images/Sign up-amico 1.png") }}';
                }
            }
        }

        function switchToLogin(animate = true) {
            if (isLogin) return;
            isLogin = true;

            if (animate) {
                history.pushState(null, '', '{{ route("login") }}');

                // Swap card content with fade animation
                gsap.to(registerCard, {
                    opacity: 0, duration: 0.15,
                    onComplete: () => {
                        registerCard.style.display = 'none';
                        loginCard.style.display = 'block';
                        gsap.set(loginCard, { opacity: 0 });
                        initLucide();
                        gsap.to(loginCard, { opacity: 1, duration: 0.2 });
                    }
                });
            } else {
                // Swap card content instantly
                registerCard.style.display = 'none';
                loginCard.style.display = 'block';
                gsap.set(loginCard, { opacity: 1 });
                initLucide();
            }

            if (animate && window.innerWidth >= 1024) {
                // Slide form panel back to LEFT
                gsap.to(formPanel, {
                    left: '0%',
                    duration: DURATION,
                    ease: EASE
                });

                // Slide illustration panel back to RIGHT
                gsap.to(illusPanel, {
                    right: '0%',
                    borderRadius: '3.5rem 0 0 3.5rem',
                    duration: DURATION,
                    ease: EASE,
                    onComplete: () => {
                        gsap.to('#illus-content', {
                            opacity: 0, duration: 0.2,
                            onComplete: () => {
                                illusTitle.innerHTML = 'Belajar lebih terarah,<br><span class="text-[#F4922A]">bersama SahabatBuku</span>';
                                illusSubtitle.textContent = '';
                                illusImg.src = '{{ asset("images/Mobile login-rafiki 1.png") }}';
                                gsap.to('#illus-content', { opacity: 1, duration: 0.3 });
                            }
                        });
                    }
                });
            } else if (!animate) {
                // Instantly move panels for non-animated load/mobile
                if (window.innerWidth >= 1024) {
                    gsap.set(formPanel, { left: '0%' });
                    gsap.set(illusPanel, {
                        right: '0%',
                        borderRadius: '3.5rem 0 0 3.5rem'
                    });
                    illusTitle.innerHTML = 'Belajar lebih terarah,<br><span class="text-[#F4922A]">bersama SahabatBuku</span>';
                    illusSubtitle.textContent = '';
                    illusImg.src = '{{ asset("images/Mobile login-rafiki 1.png") }}';
                }
            }
        }
    </script>

</body>
</html>