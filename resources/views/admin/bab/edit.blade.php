@extends('layouts.admin')

@section('title', 'Edit Bab - SahabatBuku')

@section('content')
        <h1 class="mb-6 text-3xl font-black text-black uppercase tracking-wider font-jakarta">edit bab</h1>

        <div class="max-w-xl p-8 bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl">
            <form method="POST" action="{{ route('bab.update', ['bab' => $bab->id_bab, 'active_menu' => request()->input('active_menu')]) }}">
                @csrf
                @method('PUT')

                {{-- nomor bab --}}
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-bold text-black font-jakarta">nomor bab</label>
                    <input type="number"
                           name="nomor_bab"
                           value="{{ old('nomor_bab', $bab->nomor_bab) }}"
                           placeholder="contoh: 1"
                           class="w-full px-4 py-3 border-2 border-black rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-admin-orange">
                    @error('nomor_bab')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- judul bab --}}
                <div class="mb-8">
                    <label class="block mb-2 text-sm font-bold text-black font-jakarta">judul bab</label>
                    <input type="text"
                           name="judul_bab"
                           value="{{ old('judul_bab', $bab->judul_bab) }}"
                           placeholder="contoh: pengenalan sistem"
                           class="w-full px-4 py-3 border-2 border-black rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-admin-orange">
                    @error('judul_bab')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                           class="px-6 py-3 font-bold text-white bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all font-jakarta">
                        perbarui bab
                    </button>
                    <a href="{{ route('bab.index', ['id_buku' => $bab->id_buku, 'active_menu' => request()->input('active_menu')]) }}"
                       class="px-6 py-3 font-bold text-black bg-white border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all font-jakarta">
                        batal
                    </a>
                </div>
            </form>
        </div>
@endsection
