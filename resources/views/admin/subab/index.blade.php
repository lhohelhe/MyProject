@extends('layouts.admin')

@section('title', 'Kelola Subbab - SahabatBuku')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-6 uppercase tracking-widest flex-wrap">
        <a href="{{ route('dashboard-buku.index') }}" class="hover:text-[#F4922A] transition">Semua Buku</a>
        <span>›</span>
        <a href="{{ route('bab.index', ['id_buku' => $bab->id_buku]) }}" class="hover:text-[#F4922A] transition">
            {{ Str::limit($bab->buku->judul_buku ?? '-', 30) }}
        </a>
        <span>›</span>
        <span class="text-black">Bab {{ $bab->nomor_bab }}: {{ Str::limit($bab->judul_bab, 30) }}</span>
        <span>›</span>
        <span class="text-[#F4922A]">Subbab</span>
    </nav>

    {{-- Header --}}
    <div class="flex items-start justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-black text-black font-jakarta">Kelola Subbab</h1>
            <p class="text-sm font-bold text-slate-500 mt-1">
                Bab {{ $bab->nomor_bab }} · {{ $subab->count() }} subbab ·
                {{ $subab->sum(fn($s) => $s->materi->count()) }} materi total
            </p>
        </div>
        <a href="{{ route('subab.create', ['id_bab' => $id_bab]) }}"
           class="flex-shrink-0 px-5 py-2.5 text-sm font-black text-white bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all">
            + Tambah Subbab
        </a>
    </div>

    @if(session('success'))
    <div class="px-4 py-3 mb-4 text-green-800 bg-green-100 border-2 border-green-400 rounded-xl font-jakarta text-sm font-bold">
        ✓ {{ session('success') }}
    </div>
    @endif

    {{-- Subbab list --}}
    <div class="space-y-3">
        @forelse($subab as $s)
        @php
            $jumlahMateri = $s->materi->count();
            $hasMateri    = $jumlahMateri > 0;
        @endphp
        <div class="bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl overflow-hidden">

            <div class="flex items-center justify-between px-5 py-4">
                <div class="flex items-center gap-4 min-w-0">
                    {{-- Nomor badge --}}
                    <span class="flex-shrink-0 px-2.5 py-1 text-xs font-black text-[#F4922A] bg-orange-50 border-2 border-[#F4922A] rounded-lg">
                        {{ $s->nomor_subbab }}
                    </span>
                    <div class="min-w-0">
                        <p class="font-black text-black text-sm truncate">{{ $s->judul_subbab }}</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            @if($hasMateri)
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-green-700 bg-green-50 border border-green-300 px-2 py-0.5 rounded-full">
                                    ✓ {{ $jumlahMateri }} materi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-400 bg-slate-50 border border-slate-200 px-2 py-0.5 rounded-full">
                                    Belum ada materi
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('subab.edit', $s->id_subbab) }}"
                       class="px-3 py-1.5 text-xs font-bold text-black bg-white border-2 border-black rounded-lg shadow-[2px_2px_0px_#000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Edit
                    </a>
                    <form action="{{ route('subab.destroy', $s->id_subbab) }}" method="POST"
                          onsubmit="return confirm('Hapus subbab ini beserta {{ $jumlahMateri }} materinya?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1.5 text-xs font-bold text-white bg-red-500 border-2 border-black rounded-lg shadow-[2px_2px_0px_#000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- Materi preview strip --}}
            @if($hasMateri)
            <div class="px-5 py-2.5 bg-slate-50 border-t-2 border-black">
                <div class="flex flex-wrap gap-2">
                    @foreach($s->materi->take(3) as $m)
                    <span class="text-[10px] font-bold text-slate-600 bg-white border border-slate-300 px-2 py-0.5 rounded-full">
                        {{ Str::limit($m->judul_materi, 35) }}
                    </span>
                    @endforeach
                    @if($jumlahMateri > 3)
                    <span class="text-[10px] font-bold text-slate-400 bg-white border border-slate-200 px-2 py-0.5 rounded-full">
                        +{{ $jumlahMateri - 3 }} lainnya
                    </span>
                    @endif
                </div>
            </div>
            @endif
        </div>
        @empty
        <div class="p-12 text-center bg-white border-2 border-black rounded-xl">
            <p class="text-slate-400 font-bold text-sm mb-3">Bab ini belum memiliki subbab.</p>
            <a href="{{ route('subab.create', ['id_bab' => $id_bab]) }}"
               class="inline-block px-5 py-2.5 text-sm font-black text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all">
                + Tambah Subbab Pertama
            </a>
        </div>
        @endforelse
    </div>

</div>
@endsection
