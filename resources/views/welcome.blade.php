<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SahabatBuku - Belajar di mana pun, kapanpun!</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <body class="antialiased">
    {{-- Success Message (setelah register/login) --}}
    @if(session('success'))
        <div class="fixed z-50 px-6 py-4 text-white bg-green-500 rounded-lg shadow-lg top-4 right-4">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
        <script>
            // Auto hide after 5 seconds
            setTimeout(() => {
                document.querySelector('.fixed').style.display = 'none';
            }, 5000);
        </script>
    @endif

    
    <div class="min-h-screen overflow-x-hidden bg-sky-50">
        
        {{-- Hero Section --}}
        <section class="px-4 pt-8 pb-12 md:pt-16">
            <div class="mx-auto max-w-7xl">
                
                {{-- Logo and Tagline --}}
                <div class="flex flex-col items-center gap-4 mb-8 md:mb-20">
                    <div class="flex items-end justify-center gap-2">
                        {{-- Book Icon --}}
                        <img src="{{ asset('images/logo_1.png') }}" alt="Akses Mudah" class="h-16 mb-4 w-200">
                    </div>
                    <p class="text-2xl font-light text-center text-black sm:text-3xl md:text-4xl">
                        Belajar di mana pun, kapanpun!
                    </p>
                </div>

                {{-- CTA Button --}}
                <div class="flex justify-center mb-8 space y-6">
                    @guest
                        <a href="{{ route('register') }}" class="bg-orange-400 hover:bg-orange-500 transition-colors px-10 py-5 rounded-full text-black text-2xl sm:text-3xl md:text-[35px] font-light">
                            Mari coba!
                        </a>
                   @else
                        <div class="space-y-6 text-center">
                            <p class="mb-6 text-2xl">
                                Selamat datang kembali, 
                                <span class="font-bold">{{ Auth::user()->name }}</span>! 👋
                            </p>
                            <a href="#fitur" class="inline-block px-10 py-5 text-xl font-light text-black transition-colors bg-orange-400 rounded-full hover:bg-orange-500 sm:text-2xl md:text-3xl">
                                Mulai Belajar
                            </a>
                        </div>
                    @endguest
                </div>

                {{-- Illustrations --}}
                <div class="flex flex-col items-center justify-center gap-8 mt-12 md:flex-row md:gap-16 lg:gap-32">
                  <img src="{{ asset('images/college entrance exam-amico 1.png') }}" 
                alt="Student studying" 
                class="w-64 h-64 sm:w-80 sm:h-80 md:w-[400px] md:h-[400px] lg:w-[524px] lg:h-[524px] object-contain">
    
                <img src="{{ asset('images/college entrance exam-rafiki (1) 1.png') }}" 
                    alt="Student celebrating" 
                    class="w-64 h-64 sm:w-80 sm:h-80 md:w-[400px] md:h-[400px] lg:w-[524px] lg:h-[524px] object-contain">
            </div>
                        </div>
                    </section>

        {{-- Four Main Feature Cards --}}
        <section class="px-4 py-12 md:py-20">
            <div class="mx-auto max-w-7xl">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    
                    {{-- Card 1 --}}
                    <div class="flex flex-col items-center gap-6 p-8 text-center bg-white shadow-lg rounded-3xl">
                        <img src="{{ asset('images/akses_mudah.png') }}" alt="Akses Mudah" class="w-16 h-16 mb-4">
                        <h3 class="text-2xl font-bold text-black">Akses Mudah</h3>
                        <p class="text-lg text-gray-700">
                            Belajar dimana saja dan kapan saja menggunakan platform yang mudah diakses
                        </p>
                    </div>

                    {{-- Card 2 --}}
                    <div class="flex flex-col items-center gap-6 p-8 text-center bg-white shadow-lg rounded-3xl">
                        <img src="{{ asset('images/belajar_interaktif.png') }}" alt="Belajar Interaktif" class="w-16 h-16 mb-4">
                        <h3 class="text-2xl font-bold text-black">Belajar Interaktif</h3>
                        <p class="text-lg text-gray-700">
                            Mengatur waktu belajar sendiri dengan fleksibilitas penuh sesuai kebutuhan
                        </p>
                    </div>

                    {{-- Card 3 --}}
                    <div class="flex flex-col items-center gap-6 p-8 text-center bg-white shadow-lg rounded-3xl">
                        <img src="{{ asset('images/ringkasan_ai.png') }}" alt="Ringkasan AI" class="w-16 h-16 mb-4">
                        <h3 class="text-2xl font-bold text-black">Ringkasan AI</h3>
                        <p class="text-lg text-gray-700">
                            Metode pembelajaran yang terstruktur membantu pemahaman lebih cepat dan mendalam
                        </p>
                    </img>
                    </div>

                    {{-- Card 4 --}}
                    <div class="flex flex-col items-center gap-6 p-8 text-center bg-white shadow-lg rounded-3xl">
                        <img src="{{ asset('images/materi_resmi.png') }}" alt="Materi Resmi" class="w-16 h-16 mb-4">
                        <h3 class="text-2xl font-bold text-black">Materi Resmi</h3>
                        <p class="text-lg text-gray-700">
                            Berbagai fitur interaktif seperti quiz, flashcard, dan simulasi ujian tersedia
                        </p>
                    </div>

                </div>
            </div>
        </section>

        {{-- Feature Details --}}
        <section class="px-4 py-12 bg-white md:py-20">
            <div class="mx-auto max-w-7xl">
                <h2 class="mb-16 text-4xl font-bold text-center text-black md:text-5xl">
                    Nikmati Keragaman Fitur
                </h2>
                
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    

                    {{-- Quiz --}}
                    <div class="flex flex-col items-center gap-5 p-8 text-center shadow-lg bg-sky-50 rounded-3xl">
                        <img src="{{ asset('images/quiz.png') }}" alt="Quiz Icon" class="w-16 h-16 mb-4">
                        <h3 class="text-3xl font-bold text-black">Quiz</h3>
                        <p class="text-xl text-gray-700">
                            Latihan soal disusun dari isi buku tematik, membantu menguji pemahaman tanpa keluar dari materi yang dipelajari
                        </p>
                    </div>

                    {{-- Flashcard --}}
                    <div class="flex flex-col items-center gap-5 p-8 text-center shadow-lg bg-sky-50 rounded-3xl">
                        <img src="{{ asset('images/flashcard.png') }}" alt="Flashcard Icon" class="w-16 h-16 mb-4">
                        <h3 class="text-3xl font-bold text-black">Flashcard</h3>
                        <p class="text-xl text-gray-700">
                            Istilah dan konsep penting diambil dari materi buku tematik, dilatih berulang agar lebih mudah diingat dan dipahami
                        </p>
                    </div>

                    {{-- Ujian Simulasi --}}
                    <div class="flex flex-col items-center gap-5 p-8 text-center shadow-lg bg-sky-50 rounded-3xl">
                        <img src="{{ asset('images/ujian_simulasi.png') }}" alt="Ujian Simulasi Icon" class="w-16 h-16 mb-4">
                        <h3 class="text-3xl font-bold text-black">Ujian Simulasi</h3>
                        <p class="max-w-2xl text-xl text-gray-700">
                            Latihan ujian berbasis materi buku tematik, lengkap dengan batas waktu dan tipe soal, untuk membiasakan diri menghadapi evaluasi sebenarnya
                        </p>
                    </div>

                    {{-- Notes AI --}}
                    <div class="flex flex-col items-center gap-5 p-8 text-center shadow-lg bg-sky-50 rounded-3xl">
                        <img src="{{ asset('images/notes_ai.png') }}" alt="Notes AI Icon" class="w-16 h-16 mb-4">
                        <h3 class="text-3xl font-bold text-black">Notes AI</h3>
                        <p class="text-xl text-gray-700">
                            Ringkasan materi dibuat dari konten buku tematik dengan bantuan AI, sehingga penjelasan lebih singkat namun tetap sesuai makna aslinya
                        </p>
                    </img>
                    </div>


                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="px-4 py-16 bg-slate-700">
            <div class="mx-auto max-w-7xl">
                <div class="grid grid-cols-1 gap-12 md:grid-cols-2">
                    
                    {{-- Left Column --}}
                    <div class="flex flex-col gap-6">
                        <div class="flex items-end gap-2">
                            <h3 class="text-4xl font-bold text-white md:text-5xl">SahabatBuku</h3>
                            <svg class="flex-shrink-0 w-8 h-10" viewBox="0 0 62 80" fill="none">
                                <path d="M10.219 0C4.5826 0 0 4.44475 0 9.91163V74.3372C0 76.1182 0.98997 77.7753 2.5867 78.6426C4.18342 79.5098 6.1474 79.4943 7.72815 78.5806L30.6571 65.2464L53.5702 78.5806C55.1509 79.4943 57.1149 79.5253 58.7116 78.6426C60.3083 77.7598 61.3143 76.1182 61.3143 74.3372V9.91163C61.3143 4.44475 56.7317 0 51.0952 0H10.219Z" fill="white"/>
                            </svg>
                        </div>
                        <p class="text-xl text-white">
                            Belajar di mana pun, kapanpun!
                        </p>
                        <nav class="flex flex-wrap gap-6 text-white">
                            <a href="#" class="text-lg transition hover:text-sky-300">Fitur</a>
                            <a href="#" class="text-lg transition hover:text-sky-300">Tentang</a>
                            <a href="#" class="text-lg transition hover:text-sky-300">Kontak</a>
                            <a href="#" class="text-lg transition hover:text-sky-300">Bantuan</a>
                        </nav>
                    </div>

                    {{-- Right Column --}}
                    <div class="flex flex-col gap-6">
                        <h4 class="text-2xl font-semibold text-white">Hubungi Kami</h4>
                        <div class="flex flex-col gap-4 text-lg text-white">
                            <p>Email: info@sahabatbuku.com</p>
                            <p>WhatsApp: +62 812-3456-7890</p>
                        </div>
                        @guest
                        <div class="mt-4">
                            <a href="{{ route('register') }}" class="inline-block px-8 py-3 text-lg font-semibold text-black transition-colors bg-orange-400 rounded-full hover:bg-orange-500">
                                Daftar Sekarang
                            </a>
                        </div>
                        @endguest
                    </div>
                </div>

                {{-- Copyright --}}
                <div class="pt-8 mt-12 text-lg text-center text-white border-t border-slate-600">
                    <p>&copy; 2026 SahabatBuku. All rights reserved.</p>
                </div>
            </div>
        </footer>

    </div>
</body>
</html>