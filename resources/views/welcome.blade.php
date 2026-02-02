<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SahabatBuku - Belajar di mana pun, kapanpun!</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen bg-sky-50 overflow-x-hidden">
        
        {{-- Hero Section --}}
        <section class="pt-8 md:pt-16 pb-12 px-4">
            <div class="max-w-7xl mx-auto">
                
                {{-- Logo and Tagline --}}
                <div class="flex flex-col items-center gap-4 mb-8 md:mb-20">
                    <div class="flex items-end justify-center gap-2">
                        <h1 class="text-5xl sm:text-7xl md:text-8xl lg:text-[135px] font-bold text-black leading-none">
                            SahabatBuku
                        </h1>
                        {{-- Book Icon --}}
                        <svg class="w-10 h-12 sm:w-12 sm:h-16 md:w-16 md:h-20 flex-shrink-0" viewBox="0 0 62 80" fill="none">
                            <path d="M10.219 0C4.5826 0 0 4.44475 0 9.91163V74.3372C0 76.1182 0.98997 77.7753 2.5867 78.6426C4.18342 79.5098 6.1474 79.4943 7.72815 78.5806L30.6571 65.2464L53.5702 78.5806C55.1509 79.4943 57.1149 79.5253 58.7116 78.6426C60.3083 77.7598 61.3143 76.1182 61.3143 74.3372V9.91163C61.3143 4.44475 56.7317 0 51.0952 0H10.219Z" fill="#A7D1EF"/>
                        </svg>
                    </div>
                    <p class="text-2xl sm:text-3xl md:text-4xl font-light text-black text-center">
                        Belajar di mana pun, kapanpun!
                    </p>
                </div>

                {{-- CTA Button --}}
                <div class="flex justify-center mb-8">
                    @guest
                        <a href="{{ route('register') }}" class="bg-orange-400 hover:bg-orange-500 transition-colors px-10 py-5 rounded-full text-black text-2xl sm:text-3xl md:text-[35px] font-light">
                            Mari coba!
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="bg-orange-400 hover:bg-orange-500 transition-colors px-10 py-5 rounded-full text-black text-2xl sm:text-3xl md:text-[35px] font-light">
                            Masuk Dashboard
                        </a>
                    @endguest
                </div>

                {{-- Illustrations --}}
                <div class="flex flex-col md:flex-row items-center justify-center gap-8 md:gap-16 lg:gap-32 mt-12">
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
        <section class="py-12 md:py-20 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    
                    {{-- Card 1 --}}
                    <div class="bg-white rounded-3xl shadow-lg p-8 flex flex-col items-center gap-6 text-center">
                        <img src="{{ asset('images/akses_mudah.png') }}" alt="Akses Mudah" class="w-16 h-16 mb-4">
                        <h3 class="text-2xl font-bold text-black">Akses Mudah</h3>
                        <p class="text-lg text-gray-700">
                            Belajar dimana saja dan kapan saja menggunakan platform yang mudah diakses
                        </p>
                    </div>

                    {{-- Card 2 --}}
                    <div class="bg-white rounded-3xl shadow-lg p-8 flex flex-col items-center gap-6 text-center">
                        <img src="{{ asset('images/belajar_interaktif.png') }}" alt="Belajar Interaktif" class="w-16 h-16 mb-4">
                        <h3 class="text-2xl font-bold text-black">Belajar Interaktif</h3>
                        <p class="text-lg text-gray-700">
                            Mengatur waktu belajar sendiri dengan fleksibilitas penuh sesuai kebutuhan
                        </p>
                    </div>

                    {{-- Card 3 --}}
                    <div class="bg-white rounded-3xl shadow-lg p-8 flex flex-col items-center gap-6 text-center">
                        <img src="{{ asset('images/ringkasan_ai.png') }}" alt="Ringkasan AI" class="w-16 h-16 mb-4">
                        <h3 class="text-2xl font-bold text-black">Ringkasan AI</h3>
                        <p class="text-lg text-gray-700">
                            Metode pembelajaran yang terstruktur membantu pemahaman lebih cepat dan mendalam
                        </p>
                    </img>
                    </div>

                    {{-- Card 4 --}}
                    <div class="bg-white rounded-3xl shadow-lg p-8 flex flex-col items-center gap-6 text-center">
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
        <section class="py-12 md:py-20 px-4 bg-white">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold text-center text-black mb-16">
                    Nikmati Keragaman Fitur
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    

                    {{-- Quiz --}}
                    <div class="bg-sky-50 rounded-3xl shadow-lg p-8 flex flex-col items-center gap-5 text-center">
                        <img src="{{ asset('images/quiz.png') }}" alt="Quiz Icon" class="w-16 h-16 mb-4">
                        <h3 class="text-3xl font-bold text-black">Quiz</h3>
                        <p class="text-xl text-gray-700">
                            Latihan soal disusun dari isi buku tematik, membantu menguji pemahaman tanpa keluar dari materi yang dipelajari
                        </p>
                    </div>

                    {{-- Flashcard --}}
                    <div class="bg-sky-50 rounded-3xl shadow-lg p-8 flex flex-col items-center gap-5 text-center">
                        <img src="{{ asset('images/flashcard.png') }}" alt="Flashcard Icon" class="w-16 h-16 mb-4">
                        <h3 class="text-3xl font-bold text-black">Flashcard</h3>
                        <p class="text-xl text-gray-700">
                            Istilah dan konsep penting diambil dari materi buku tematik, dilatih berulang agar lebih mudah diingat dan dipahami
                        </p>
                    </div>

                    {{-- Ujian Simulasi --}}
                    <div class="bg-sky-50 rounded-3xl shadow-lg p-8 flex flex-col items-center gap-5 text-center">
                        <img src="{{ asset('images/ujian_simulasi.png') }}" alt="Ujian Simulasi Icon" class="w-16 h-16 mb-4">
                        <h3 class="text-3xl font-bold text-black">Ujian Simulasi</h3>
                        <p class="text-xl text-gray-700 max-w-2xl">
                            Latihan ujian berbasis materi buku tematik, lengkap dengan batas waktu dan tipe soal, untuk membiasakan diri menghadapi evaluasi sebenarnya
                        </p>
                    </div>

                    {{-- Notes AI --}}
                    <div class="bg-sky-50 rounded-3xl shadow-lg p-8 flex flex-col items-center gap-5 text-center">
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
        <footer class="bg-slate-700 py-16 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    
                    {{-- Left Column --}}
                    <div class="flex flex-col gap-6">
                        <div class="flex items-end gap-2">
                            <h3 class="text-4xl md:text-5xl font-bold text-white">SahabatBuku</h3>
                            <svg class="w-8 h-10 flex-shrink-0" viewBox="0 0 62 80" fill="none">
                                <path d="M10.219 0C4.5826 0 0 4.44475 0 9.91163V74.3372C0 76.1182 0.98997 77.7753 2.5867 78.6426C4.18342 79.5098 6.1474 79.4943 7.72815 78.5806L30.6571 65.2464L53.5702 78.5806C55.1509 79.4943 57.1149 79.5253 58.7116 78.6426C60.3083 77.7598 61.3143 76.1182 61.3143 74.3372V9.91163C61.3143 4.44475 56.7317 0 51.0952 0H10.219Z" fill="white"/>
                            </svg>
                        </div>
                        <p class="text-white text-xl">
                            Belajar di mana pun, kapanpun!
                        </p>
                        <nav class="flex flex-wrap gap-6 text-white">
                            <a href="#" class="text-lg hover:text-sky-300 transition">Fitur</a>
                            <a href="#" class="text-lg hover:text-sky-300 transition">Tentang</a>
                            <a href="#" class="text-lg hover:text-sky-300 transition">Kontak</a>
                            <a href="#" class="text-lg hover:text-sky-300 transition">Bantuan</a>
                        </nav>
                    </div>

                    {{-- Right Column --}}
                    <div class="flex flex-col gap-6">
                        <h4 class="text-2xl font-semibold text-white">Hubungi Kami</h4>
                        <div class="flex flex-col gap-4 text-white text-lg">
                            <p>Email: info@sahabatbuku.com</p>
                            <p>WhatsApp: +62 812-3456-7890</p>
                        </div>
                        @guest
                        <div class="mt-4">
                            <a href="{{ route('register') }}" class="inline-block bg-orange-400 hover:bg-orange-500 transition-colors px-8 py-3 rounded-full text-black text-lg font-semibold">
                                Daftar Sekarang
                            </a>
                        </div>
                        @endguest
                    </div>
                </div>

                {{-- Copyright --}}
                <div class="mt-12 pt-8 border-t border-slate-600 text-center text-white text-lg">
                    <p>&copy; 2026 SahabatBuku. All rights reserved.</p>
                </div>
            </div>
        </footer>

    </div>
</body>
</html>