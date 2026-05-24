@extends('layouts.admin')

@section('title', 'Tambah Materi - SahabatBuku')

@section('content')
        <div class="max-w-2xl mx-auto">
            <h1 class="mb-8 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta">
                Tambah Materi
            </h1>

            @if ($errors->any())
            <div class="p-4 mb-6 border-l-4 border-red-500 bg-red-50">
                <ul class="text-red-700 list-disc list-inside font-jakarta">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
                <form action="{{ route('materi.store', ['active_menu' => request()->input('active_menu')]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Hidden id_subbab -->
                    <input type="hidden" name="id_subbab" value="{{ $id_subbab }}">

                    <!-- Judul Materi Field -->
                    <div>
                        <label for="judul_materi" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Judul Materi</label>
                        <input 
                            type="text" 
                            id="judul_materi"
                            name="judul_materi" 
                            value="{{ old('judul_materi') }}"
                            required
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent"
                        />
                    </div>

                    <!-- Isi Materi Field -->
                    <div>
                        <label for="isi" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Isi Materi</label>
                        <textarea 
                            id="isi"
                            name="isi" 
                            rows="8"
                            required
                            class="w-full p-4 text-base border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent font-jakarta"
                        >{{ old('isi') }}</textarea>
                    </div>

                    <!-- Gambar Field -->
                    <div>
                        <label for="gambar" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Gambar (opsional)</label>
                        <input 
                            type="file" 
                            id="gambar"
                            name="gambar" 
                            accept="image/*"
                            class="w-full text-base text-gray-500 cursor-pointer font-jakarta file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200"
                        />
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-6">
                        <button type="submit" class="flex-1 py-3 text-lg font-bold text-white bg-admin-orange hover:bg-opacity-90 rounded-xl transition-all font-jakarta">
                            Simpan
                        </button>
                        <a href="{{ url()->previous() }}" class="flex-1 py-3 text-lg font-bold text-center text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all font-jakarta">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
@endsection