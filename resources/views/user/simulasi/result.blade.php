<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Ujian - SahabatBuku</title>
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
        <h1 class="mb-8 text-xl font-bold text-slate-800">Hasil Ujian</h1>

        {{-- skor besar --}}
        <div class="flex flex-col items-center justify-center p-12 mb-8 bg-white rounded-2xl shadow-sm border border-slate-100">
            <div class="mb-4 text-7xl font-bold text-[#F4922A] font-jakarta">
                {{ $hasil->skor }}%
            </div>
            <div>
                @if($hasil->lulus)
                    <span class="px-4 py-2 text-lg font-bold text-white bg-green-600 rounded-full font-jakarta">
                        LULUS
                    </span>
                @else
                    <span class="px-4 py-2 text-lg font-bold text-white bg-red-600 rounded-full font-jakarta">
                        TIDAK LULUS
                    </span>
                @endif
            </div>
        </div>

        {{-- ringkasan --}}
        <div class="grid grid-cols-3 gap-4 mb-12">
            {{-- benar --}}
            <div class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100">
                <p class="text-sm font-semibold text-gray-600 mb-2 font-jakarta">Benar</p>
                <p class="text-4xl font-bold text-green-600 font-jakarta">
                    {{ $hasil->jumlah_benar }}
                </p>
            </div>

            {{-- salah --}}
            <div class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100">
                <p class="text-sm font-semibold text-gray-600 mb-2 font-jakarta">Salah</p>
                <p class="text-4xl font-bold text-red-600 font-jakarta">
                    {{ $hasil->jumlah_salah }}
                </p>
            </div>

            {{-- kosong --}}
            <div class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100">
                <p class="text-sm font-semibold text-gray-600 mb-2 font-jakarta">Kosong</p>
                <p class="text-4xl font-bold text-gray-600 font-jakarta">
                    {{ $hasil->jumlah_kosong }}
                </p>
            </div>
        </div>

        {{-- pembahasan per soal --}}
        <div class="mb-12">
            <h2 class="mb-6 text-lg font-bold text-slate-800 font-jakarta">Pembahasan</h2>

            <div class="space-y-6">
                @foreach($soal as $index => $s)
                <div class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100">
                    {{-- nomor dan pertanyaan --}}
                    <div class="mb-4">
                        <p class="text-sm font-semibold text-gray-600 mb-2 font-jakarta">Soal {{ $index + 1 }}</p>
                        <p class="text-lg font-semibold text-gray-800 font-jakarta">{{ $s->pertanyaan }}</p>
                    </div>

                    {{-- grid jawaban --}}
                    <div class="grid grid-cols-1 gap-3 mb-6 sm:grid-cols-2">
                        @foreach(['a', 'b', 'c', 'd'] as $option)
                        <div class="p-3 rounded-lg border-2 transition-colors
                            @if($s->user_answer === $option && $s->user_answer_correct)
                                bg-green-50 border-green-400
                            @elseif($s->user_answer === $option && !$s->user_answer_correct)
                                bg-red-50 border-red-400
                            @elseif($s->kunci_jawaban === $option && $s->user_answer !== $option && !$s->user_answer_correct)
                                bg-blue-50 border-blue-400
                            @else
                                bg-gray-50 border-gray-200
                            @endif
                        ">
                            <div class="flex items-start gap-2">
                                <span class="font-bold text-gray-700 font-jakarta">{{ strtoupper($option) }}.</span>
                                <div class="flex-1">
                                    <p class="text-gray-700 font-jakarta">
                                        {{ $s->{'opsi_' . $option} }}
                                    </p>

                                    {{-- label jawaban --}}
                                    @if($s->user_answer === $option && $s->user_answer_correct)
                                        <p class="mt-2 text-xs font-bold text-green-700 font-jakarta"><i data-lucide="check" class="w-3 h-3 inline-block mb-0.5"></i> Jawaban Benar</p>
                                    @elseif($s->user_answer === $option && !$s->user_answer_correct)
                                        <p class="mt-2 text-xs font-bold text-red-700 font-jakarta"><i data-lucide="x" class="w-3 h-3 inline-block mb-0.5"></i> Jawaban Anda</p>
                                    @elseif($s->kunci_jawaban === $option && $s->user_answer !== $option)
                                        <p class="mt-2 text-xs font-bold text-blue-700 font-jakarta"><i data-lucide="check" class="w-3 h-3 inline-block mb-0.5"></i> Jawaban Benar</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- pembahasan --}}
                    @if($s->pembahasan)
                    <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                        <p class="text-sm font-semibold text-blue-900 mb-2 font-jakarta">Pembahasan:</p>
                        <p class="text-gray-800 font-jakarta">{{ $s->pembahasan }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        {{-- tombol kembali --}}
        <div class="flex justify-center mb-8">
            <a href="{{ route('user.simulasi.index') }}" 
               class="inline-block px-8 py-3 text-lg font-bold text-white bg-[#F4922A] rounded-xl hover:bg-opacity-90 transition font-jakarta">
                Kembali ke Simulasi
            </a>
        </div>

    </main>
</div>
<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
</body>
</html>
