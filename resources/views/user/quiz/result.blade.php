<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Quiz - SahabatBuku</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="antialiased font-jakarta" style="background-color: #E5F8FF;">
<div class="flex min-h-screen">

    <x-user-sidebar />

    {{-- konten utama --}}
    <main class="flex-1 px-8 py-6 overflow-y-auto">

        {{-- judul --}}
        <h1 class="mb-8 text-xl font-bold text-slate-800">Hasil Quiz</h1>

        {{-- skor besar --}}
        <div class="flex flex-col items-center justify-center p-12 mb-8 bg-white rounded-2xl shadow-sm border border-slate-100">
            <div class="mb-6 text-7xl font-bold text-[#F4922A] font-jakarta">
                {{ $hasil->skor }}%
            </div>
            <p class="text-lg text-gray-600 font-jakarta">{{ $quiz->judul_quiz }}</p>
        </div>

        {{-- XP badge dengan animasi --}}
        <div class="flex justify-center mb-12">
            <div class="relative inline-block px-6 py-3 text-2xl font-bold text-white bg-[#F4922A] rounded-full shadow-sm" style="animation: popIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);">
                <i data-lucide="star" class="w-5 h-5 inline-block mb-1"></i> +{{ $xpDapat }} XP
            </div>
        </div>

        {{-- info difficulty dan streak --}}
        <div class="grid grid-cols-1 gap-6 mb-12 md:grid-cols-2">
            {{-- difficulty --}}
            <div class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100">
                <p class="text-sm font-semibold text-gray-600 mb-4 font-jakarta">Tingkat Kesulitan</p>
                <div class="flex items-center justify-center gap-4">
                    {{-- difficulty sebelumnya --}}
                    <div class="flex flex-col items-center">
                        <p class="text-xs text-gray-600 mb-2 font-jakarta">Sebelumnya</p>
                        @php
                            $difficultySebelum = $hasil->difficulty_sebelum ?? 'easy';
                            $difficultyLabel = [
                                'easy' => 'Mudah',
                                'medium' => 'Sedang',
                                'hard' => 'Sulit'
                            ][$difficultySebelum] ?? 'Mudah';
                            $difficultyColor = [
                                'easy' => 'bg-green-500',
                                'medium' => 'bg-yellow-500',
                                'hard' => 'bg-red-500'
                            ][$difficultySebelum] ?? 'bg-green-500';
                        @endphp
                        <span class="px-3 py-1 text-sm font-bold text-white rounded-full {{ $difficultyColor }} font-jakarta">
                            {{ $difficultyLabel }}
                        </span>
                    </div>

                    {{-- arrow --}}
                    @php
                        $arrowIcon = 'arrow-right';
                        if ($difficultyBaru !== $difficultySebelum) {
                            $difficultyOrder = ['easy' => 0, 'medium' => 1, 'hard' => 2];
                            $arrowIcon = $difficultyOrder[$difficultyBaru] > $difficultyOrder[$difficultySebelum] ? 'arrow-up-right' : 'arrow-down-left';
                        }
                    @endphp
                    <div class="text-3xl text-gray-400 font-jakarta"><i data-lucide="{{ $arrowIcon }}" class="w-8 h-8"></i></div>

                    {{-- difficulty baru --}}
                    <div class="flex flex-col items-center">
                        <p class="text-xs text-gray-600 mb-2 font-jakarta">Sesudah</p>
                        @php
                            $difficultyNewLabel = [
                                'easy' => 'Mudah',
                                'medium' => 'Sedang',
                                'hard' => 'Sulit'
                            ][$difficultyBaru] ?? 'Mudah';
                            $difficultyNewColor = [
                                'easy' => 'bg-green-500',
                                'medium' => 'bg-yellow-500',
                                'hard' => 'bg-red-500'
                                ][$difficultyBaru] ?? 'bg-green-500';
                        @endphp
                        <span class="px-3 py-1 text-sm font-bold text-white rounded-full {{ $difficultyNewColor }} font-jakarta">
                            {{ $difficultyNewLabel }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- streak --}}
            <div class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100">
                <p class="text-sm font-semibold text-gray-600 mb-4 font-jakarta">Streak Hari</p>
                <div class="flex items-center justify-center">
                    <p class="text-3xl font-bold text-[#F4922A] font-jakarta">
                        <i data-lucide="flame" class="w-8 h-8 inline-block mb-1"></i> {{ $streakHari }} hari berturut-turut
                    </p>
                </div>
            </div>
        </div>

        {{-- tombol aksi --}}
        <div class="flex flex-col justify-center gap-4 sm:flex-row sm:justify-center mb-8">
            <a href="{{ route('user.quiz.start', $quiz->id_quiz) }}" 
               class="flex-1 sm:flex-initial px-8 py-3 text-lg font-bold text-center text-white bg-[#F4922A] rounded-xl hover:bg-opacity-90 transition font-jakarta">
                Ulangi Quiz
            </a>
            <a href="{{ route('user.buku.show', $quiz->bab->id_buku) }}" 
               class="flex-1 sm:flex-initial px-8 py-3 text-lg font-bold text-center text-gray-700 bg-gray-300 rounded-xl hover:bg-opacity-90 transition font-jakarta">
                Kembali ke Bab
            </a>
        </div>

    </main>
</div>

<style>
    @keyframes popIn {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }
        70% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>
<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
</body>
</html>
