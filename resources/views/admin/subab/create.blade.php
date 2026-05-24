@extends('layouts.admin')

@section('title', 'Tambah Subbab - SahabatBuku')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="mb-6 text-3xl font-extrabold text-slate-800 font-jakarta">Tambah Subbab Baru</h1>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
        <form method="POST" action="{{ route('subab.store', ['active_menu' => request()->input('active_menu')]) }}" class="space-y-6">
            @csrf
            <input type="hidden" name="id_bab" value="{{ $id_bab }}">

            {{-- Nomor Subbab --}}
            <div>
                <label for="nomor_subbab" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Nomor Subbab</label>
                <input type="text"
                       id="nomor_subbab"
                       name="nomor_subbab"
                       value="{{ old('nomor_subbab') }}"
                       placeholder="Contoh: 1.1"
                       required
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent">
                @error('nomor_subbab')
                    <p class="mt-1 text-sm text-red-500 font-jakarta">{{ $message }}</p>
                @enderror
            </div>

            {{-- Judul Subbab --}}
            <div>
                <label for="judul_subbab" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Judul Subbab</label>
                <input type="text"
                       id="judul_subbab"
                       name="judul_subbab"
                       value="{{ old('judul_subbab') }}"
                       placeholder="Contoh: Pengenalan Aljabar"
                       required
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent">
                @error('judul_subbab')
                    <p class="mt-1 text-sm text-red-500 font-jakarta">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 pt-4">
                <button type="submit"
                        class="px-6 py-3 font-semibold text-white bg-[#F4922A] rounded-xl hover:bg-opacity-90 transition-all font-jakarta">
                    Simpan Subbab
                </button>
                <a href="{{ url()->previous() }}"
                   class="px-6 py-3 font-semibold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-all font-jakarta">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection