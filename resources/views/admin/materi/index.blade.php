@extends('layouts.admin')

@section('title', 'Data Materi - SahabatBuku')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-6 uppercase tracking-widest flex-wrap">
        <a href="{{ route('dashboard-buku.index') }}" class="hover:text-[#F4922A] transition">Semua Buku</a>
        <span>›</span>
        <span class="text-[#F4922A]">Semua Materi</span>
    </nav>

    {{-- Header --}}
    <div class="flex items-start justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-black text-black font-jakarta">Data Materi</h1>
            <p class="text-sm font-bold text-slate-500 mt-1">
                Total {{ $materi->total() }} materi di seluruh buku
            </p>
        </div>
        <a href="{{ route('materi.create') }}"
           class="flex-shrink-0 px-5 py-2.5 text-sm font-black text-white bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all">
            + Tambah Materi
        </a>
    </div>

    @if(session('success'))
    <div class="px-4 py-3 mb-4 text-green-800 bg-green-100 border-2 border-green-400 rounded-xl font-jakarta text-sm font-bold">
        ✓ {{ session('success') }}
    </div>
    @endif

    {{-- Materi list --}}
    <div class="space-y-3">
        @forelse($materi as $item)
        @php
            $panjangIsi = mb_strlen(strip_tags($item->isi ?? ''));
            $preview    = Str::limit(strip_tags($item->isi ?? ''), 120);
        @endphp
        <div class="bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl overflow-hidden">

            {{-- Header row --}}
            <div class="flex items-start justify-between px-5 py-4 gap-4">
                <div class="flex-1 min-w-0">
                    {{-- Breadcrumb konteks --}}
                    <div class="flex items-center gap-1.5 mb-2 flex-wrap">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">
                            {{ Str::limit($item->subab->bab->buku->judul_buku ?? '-', 25) }}
                        </span>
                        <span class="text-slate-300 text-[10px]">›</span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">
                            Bab {{ $item->subab->bab->nomor_bab ?? '-' }}
                        </span>
                        <span class="text-slate-300 text-[10px]">›</span>
                        <span class="text-[10px] font-black text-[#F4922A] uppercase tracking-wider">
                            {{ $item->subab->nomor_subbab ?? '' }} {{ Str::limit($item->subab->judul_subbab ?? '-', 20) }}
                        </span>
                    </div>

                    {{-- Judul materi --}}
                    <p class="font-black text-black text-sm">{{ $item->judul_materi }}</p>

                    {{-- Info panjang konten --}}
                    <div class="flex items-center gap-3 mt-1.5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                            {{ number_format($panjangIsi) }} karakter
                        </span>
                        @if($item->gambar)
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-blue-600 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full">
                            ⊞ Ada gambar
                        </span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('materi.edit', $item->id_materi) }}"
                       class="px-3 py-1.5 text-xs font-bold text-black bg-white border-2 border-black rounded-lg shadow-[2px_2px_0px_#000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Edit
                    </a>
                    <form action="{{ route('materi.destroy', $item->id_materi) }}" method="POST" class="inline"
                          onsubmit="return confirm('Hapus materi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1.5 text-xs font-bold text-white bg-red-500 border-2 border-black rounded-lg shadow-[2px_2px_0px_#000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- Preview konten --}}
            @if($preview)
            <div class="px-5 py-3 bg-slate-50 border-t-2 border-black">
                <p class="text-xs text-slate-500 leading-relaxed font-medium">{{ $preview }}</p>
            </div>
            @endif

        </div>
        @empty
        <div class="p-12 text-center bg-white border-2 border-black rounded-xl">
            <p class="text-slate-400 font-bold text-sm">Belum ada materi tersimpan.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($materi->hasPages())
    <div class="mt-8">
        {{ $materi->links('pagination::tailwind') }}
    </div>
    @endif

</div>
@endsection
