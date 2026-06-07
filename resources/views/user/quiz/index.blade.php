<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Harian - SahabatBuku</title>
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

        {{-- judul halaman --}}
        <h1 class="mb-6 text-2xl font-black uppercase tracking-wider text-black border-b-4 border-black pb-2">Quiz Harian — {{ $bab->judul_bab }}</h1>

        {{-- info bar --}}
        <div class="flex flex-col items-start justify-between gap-4 p-4 mb-8 bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl sm:flex-row sm:items-center">
            <div class="flex items-center gap-4">
                <span class="text-sm font-bold text-black font-jakarta">Kesulitan Saat Ini:</span>
                @php
                    $diffLevel = $progress?->difficulty_level ?? 'easy';
                    $difficultyLabel = [
                        'easy' => 'Mudah',
                        'medium' => 'Sedang',
                        'hard' => 'Sulit'
                    ][$diffLevel] ?? 'Mudah';
                    $difficultyColor = [
                        'easy' => 'bg-green-500',
                        'medium' => 'bg-yellow-500',
                        'hard' => 'bg-red-500'
                    ][$diffLevel] ?? 'bg-green-500';
                @endphp
                <span class="px-3 py-0.5 text-sm font-bold text-white border-2 border-black rounded-full {{ $difficultyColor }} font-jakarta shadow-[2px_2px_0px_#000]">
                    {{ $difficultyLabel }}
                </span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm font-bold text-black font-jakarta">Streak Hari:</span>
                <span class="text-2xl font-black text-[#F4922A] font-jakarta">
                    {{ $progress?->streak_hari ?? 0 }} <i data-lucide="flame" class="w-6 h-6 inline-block mb-1"></i>
                </span>
            </div>
        </div>

        {{-- grid quiz --}}
        @if($quizList->isEmpty())
            <p class="italic text-gray-400 font-jakarta">belum ada quiz untuk bab ini.</p>
        @else
            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
                @foreach($quizList as $quiz)
                <div class="flex flex-col bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl overflow-hidden hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all">

                    {{-- header card dengan difficulty badge --}}
                    <div class="relative px-4 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b-2 border-black">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <h3 class="flex-1 text-sm font-black text-black line-clamp-2 font-jakarta">
                                {{ $quiz->judul_quiz }}
                            </h3>
                            @php
                                $qDifficulty = $quiz->difficulty ?? 'easy';
                                $qDifficultyLabel = [
                                    'easy' => 'Mudah',
                                    'medium' => 'Sedang',
                                    'hard' => 'Sulit'
                                ][$qDifficulty] ?? 'Mudah';
                                $qDifficultyBg = [
                                    'easy' => 'bg-green-500',
                                    'medium' => 'bg-yellow-500',
                                    'hard' => 'bg-red-500'
                                ][$qDifficulty] ?? 'bg-green-500';
                            @endphp
                            <span class="px-2.5 py-0.5 text-xs font-bold text-white border-2 border-black rounded-full {{ $qDifficultyBg }} whitespace-nowrap shadow-[2px_2px_0px_#000]">
                                {{ $qDifficultyLabel }}
                            </span>
                        </div>
                    </div>

                    {{-- info quiz --}}
                    <div class="flex-1 px-4 py-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-black font-bold font-jakarta">Jumlah Soal</span>
                            <span class="text-sm font-black text-black font-jakarta">{{ $quiz->jumlah_soal }} soal</span>
                        </div>
                    </div>

                    {{-- tombol aksi --}}
                    <div class="px-4 py-3 border-t-2 border-black bg-slate-50">
                        <a href="{{ route('user.quiz.start', $quiz->id_quiz) }}" 
                           class="block w-full py-2 text-sm font-bold text-center text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                            Mulai Quiz
                        </a>
                    </div>

                </div>
                @endforeach
            </div>
        @endif

    </main>
</div>
<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
</body>
</html>
