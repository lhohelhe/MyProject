@extends('layouts.admin')

@section('title', 'Kelola Soal Simulasi - SahabatBuku')

@section('content')
<div class="max-w-5xl mx-auto">

    <h1 class="mb-2 text-2xl font-black text-black uppercase tracking-wider font-jakarta">
        Kelola Soal
    </h1>
    <p class="text-sm font-bold text-[#F4922A] mb-6">{{ $simulasi->judul_simulasi }}</p>

    {{-- Stat bar --}}
    <div class="flex items-center p-4 mb-6 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl font-jakarta">
        <p class="text-sm font-black text-black uppercase tracking-wider">
            Total Soal: <span class="text-[#F4922A]">{{ $soal->total() }}</span>
        </p>
    </div>

    {{-- Form Tambah Soal --}}
    <div class="p-6 mb-6 bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl sm:p-8">
        <h2 class="mb-5 text-sm font-black text-black uppercase tracking-wider font-jakarta">Tambah Soal Baru</h2>

        <form action="/admin/simulasi/{{ $simulasi->id_simulasi }}/soal" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="id_simulasi" value="{{ $simulasi->id_simulasi }}">

            <div>
                <label class="block mb-1.5 text-xs font-black text-black uppercase tracking-wider font-jakarta">Pertanyaan</label>
                <textarea name="pertanyaan" rows="3" required
                          class="w-full px-4 py-3 text-sm border-2 border-black rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A]"
                          placeholder="Masukkan pertanyaan soal">{{ old('pertanyaan') }}</textarea>
                @error('pertanyaan')<p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $key => $label)
                <div>
                    <label class="block mb-1.5 text-xs font-black text-black uppercase tracking-wider font-jakarta">Opsi {{ $label }}</label>
                    <input type="text" name="opsi_{{ $key }}" value="{{ old('opsi_' . $key) }}" required
                           class="w-full px-4 py-3 text-sm border-2 border-black rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A]"
                           placeholder="Masukkan opsi {{ $label }}">
                    @error('opsi_' . $key)<p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>@enderror
                </div>
                @endforeach
            </div>

            <div>
                <label class="block mb-1.5 text-xs font-black text-black uppercase tracking-wider font-jakarta">Kunci Jawaban</label>
                <select name="kunci_jawaban" required
                        class="w-full px-4 py-3 text-sm border-2 border-black rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A]">
                    <option value="">-- Pilih Jawaban Benar --</option>
                    @foreach(['A','B','C','D'] as $opt)
                    <option value="{{ $opt }}" {{ old('kunci_jawaban') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
                @error('kunci_jawaban')<p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block mb-1.5 text-xs font-black text-black uppercase tracking-wider font-jakarta">Pembahasan <span class="text-slate-400 normal-case font-bold">(opsional)</span></label>
                <textarea name="pembahasan" rows="3"
                          class="w-full px-4 py-3 text-sm border-2 border-black rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A]"
                          placeholder="Masukkan pembahasan soal">{{ old('pembahasan') }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-3 text-sm font-black text-white bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all font-jakarta">
                    Tambah Soal
                </button>
            </div>
        </form>
    </div>

    {{-- Daftar Soal --}}
    <div class="bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b-2 border-black">
            <h2 class="text-sm font-black text-black uppercase tracking-wider font-jakarta">Daftar Soal</h2>
        </div>

        <div class="p-4 space-y-3">
            {{-- Header desktop --}}
            <div class="hidden p-3 bg-slate-50 border-2 border-black rounded-xl lg:block">
                <div class="grid grid-cols-12 gap-4 text-xs font-black text-black uppercase tracking-wider text-center font-jakarta">
                    <div>No</div>
                    <div class="col-span-7 text-left">Pertanyaan</div>
                    <div>Kunci</div>
                    <div class="col-span-3">Aksi</div>
                </div>
            </div>

            @forelse($soal as $s)
            <div class="p-4 bg-white border-2 border-black rounded-xl font-jakarta">

                {{-- Desktop --}}
                <div class="items-center hidden grid-cols-12 gap-4 text-center lg:grid">
                    <div class="font-black text-black">{{ $loop->iteration }}</div>
                    <div class="col-span-7 font-bold text-black text-left text-sm">{{ Str::limit($s->pertanyaan, 80) }}</div>
                    <div>
                        <span class="w-7 h-7 inline-flex items-center justify-center font-black text-white bg-[#F4922A] border-2 border-black rounded-lg text-xs">
                            {{ strtoupper($s->kunci_jawaban) }}
                        </span>
                    </div>
                    <div class="col-span-3 flex justify-center">
                        <form action="/admin/simulasi/soal/{{ $s->id_soal }}" method="POST"
                              onsubmit="return confirm('Hapus soal ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1.5 text-xs font-black text-white bg-red-500 border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Mobile --}}
                <div class="space-y-2 lg:hidden">
                    <p class="text-sm font-bold text-black">{{ Str::limit($s->pertanyaan, 80) }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Kunci:</span>
                        <span class="w-6 h-6 inline-flex items-center justify-center font-black text-white bg-[#F4922A] border-2 border-black rounded-lg text-xs">
                            {{ strtoupper($s->kunci_jawaban) }}
                        </span>
                    </div>
                    <form action="/admin/simulasi/soal/{{ $s->id_soal }}" method="POST"
                          onsubmit="return confirm('Hapus soal ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full py-2 text-xs font-black text-white bg-red-500 border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
            @empty
            <div class="p-8 text-center">
                <p class="font-bold text-slate-400 text-sm">Belum ada soal terdaftar</p>
            </div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('simulasi.index') }}"
           class="inline-block px-6 py-3 text-sm font-black text-black bg-white border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all font-jakarta">
            ← Kembali ke Simulasi
        </a>
    </div>

</div>
@endsection
