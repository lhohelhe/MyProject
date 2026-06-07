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
        <h1 class="mb-4 text-lg font-black uppercase tracking-wider text-black border-b-4 border-black pb-2">Hasil Ujian</h1>

        {{-- skor besar --}}
        <div class="flex flex-col items-center justify-center p-4 mb-4 bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl">
            <div class="mb-2 text-4xl font-black text-[#F4922A] font-jakarta">
                {{ $hasil->skor }}%
            </div>
            <div>
                @if($hasil->lulus)
                    <span class="px-3 py-0.5 text-xs font-bold text-white bg-green-500 border-2 border-black rounded-full shadow-[2px_2px_0px_#000] font-jakarta">
                        LULUS
                    </span>
                @else
                    <span class="px-3 py-0.5 text-xs font-bold text-white bg-red-500 border-2 border-black rounded-full shadow-[2px_2px_0px_#000] font-jakarta">
                        TIDAK LULUS
                    </span>
                @endif
            </div>
        </div>

        {{-- ringkasan --}}
        <div class="grid grid-cols-3 gap-3 mb-4">
            <div class="p-3 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl">
                <p class="text-[10px] font-bold text-black uppercase tracking-wider mb-1 font-jakarta">Benar</p>
                <p class="text-2xl font-black text-green-600 font-jakarta">{{ $hasil->jumlah_benar }}</p>
            </div>
            <div class="p-3 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl">
                <p class="text-[10px] font-bold text-black uppercase tracking-wider mb-1 font-jakarta">Salah</p>
                <p class="text-2xl font-black text-red-500 font-jakarta">{{ $hasil->jumlah_salah }}</p>
            </div>
            <div class="p-3 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl">
                <p class="text-[10px] font-bold text-black uppercase tracking-wider mb-1 font-jakarta">Kosong</p>
                <p class="text-2xl font-black text-black font-jakarta">{{ $hasil->jumlah_kosong }}</p>
            </div>
        </div>

        {{-- tombol aksi --}}
        <div class="flex gap-3 mb-4">
            <a href="{{ route('user.simulasi.show', $hasil->id_simulasi) }}"
               class="flex-1 py-2.5 text-sm font-bold text-center text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                Ulangi Ujian
            </a>
            <a href="{{ route('user.simulasi.index') }}"
               class="flex-1 py-2.5 text-sm font-bold text-center text-black bg-white border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                Kembali ke Simulasi
            </a>
        </div>

        {{-- pembahasan per soal --}}
        <div class="mb-4">
            <h2 class="mb-3 text-xs font-black text-black uppercase tracking-wider font-jakarta">Pembahasan</h2>

            <div class="space-y-3">
                @foreach($soal as $index => $s)
                <div class="p-4 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl">
                    <div class="mb-3">
                        <p class="text-[10px] font-bold text-black uppercase tracking-wider mb-1 font-jakarta">Soal {{ $index + 1 }}</p>
                        <p class="text-sm font-bold text-black font-jakarta">{{ $s->pertanyaan }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mb-3">
                        @foreach(['a', 'b', 'c', 'd'] as $option)
                        @if(!empty($s->{'opsi_' . $option}))
                        <div class="p-2.5 rounded-xl border-2 transition-colors
                            @if($s->user_answer === $option && $s->user_answer_correct)
                                bg-green-50 border-green-500
                            @elseif($s->user_answer === $option && !$s->user_answer_correct)
                                bg-red-50 border-red-500
                            @elseif($s->kunci_jawaban === $option && $s->user_answer !== $option && !$s->user_answer_correct)
                                bg-blue-50 border-blue-500
                            @else
                                bg-slate-50 border-black
                            @endif
                        ">
                            <div class="flex items-start gap-2">
                                <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center font-bold text-black bg-white border-2 border-black rounded-full text-[10px] font-jakarta">{{ strtoupper($option) }}</span>
                                <div class="flex-1">
                                    <p class="text-xs font-bold text-black font-jakarta">{{ $s->{'opsi_' . $option} }}</p>
                                    @if($s->user_answer === $option && $s->user_answer_correct)
                                        <p class="mt-0.5 text-[10px] font-bold text-green-700 font-jakarta"><i data-lucide="check" class="w-2.5 h-2.5 inline-block"></i> Benar</p>
                                    @elseif($s->user_answer === $option && !$s->user_answer_correct)
                                        <p class="mt-0.5 text-[10px] font-bold text-red-700 font-jakarta"><i data-lucide="x" class="w-2.5 h-2.5 inline-block"></i> Jawaban Anda</p>
                                    @elseif($s->kunci_jawaban === $option && $s->user_answer !== $option)
                                        <p class="mt-0.5 text-[10px] font-bold text-blue-700 font-jakarta"><i data-lucide="check" class="w-2.5 h-2.5 inline-block"></i> Kunci</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>

                    @if($s->pembahasan)
                    <div class="p-2.5 bg-slate-50 border-2 border-black rounded-xl">
                        <p class="text-[10px] font-black text-black uppercase tracking-wider mb-0.5 font-jakarta">Pembahasan:</p>
                        <p class="text-xs font-bold text-black font-jakarta">{{ $s->pembahasan }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

    </main>
</div>
<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
</body>
</html>
