@extends('layouts.admin')

@section('title', 'Edit Flashcard - SahabatBuku')

@section('content')
<div class="max-w-2xl mx-auto">

    <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-6 uppercase tracking-widest">
        <a href="{{ route('admin.flashcard.index') }}" class="hover:text-[#F4922A] transition">Kelola Flashcard</a>
        <span>›</span>
        <span class="text-[#F4922A]">Edit</span>
    </nav>

    <h1 class="mb-2 text-2xl font-black text-black uppercase tracking-wider font-jakarta">Edit Flashcard</h1>
    <p class="text-sm font-bold text-slate-500 mb-6">
        {{ $flashcard->subab->bab->buku->judul_buku ?? '-' }} ›
        Bab {{ $flashcard->subab->bab->nomor_bab ?? '-' }} ›
        {{ $flashcard->subab->judul_subbab ?? '-' }}
    </p>

    @if($errors->any())
    <div class="px-4 py-3 mb-4 text-red-800 bg-red-100 border-2 border-red-400 rounded-xl font-jakarta text-sm font-bold">
        @foreach($errors->all() as $e)<p>✗ {{ $e }}</p>@endforeach
    </div>
    @endif

    <div class="bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl p-6">
        <form action="{{ route('admin.flashcard.update', $flashcard->id_flashcard) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-black text-black uppercase tracking-wider mb-2">Pertanyaan</label>
                <textarea name="pertanyaan" rows="4" required
                          class="w-full px-4 py-3 text-sm font-bold border-2 border-black rounded-xl focus:outline-none focus:ring-2 focus:ring-[#F4922A] font-jakarta resize-y">{{ old('pertanyaan', $flashcard->pertanyaan) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-black text-black uppercase tracking-wider mb-2">Jawaban</label>
                <textarea name="jawaban" rows="4" required
                          class="w-full px-4 py-3 text-sm font-bold border-2 border-black rounded-xl focus:outline-none focus:ring-2 focus:ring-[#F4922A] font-jakarta resize-y">{{ old('jawaban', $flashcard->jawaban) }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-3 text-sm font-black text-white bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.flashcard.index') }}"
                   class="flex-1 py-3 text-sm font-black text-center text-black bg-white border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
