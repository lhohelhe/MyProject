@extends('layouts.admin')

@section('title', 'Edit Subbab - SahabatBuku')

@section('content')
        <div class="max-w-2xl mx-auto">
            <h1 class="mb-8 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta">
                Edit Subbab
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
                <form method="POST" action="{{ route('subab.update', ['subab' => $subab->id_subbab, 'active_menu' => request()->input('active_menu')]) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nomor Subbab Field -->
                    <div>
                        <label for="nomor_subbab" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Nomor Subbab</label>
                        <input 
                            type="text" 
                            id="nomor_subbab"
                            name="nomor_subbab" 
                            value="{{ old('nomor_subbab', $subab->nomor_subbab) }}"
                            required
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent"
                        />
                    </div>

                    <!-- Judul Subbab Field -->
                    <div>
                        <label for="judul_subbab" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Judul Subbab</label>
                        <input 
                            type="text" 
                            id="judul_subbab"
                            name="judul_subbab" 
                            value="{{ old('judul_subbab', $subab->judul_subbab) }}"
                            required
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent"
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