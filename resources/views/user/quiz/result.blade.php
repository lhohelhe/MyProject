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
        <h1 class="mb-8 text-2xl font-black uppercase tracking-wider text-black border-b-4 border-black pb-2">Hasil Quiz</h1>

        {{-- skor besar --}}
        <div class="flex flex-col items-center justify-center p-8 mb-6 bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl">
            <div class="mb-3 text-5xl font-black text-[#F4922A] font-jakarta">
                {{ $hasil->skor }}%
            </div>
            <p class="text-base font-bold text-black font-jakarta">{{ $quiz?->judul_quiz ?? 'Quiz Variasi AI' }}</p>
        </div>

        {{-- XP badge dengan animasi --}}
        <div class="flex justify-center mb-8">
            <div class="relative inline-block px-5 py-2 text-base font-bold text-white bg-[#F4922A] border-2 border-black rounded-full shadow-[3px_3px_0px_#000]" style="animation: popIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);">
                <i data-lucide="star" class="w-4 h-4 inline-block mb-0.5"></i> +{{ $xpDapat }} XP
            </div>
        </div>

        {{-- info difficulty dan streak --}}
        <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-2">
            {{-- difficulty --}}
            <div class="p-4 bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl">
                <p class="text-sm font-bold text-black mb-3 font-jakarta">Tingkat Kesulitan</p>
                <div class="flex items-center justify-center gap-4">
                    {{-- difficulty sebelumnya --}}
                    <div class="flex flex-col items-center">
                        <p class="text-xs text-slate-500 mb-2 font-bold font-jakarta">Sebelumnya</p>
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
                        <span class="px-3 py-0.5 text-sm font-bold text-white border-2 border-black rounded-full {{ $difficultyColor }} font-jakarta shadow-[2px_2px_0px_#000]">
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
                    <div class="text-3xl text-black font-jakarta"><i data-lucide="{{ $arrowIcon }}" class="w-5 h-5"></i></div>

                    {{-- difficulty baru --}}
                    <div class="flex flex-col items-center">
                        <p class="text-xs text-slate-500 mb-2 font-bold font-jakarta">Sesudah</p>
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
                        <span class="px-3 py-0.5 text-sm font-bold text-white border-2 border-black rounded-full {{ $difficultyNewColor }} font-jakarta shadow-[2px_2px_0px_#000]">
                            {{ $difficultyNewLabel }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- streak --}}
            <div class="p-4 bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl">
                <p class="text-sm font-bold text-black mb-3 font-jakarta">Streak Hari</p>
                <div class="flex items-center justify-center">
                    <p class="text-2xl font-black text-[#F4922A] font-jakarta">
                        <i data-lucide="flame" class="w-6 h-6 inline-block mb-1"></i> {{ $streakHari }} hari
                    </p>
                </div>
            </div>
        </div>

        {{-- pembahasan (hanya untuk AI mode) --}}
        @if ($pembahasan)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-black mb-4 border-b-2 border-black pb-2">Pembahasan</h2>
                @foreach ($pembahasan as $item)
                    <div class="mb-6 p-4 bg-white border border-gray-300 rounded-lg">
                        <div class="flex items-start gap-3 mb-2">
                            <span class="inline-flex items-center justify-center w-6 h-6 min-w-6 bg-[#F4922A] text-white text-sm font-bold rounded-full">
                                {{ $item['nomor'] }}
                            </span>
                            <p class="text-sm font-semibold text-black flex-1">{{ $item['pertanyaan'] }}</p>
                        </div>

                        <div class="ml-9 space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-600">Jawaban Anda:</span>
                                <span class="px-3 py-1 text-sm font-bold rounded {{ $item['jawaban_user'] === $item['jawaban_benar'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $item['jawaban_user'] ?: '-' }}
                                </span>
                            </div>

                            @if ($item['jawaban_user'] !== $item['jawaban_benar'])
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-slate-600">Jawaban Benar:</span>
                                    <span class="px-3 py-1 text-sm font-bold bg-green-100 text-green-700 rounded">
                                        {{ $item['jawaban_benar'] }}
                                    </span>
                                </div>
                            @endif

                            @if ($item['pembahasan'])
                                <p class="text-xs text-slate-600 italic mt-3 p-3 bg-gray-50 rounded border-l-2 border-gray-400">
                                    {{ $item['pembahasan'] }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif


        <div class="flex flex-col justify-center gap-4 sm:flex-row sm:justify-center mb-8">
            @if ($quiz && $quiz->id_quiz == 0)
                <a href="{{ route('user.quiz.start-ai', $quiz->bab->id_bab) }}"
                   class="flex-1 sm:flex-initial px-8 py-3 text-lg font-bold text-center text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                    Ulangi Quiz
                </a>
            @elseif ($quiz)
                <a href="{{ route('user.quiz.start', $quiz->id_quiz) }}"
                   class="flex-1 sm:flex-initial px-8 py-3 text-lg font-bold text-center text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                    Ulangi Quiz
                </a>
            @endif
            @if ($quiz && $quiz->bab)
                <a href="{{ route('user.buku.show', $quiz->bab->id_buku) }}"
                   class="flex-1 sm:flex-initial px-8 py-3 text-lg font-bold text-center text-black bg-white border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                    Kembali ke Bab
                </a>
            @endif
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
