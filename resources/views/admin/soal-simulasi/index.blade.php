@extends('layouts.admin')

@section('title', 'Kelola Soal Simulasi - SahabatBuku')

@section('content')
        <h1 class="mb-6 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta lg:mb-10">
            Kelola Soal — {{ $simulasi->judul_simulasi }}
        </h1>

        <!-- Info Soal -->
        <div class="p-4 mb-8 bg-white shadow-md rounded-xl lg:p-4">
            <p class="text-xl font-semibold text-gray-800 font-jakarta">
                Total Soal: <span class="ml-2">{{ $soal->total() }}</span>
            </p>
        </div>

        <!-- Form Tambah Soal -->
        <div class="p-6 mb-8 bg-white shadow-md rounded-2xl sm:p-8">
            <h2 class="mb-6 text-2xl font-bold text-gray-800 font-jakarta">Tambah Soal Baru</h2>
            
            <form action="/admin/simulasi/{{ $simulasi->id_simulasi }}/soal" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="id_simulasi" value="{{ $simulasi->id_simulasi }}">

                <!-- Pertanyaan -->
                <div>
                    <label for="pertanyaan" class="block mb-2 text-lg font-semibold text-gray-800 font-jakarta">
                        Pertanyaan
                    </label>
                    <textarea id="pertanyaan" 
                              name="pertanyaan" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-admin-orange"
                              placeholder="Masukkan pertanyaan soal"
                              rows="4"
                              value="{{ old('pertanyaan') }}"
                              required></textarea>
                    @error('pertanyaan')
                        <span class="block mt-2 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Grid Opsi -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <!-- Opsi A -->
                    <div>
                        <label for="opsi_a" class="block mb-2 text-lg font-semibold text-gray-800 font-jakarta">
                            Opsi A
                        </label>
                        <input type="text" 
                               id="opsi_a" 
                               name="opsi_a" 
                               class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-admin-orange"
                               placeholder="Masukkan opsi A"
                               value="{{ old('opsi_a') }}"
                               required>
                        @error('opsi_a')
                            <span class="block mt-2 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Opsi B -->
                    <div>
                        <label for="opsi_b" class="block mb-2 text-lg font-semibold text-gray-800 font-jakarta">
                            Opsi B
                        </label>
                        <input type="text" 
                               id="opsi_b" 
                               name="opsi_b" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-admin-orange"
                               placeholder="Masukkan opsi B"
                               value="{{ old('opsi_b') }}"
                               required>
                        @error('opsi_b')
                            <span class="block mt-2 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Opsi C -->
                    <div>
                        <label for="opsi_c" class="block mb-2 text-lg font-semibold text-gray-800 font-jakarta">
                            Opsi C
                        </label>
                        <input type="text" 
                               id="opsi_c" 
                               name="opsi_c" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-admin-orange"
                               placeholder="Masukkan opsi C"
                               value="{{ old('opsi_c') }}"
                               required>
                        @error('opsi_c')
                            <span class="block mt-2 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Opsi D -->
                    <div>
                        <label for="opsi_d" class="block mb-2 text-lg font-semibold text-gray-800 font-jakarta">
                            Opsi D
                        </label>
                        <input type="text" 
                               id="opsi_d" 
                               name="opsi_d" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-admin-orange"
                               placeholder="Masukkan opsi D"
                               value="{{ old('opsi_d') }}"
                               required>
                        @error('opsi_d')
                            <span class="block mt-2 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Kunci Jawaban -->
                <div>
                    <label for="kunci_jawaban" class="block mb-2 text-lg font-semibold text-gray-800 font-jakarta">
                        Kunci Jawaban
                    </label>
                    <select id="kunci_jawaban" 
                            name="kunci_jawaban" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-admin-orange"
                            required>
                        <option value="">-- Pilih Jawaban Benar --</option>
                        <option value="a" {{ old('kunci_jawaban') === 'a' ? 'selected' : '' }}>A</option>
                        <option value="b" {{ old('kunci_jawaban') === 'b' ? 'selected' : '' }}>B</option>
                        <option value="c" {{ old('kunci_jawaban') === 'c' ? 'selected' : '' }}>C</option>
                        <option value="d" {{ old('kunci_jawaban') === 'd' ? 'selected' : '' }}>D</option>
                    </select>
                    @error('kunci_jawaban')
                        <span class="block mt-2 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Pembahasan -->
                <div>
                    <label for="pembahasan" class="block mb-2 text-lg font-semibold text-gray-800 font-jakarta">
                        Pembahasan <span class="text-gray-500">(Opsional)</span>
                    </label>
                    <textarea id="pembahasan" 
                              name="pembahasan" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-admin-orange"
                              placeholder="Masukkan pembahasan soal"
                              rows="4"
                              value="{{ old('pembahasan') }}"></textarea>
                    @error('pembahasan')
                        <span class="block mt-2 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-6 py-3 text-lg font-bold text-black transition rounded-lg bg-admin-orange hover:bg-opacity-90 font-jakarta">
                        Tambah Soal
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Soal -->
        <div class="overflow-hidden bg-white shadow-md rounded-2xl">
            <div class="p-6">
                <h2 class="mb-6 text-2xl font-bold text-gray-800 font-jakarta">Daftar Soal</h2>

                <!-- Header Tabel Desktop -->
                <div class="hidden p-4 mb-4 rounded-lg bg-gray-50 lg:block">
                    <div class="grid grid-cols-12 gap-4 text-lg font-semibold text-center font-jakarta">
                        <div>No</div>
                        <div class="col-span-7 text-left">Pertanyaan</div>
                        <div>Kunci</div>
                        <div class="col-span-3">Aksi</div>
                    </div>
                </div>

                <!-- List Soal -->
                @forelse($soal as $index => $s)
                <div class="p-4 mb-4 border border-gray-200 rounded-lg">
                    
                    <!-- Mobile View -->
                    <div class="space-y-3 lg:hidden">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-gray-600">No:</span>
                            <span class="font-medium">{{ $loop->iteration }}</span>
                        </div>
                        <div class="flex items-start justify-between">
                            <span class="font-medium text-gray-600">Pertanyaan:</span>
                            <span class="max-w-xs text-right">{{ Str::limit($s->pertanyaan, 50) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-gray-600">Kunci:</span>
                            <span class="px-3 py-1 text-sm font-bold text-white rounded-full bg-admin-green">{{ strtoupper($s->kunci_jawaban) }}</span>
                        </div>
                        <div class="flex justify-center pt-4 mt-4 border-t">
                            <form action="/admin/simulasi/soal/{{ $s->id_soal_simulasi }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus soal ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="transition-opacity hover:opacity-80">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="text-admin-red fill-admin-red">
                                        <path d="M3 6h18"/>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Desktop View -->
                    <div class="items-center hidden grid-cols-12 gap-4 text-center lg:grid font-jakarta">
                        <div class="font-medium">{{ $loop->iteration }}</div>
                        <div class="col-span-7 font-medium text-left">{{ Str::limit($s->pertanyaan, 50) }}</div>
                        <div>
                            <span class="px-3 py-1 text-sm font-bold text-white rounded-full bg-admin-green">{{ strtoupper($s->kunci_jawaban) }}</span>
                        </div>
                        <div class="flex justify-center col-span-3">
                            <form action="/admin/simulasi/soal/{{ $s->id_soal_simulasi }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus soal ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="transition-opacity hover:opacity-80">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="text-admin-red fill-admin-red">
                                        <path d="M3 6h18"/>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center">
                    <p class="text-lg text-gray-500 font-jakarta">Belum ada soal terdaftar</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-8 text-center">
            <a href="{{ route('simulasi.index') }}" 
               class="inline-block px-8 py-3 text-lg font-bold text-gray-700 transition bg-gray-300 rounded-lg hover:bg-opacity-90 font-jakarta">
                Kembali
            </a>
        </div>
@endsection
