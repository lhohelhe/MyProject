@extends('layouts.admin')

@section('title', 'Tambah Simulasi - SahabatBuku')

@section('content')
        <h1 class="mb-6 text-3xl font-black text-black uppercase tracking-wider sm:text-3xl lg:text-4xl font-jakarta lg:mb-10">
            Tambah Simulasi
        </h1>

        <div class="max-w-2xl mx-auto bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl p-6 sm:p-8">
            <form action="{{ route('simulasi.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Judul Simulasi -->
                <div>
                    <label for="judul_simulasi" class="block mb-2 text-sm font-bold text-black font-jakarta">
                        Judul Simulasi
                    </label>
                    <input type="text" 
                           id="judul_simulasi" 
                           name="judul_simulasi" 
                           class="w-full px-4 py-3 border-2 border-black rounded-xl focus:outline-none focus:ring-2 focus:ring-admin-orange"
                           placeholder="Masukkan judul simulasi"
                           value="{{ old('judul_simulasi') }}"
                           required>
                    @error('judul_simulasi')
                        <span class="block mt-2 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Buku -->
                <div>
                    <label for="id_buku" class="block mb-2 text-sm font-bold text-black font-jakarta">
                        Buku
                    </label>
                    <select id="id_buku" 
                            name="id_buku" 
                            class="w-full px-4 py-3 border-2 border-black rounded-xl focus:outline-none focus:ring-2 focus:ring-admin-orange"
                            required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach($buku as $b)
                            <option value="{{ $b->id_buku }}" {{ old('id_buku') == $b->id_buku ? 'selected' : '' }}>
                                {{ $b->judul_buku }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_buku')
                        <span class="block mt-2 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Durasi Menit -->
                <div>
                    <label for="durasi_menit" class="block mb-2 text-sm font-bold text-black font-jakarta">
                        Durasi (menit)
                    </label>
                    <input type="number" 
                           id="durasi_menit" 
                           name="durasi_menit" 
                           class="w-full px-4 py-3 border-2 border-black rounded-xl focus:outline-none focus:ring-2 focus:ring-admin-orange"
                           placeholder="Masukkan durasi dalam menit"
                           value="{{ old('durasi_menit') }}"
                           min="1"
                           max="180"
                           required>
                    @error('durasi_menit')
                        <span class="block mt-2 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Jumlah Soal -->
                <div>
                    <label for="jumlah_soal" class="block mb-2 text-sm font-bold text-black font-jakarta">
                        Jumlah Soal
                    </label>
                    <input type="number" 
                           id="jumlah_soal" 
                           name="jumlah_soal" 
                           class="w-full px-4 py-3 border-2 border-black rounded-xl focus:outline-none focus:ring-2 focus:ring-admin-orange"
                           placeholder="Masukkan jumlah soal"
                           value="{{ old('jumlah_soal') }}"
                           min="5"
                           max="100"
                           required>
                    @error('jumlah_soal')
                        <span class="block mt-2 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block mb-2 text-sm font-bold text-black font-jakarta">
                        Status
                    </label>
                    <select id="status" 
                            name="status" 
                            class="w-full px-4 py-3 border-2 border-black rounded-xl focus:outline-none focus:ring-2 focus:ring-admin-orange"
                            required>
                        <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')
                        <span class="block mt-2 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="flex flex-col gap-3 pt-6 sm:flex-row sm:justify-between">
                    <a href="{{ route('simulasi.index') }}" 
                       class="flex justify-center items-center px-6 py-3 text-lg font-bold text-black bg-white border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all font-jakarta">
                        Batal
                    </a>
                    <button type="submit" 
                            class="flex justify-center items-center px-6 py-3 text-lg font-bold text-white bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all font-jakarta">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
@endsection
