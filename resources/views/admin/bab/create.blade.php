@extends('layouts.admin')

@section('title', 'Tambah Bab - SahabatBuku')

@section('content')
        <h1 class="mb-6 text-3xl font-extrabold font-jakarta">tambah bab baru</h1>

        <div class="max-w-xl p-8 bg-white shadow-md rounded-xl">
            <form method="POST" action="{{ route('bab.store', ['active_menu' => request()->input('active_menu')]) }}">
                @csrf
                <input type="hidden" name="id_buku" value="{{ $id_buku }}">

                {{-- nomor bab --}}
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium font-jakarta">nomor bab</label>
                    <input type="number"
                           name="nomor_bab"
                           value="{{ old('nomor_bab') }}"
                           placeholder="contoh: 1"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-admin-orange">
                    @error('nomor_bab')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- judul bab --}}
                <div class="mb-8">
                    <label class="block mb-2 text-sm font-medium font-jakarta">judul bab</label>
                    <input type="text"
                           name="judul_bab"
                           value="{{ old('judul_bab') }}"
                           placeholder="contoh: pengenalan sistem"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-admin-orange">
                    @error('judul_bab')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                           class="px-6 py-3 font-bold text-black bg-admin-orange rounded-xl hover:bg-opacity-90 font-jakarta">
                        simpan bab
                    </button>
                    <a href="{{ route('bab.index', ['id_buku' => $id_buku, 'active_menu' => request()->input('active_menu')]) }}"
                       class="px-6 py-3 font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 font-jakarta">
                        batal
                    </a>
                </div>
            </form>
        </div>
@endsection