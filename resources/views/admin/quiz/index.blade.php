@extends('layouts.admin')

@section('title', 'Data Quiz - SahabatBuku')

@section('content')
<div class="max-w-5xl mx-auto">

    <h1 class="mb-6 text-2xl font-black text-black uppercase tracking-wider font-jakarta">
        Data Quiz
    </h1>

    @if(session('success'))
    <div class="px-4 py-3 mb-4 text-green-800 bg-green-100 border-2 border-green-400 rounded-xl font-jakarta text-sm font-bold">
        ✓ {{ session('success') }}
    </div>
    @endif

    {{-- Header tabel --}}
    <div class="hidden p-4 mb-3 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl lg:block">
        <div class="grid grid-cols-12 gap-4 text-sm font-black text-black uppercase tracking-wider text-center font-jakarta">
            <div class="col-span-1">No</div>
            <div class="col-span-4 text-left">Judul Quiz</div>
            <div class="col-span-5 text-left">Bab</div>
            <div class="col-span-2 text-center">Aksi</div>
        </div>
    </div>

    {{-- List --}}
    @forelse($quiz as $index => $q)
    <div class="p-4 mb-3 bg-white border-2 border-black rounded-xl font-jakarta">

        {{-- Desktop --}}
        <div class="items-center hidden grid-cols-12 gap-4 text-center lg:grid">
            <div class="col-span-1 font-black text-black">{{ $quiz->firstItem() + $index }}</div>
            <div class="col-span-4 font-black text-black text-left">{{ $q->judul_quiz }}</div>
            <div class="col-span-5 font-bold text-left text-sm text-slate-600">
                {{ $q->bab->buku->judul_buku ?? '-' }} &middot; Bab {{ $q->bab->nomor_bab ?? '-' }}: {{ $q->bab->judul_bab ?? '-' }}
            </div>
            <div class="col-span-2 flex justify-center gap-2">
                <a href="{{ route('admin.quiz.show', $q->id_quiz) }}"
                   class="px-3 py-1.5 text-xs font-black text-white bg-[#F4922A] border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                    Lihat Soal
                </a>
                <form action="{{ route('admin.quiz.destroy', $q->id_quiz) }}" method="POST"
                      onsubmit="return confirm('Hapus quiz ini beserta semua soalnya?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1.5 text-xs font-black text-white bg-red-500 border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        {{-- Mobile --}}
        <div class="space-y-2 lg:hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-400 uppercase tracking-wider">No</span>
                <span class="font-black text-black text-sm">{{ $quiz->firstItem() + $index }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Judul</span>
                <span class="font-black text-black text-sm">{{ $q->judul_quiz }}</span>
            </div>
            <div class="flex items-start justify-between gap-4">
                <span class="text-xs font-black text-slate-400 uppercase tracking-wider flex-shrink-0">Bab</span>
                <span class="font-bold text-black text-xs text-right">{{ $q->bab->buku->judul_buku ?? '-' }} · Bab {{ $q->bab->nomor_bab ?? '-' }}</span>
            </div>
            <div class="pt-2">
                <a href="{{ route('admin.quiz.show', $q->id_quiz) }}"
                   class="block w-full text-center py-2 text-xs font-black text-white bg-[#F4922A] border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                    Lihat Soal
                </a>
            </div>
        </div>

    </div>
    @empty
    <div class="p-8 text-center bg-white border-2 border-black rounded-xl">
        <p class="font-bold text-slate-400">Belum ada quiz terdaftar</p>
    </div>
    @endforelse

    @if($quiz->hasPages())
    <div class="mt-6">{{ $quiz->links() }}</div>
    @endif

</div>
@endsection
