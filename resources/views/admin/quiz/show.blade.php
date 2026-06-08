@extends('layouts.admin')

@section('title', $quiz->judul_quiz . ' - SahabatBuku')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 font-jakarta">{{ $quiz->judul_quiz }}</h1>
            <p class="text-sm text-slate-500 mt-1 font-jakarta">
                {{ $quiz->bab->buku->judul_buku ?? '-' }} &middot;
                Bab {{ $quiz->bab->nomor_bab ?? '-' }}: {{ $quiz->bab->judul_bab ?? '-' }}
            </p>
        </div>
        <a href="{{ route('admin.quiz.index') }}"
           class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition flex items-center gap-1">
            ← Kembali
        </a>
    </div>

    {{-- Soal List --}}
    <div class="space-y-5">
        @forelse($quiz->soal as $i => $soal)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 font-jakarta">

            <div class="flex items-start gap-3 mb-4">
                <span class="flex-shrink-0 w-7 h-7 rounded-lg bg-[#F4922A] text-white text-xs font-bold flex items-center justify-center">
                    {{ $i + 1 }}
                </span>
                <p class="text-sm font-semibold text-slate-800 leading-relaxed">{{ $soal->pertanyaan }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-4 pl-10">
                @foreach(['a' => $soal->opsi_a, 'b' => $soal->opsi_b, 'c' => $soal->opsi_c, 'd' => $soal->opsi_d] as $key => $opsi)
                <div class="flex items-start gap-2 px-3 py-2 rounded-xl text-sm
                    {{ strtolower($soal->kunci_jawaban) === $key
                        ? 'bg-green-50 border border-green-200 text-green-700 font-semibold'
                        : 'bg-slate-50 text-slate-600' }}">
                    <span class="font-bold uppercase flex-shrink-0">{{ $key }}.</span>
                    <span>{{ $opsi }}</span>
                </div>
                @endforeach
            </div>

            @if($soal->pembahasan)
            <div class="pl-10">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Pembahasan</p>
                <p class="text-xs text-slate-500 leading-relaxed">{{ $soal->pembahasan }}</p>
            </div>
            @endif

            <div class="pl-10 mt-3 flex items-center gap-2">
                <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-full
                    {{ $soal->difficulty === 'easy'
                        ? 'bg-green-100 text-green-600'
                        : ($soal->difficulty === 'medium'
                            ? 'bg-yellow-100 text-yellow-600'
                            : 'bg-red-100 text-red-600') }}">
                    {{ ucfirst($soal->difficulty) }}
                </span>
                <span class="text-[10px] text-slate-400">
                    Kunci: <span class="font-bold text-slate-600 uppercase">{{ $soal->kunci_jawaban }}</span>
                </span>
            </div>

        </div>
        @empty
        <div class="bg-white rounded-2xl p-8 text-center border border-slate-100">
            <p class="text-slate-400 text-sm">Belum ada soal untuk quiz ini</p>
        </div>
        @endforelse
    </div>

</div>
@endsection
