@extends('layouts.admin')

@section('title', 'Kelola Bab - SahabatBuku')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-6 uppercase tracking-widest">
        <a href="{{ route('dashboard-buku.index') }}" class="hover:text-[#F4922A] transition">Semua Buku</a>
        @if($buku)
        <span>›</span>
        <span class="text-black">{{ $buku->judul_buku }}</span>
        <span>›</span>
        <span class="text-[#F4922A]">Daftar Bab</span>
        @else
        <span>›</span>
        <span class="text-[#F4922A]">Semua Bab</span>
        @endif
    </nav>

    {{-- Header --}}
    <div class="flex items-start justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-black text-black font-jakarta">
                {{ $buku ? 'Kelola Bab' : 'Semua Bab' }}
            </h1>
            <p class="text-sm font-bold text-slate-500 mt-1">
                @if($buku)
                    Kelas {{ $buku->kelas }} · {{ $bab->count() }} bab tersedia
                @else
                    {{ $bab->count() }} bab dari seluruh buku · Gunakan shortcut di Data Buku untuk kelola per buku
                @endif
            </p>
        </div>
        @if($buku)
        <a href="{{ route('bab.create', ['id_buku' => $id_buku, 'active_menu' => request()->input('active_menu')]) }}"
           class="flex-shrink-0 px-5 py-2.5 text-sm font-black text-white bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all">
            + Tambah Bab
        </a>
        @endif
    </div>

    @if(session('success'))
    <div class="px-4 py-3 mb-4 text-green-800 bg-green-100 border-2 border-green-400 rounded-xl font-jakarta text-sm font-bold">
        ✓ {{ session('success') }}
    </div>
    @endif

    {{-- Bab cards --}}
    <div class="space-y-4">
        @forelse($bab as $b)
        @php
            $totalSubbab = $b->subab->count();
            $totalMateri = $b->subab->sum(fn($s) => $s->materi->count());
        @endphp
        <div class="bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl overflow-hidden">

            {{-- Bab header --}}
            <div class="flex items-center justify-between px-5 py-4 border-b-2 border-black bg-slate-50">
                <div class="flex items-center gap-4">
                    <span class="w-10 h-10 flex items-center justify-center bg-[#F4922A] border-2 border-black text-white font-black text-sm rounded-lg flex-shrink-0">
                        {{ $b->nomor_bab }}
                    </span>
                    <div>
                        <p class="font-black text-black text-base">{{ $b->judul_bab }}</p>
                        <div class="flex items-center gap-3 mt-1">
                            @if(!$buku)
                            <span class="text-[10px] font-black text-[#F4922A] uppercase tracking-wider">
                                {{ $b->buku->judul_buku ?? '-' }}
                            </span>
                            <span class="text-slate-300">·</span>
                            @endif
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                                {{ $totalSubbab }} subbab
                            </span>
                            <span class="text-slate-300">·</span>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                                {{ $totalMateri }} materi
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('subab.index', ['id_bab' => $b->id_bab]) }}"
                       class="px-3 py-1.5 text-xs font-black text-black bg-white border-2 border-black rounded-lg shadow-[2px_2px_0px_#000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Lihat Subbab
                    </a>
                    <a href="{{ route('bab.edit', ['bab' => $b->id_bab, 'active_menu' => request()->input('active_menu')]) }}"
                       class="px-3 py-1.5 text-xs font-bold text-[#F4922A] bg-white border-2 border-black rounded-lg shadow-[2px_2px_0px_#000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Edit
                    </a>
                    <form action="{{ route('bab.destroy', $b->id_bab) }}" method="POST"
                          onsubmit="return confirm('Hapus Bab {{ $b->nomor_bab }} beserta semua subbab dan materinya?')">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="active_menu" value="{{ request()->input('active_menu') }}">
                        <button type="submit"
                                class="px-3 py-1.5 text-xs font-bold text-white bg-red-500 border-2 border-black rounded-lg shadow-[2px_2px_0px_#000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- Subbab preview --}}
            @if($totalSubbab > 0)
            <div class="px-5 py-3">
                <div class="flex flex-wrap gap-2">
                    @foreach($b->subab->take(5) as $s)
                    <span class="px-2.5 py-1 text-[10px] font-bold text-slate-600 bg-slate-100 border border-slate-200 rounded-full">
                        {{ $s->nomor_subbab }} {{ Str::limit($s->judul_subbab, 25) }}
                    </span>
                    @endforeach
                    @if($totalSubbab > 5)
                    <span class="px-2.5 py-1 text-[10px] font-bold text-slate-400 bg-slate-50 border border-slate-200 rounded-full">
                        +{{ $totalSubbab - 5 }} lainnya
                    </span>
                    @endif
                </div>
            </div>
            @else
            <div class="px-5 py-3">
                <p class="text-xs font-bold text-slate-400 italic">Belum ada subbab —
                    <a href="{{ route('subab.create', ['id_bab' => $b->id_bab]) }}" class="text-[#F4922A] hover:underline">tambah sekarang</a>
                </p>
            </div>
            @endif

        </div>
        @empty
        <div class="p-12 text-center bg-white border-2 border-black rounded-xl">
            <p class="text-slate-400 font-bold text-sm mb-3">Buku ini belum memiliki bab.</p>
            <a href="{{ route('bab.create', ['id_buku' => $id_buku]) }}"
               class="inline-block px-5 py-2.5 text-sm font-black text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all">
                + Tambah Bab Pertama
            </a>
        </div>
        @endforelse
    </div>

</div>
@endsection
