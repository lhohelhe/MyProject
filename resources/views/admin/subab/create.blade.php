@extends('layouts.admin')

@section('title', 'Tambah Subbab - SahabatBuku')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="mb-6 text-3xl font-black text-black uppercase tracking-wider font-jakarta">Tambah Subbab Baru</h1>

    <div class="bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl p-6 sm:p-8">
        <form method="POST" action="{{ route('subab.store', ['active_menu' => request()->input('active_menu')]) }}" class="space-y-6">
            @csrf
            <input type="hidden" name="id_bab" value="{{ $id_bab }}">

            {{-- Nomor Subbab --}}
            <div>
                <label for="nomor_subbab" class="block mb-2 text-sm font-bold text-black font-jakarta">Nomor Subbab</label>
                <input type="text"
                       id="nomor_subbab"
                       name="nomor_subbab"
                       value="{{ old('nomor_subbab') }}"
                       placeholder="Contoh: 1.1"
                       required
                       class="w-full px-4 py-3 border-2 border-black rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent">
                @error('nomor_subbab')
                    <p class="mt-1 text-sm text-red-500 font-jakarta">{{ $message }}</p>
                @enderror
            </div>

            {{-- Judul Subbab --}}
            <div>
                <label for="judul_subbab" class="block mb-2 text-sm font-bold text-black font-jakarta">Judul Subbab</label>
                <input type="text"
                       id="judul_subbab"
                       name="judul_subbab"
                       value="{{ old('judul_subbab') }}"
                       placeholder="Contoh: Pengenalan Aljabar"
                       required
                       class="w-full px-4 py-3 border-2 border-black rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent">
                @error('judul_subbab')
                    <p class="mt-1 text-sm text-red-500 font-jakarta">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 pt-4">
                <button type="submit"
                        class="px-6 py-3 font-bold text-white bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all font-jakarta">
                    Simpan Subbab
                </button>
                <a href="{{ url()->previous() }}"
                   class="px-6 py-3 font-bold text-black bg-white border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all font-jakarta">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
