@extends('layouts.admin')

@section('title', 'Data Materi - SahabatBuku')

@section('content')
    <h1 class="mb-6 text-3xl font-extrabold lg:text-4xl font-jakarta lg:mb-10">
        Data Materi
    </h1>

    <!-- Header -->
    <div class="flex flex-col items-start justify-between gap-4 p-2 mb-6 bg-white shadow-md rounded-xl lg:flex-row lg:items-center">
        <div class="text-2xl font-semibold font-jakarta">
            Total Materi: <span id="total-materi">{{ $materi->total() }}</span>
        </div>
        <a href="{{ route('materi.create') }}"
           class="flex items-center gap-3 px-4 py-3 text-xl font-bold text-black bg-admin-orange rounded-xl hover:bg-opacity-90 font-jakarta">
            <span>Tambah Materi</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 lg:w-8 lg:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14"/>
            </svg>
        </a>
    </div>

    <!-- Header Tabel -->
    <div class="hidden p-4 mb-4 bg-white shadow-md lg:block rounded-2xl">
        <div class="grid grid-cols-5 gap-4 text-xl font-semibold text-center font-jakarta">
            <div>Judul</div>
            <div>Subbab</div>
            <div>Bab</div>
            <div>Buku</div>
            <div>Aksi</div>
        </div>
    </div>

    <!-- LIST DARI API -->
    <div id="list-materi">
        @forelse($materi as $item)
        <div class="p-4 mb-4 bg-white shadow-md rounded-xl">
            <div class="grid items-center grid-cols-5 gap-4 text-center font-jakarta">
                <div class="text-left pl-2">{{ $item->judul_materi }}</div>
                <div>{{ $item->subbab->nama ?? '-' }}</div>
                <div>{{ $item->subbab->bab->nama ?? '-' }}</div>
                <div>{{ $item->subbab->bab->buku->judul ?? '-' }}</div>
                <div class="flex justify-center items-center gap-4 flex-wrap">
                    <a href="{{ route('materi.edit', $item->id) }}" class="text-[#F4922A] hover:text-[#d37c1e] mr-3" title="Edit">
                        <i data-lucide="edit-2" class="w-5 h-5 inline"></i>
                    </a>
                    <form action="{{ route('materi.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus materi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                            <i data-lucide="trash-2" class="w-5 h-5 inline"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="p-8 text-center bg-white shadow-md rounded-2xl">
            <p class="text-2xl text-gray-500 font-jakarta">Tidak ada materi.</p>
        </div>
        @endforelse

        {{ $materi->links('pagination::tailwind') }}
    </div>
@endsection
