@extends('layouts.admin')

@section('title', 'Tambah Materi - SahabatBuku')

@section('content')
<div class="max-w-2xl mx-auto" x-data="materiEditor()">
    <h1 class="mb-8 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta">Tambah Materi</h1>

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
            <div x-data="cascadeMateri()">
                <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Buku</label>
                        <select x-model="selectedBuku" @change="fetchBab()" class="w-full px-4 py-3 border border-slate-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent" required>
                            <option value="">-- Pilih Buku --</option>
                            <template x-for="b in daftarBuku" :key="b.id_buku">
                                <option :value="b.id_buku" x-text="b.judul_buku"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Bab</label>
                        <select x-model="selectedBab" @change="fetchSubbab()" class="w-full px-4 py-3 border border-slate-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent" required>
                            <option value="">-- Pilih Bab --</option>
                            <template x-for="b in daftarBab" :key="b.id_bab">
                                <option :value="b.id_bab" x-text="'Bab ' + b.nomor_bab + ' - ' + b.judul_bab"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Subbab</label>
                        <select x-model="selectedSubbab" name="id_subbab" class="w-full px-4 py-3 border border-slate-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent" required>
                            <option value="">-- Pilih Subbab --</option>
                            <template x-for="s in daftarSubbab" :key="s.id_subbab">
                                <option :value="s.id_subbab" x-text="s.nomor_subbab + ' ' + s.judul_subbab" :selected="s.id_subbab == '{{ $id_subbab }}'"></option>
                            </template>
                        </select>
                    </div>
                </div>
            </div>

            <script>
                function cascadeMateri() {
                    return {
                        daftarBuku: [],
                        daftarBab: [],
                        daftarSubbab: [],
                        selectedBuku: '',
                        selectedBab: '',
                        selectedSubbab: '{{ $id_subbab }}',
                        
                        init() {
                            this.fetchBuku();
                        },
                        
                        async fetchBuku() {
                            const res = await fetch('/api/buku');
                            const json = await res.json();
                            this.daftarBuku = json.data || json;
                        },
                        
                        async fetchBab() {
                            this.selectedBab = '';
                            this.selectedSubbab = '';
                            this.daftarBab = [];
                            this.daftarSubbab = [];
                            if (!this.selectedBuku) return;
                            
                            const res = await fetch('/admin/bab/by-buku/' + this.selectedBuku);
                            this.daftarBab = await res.json();
                        },
                        
                        async fetchSubbab() {
                            this.selectedSubbab = '';
                            this.daftarSubbab = [];
                            if (!this.selectedBab) return;
                            
                            const res = await fetch('/admin/subab/by-bab/' + this.selectedBab);
                            this.daftarSubbab = await res.json();
                        }
                    }
                }
            </script>

            <!-- Judul Materi -->
            <div>
                <label for="judul_materi" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Judul Materi</label>
                <input type="text" id="judul_materi" name="judul_materi" value="{{ old('judul_materi') }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent" />
            </div>

            <!-- PDF Upload (Phase 1) -->
            <div x-show="!extracted" x-cloak style="display:none;">
                <label for="pdf" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">PDF Materi (opsional)</label>
                <input type="file" id="pdf" name="pdf" accept="application/pdf" class="w-full text-base text-gray-500 cursor-pointer font-jakarta file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200" x-ref="pdf" />
                <button type="button" @click="extractPdf()" class="mt-2 w-full py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Ekstrak Teks</button>
            </div>

            <!-- Extracted Text (Phase 2) -->
            <div x-show="extracted" class="mt-6" x-cloak style="display:none;">
                <div class="max-w-2xl mx-auto bg-white rounded shadow p-6" style="font-family: serif;" x-ref="book" x-html="bookHtml"></div>
            </div>

            <!-- Hidden field containing generated HTML for submission -->
            <input type="hidden" name="isi" x-ref="isi" />

            <!-- Side panel for tagged terms -->
            <div class="w-72 bg-gray-50 border-l p-4 overflow-y-auto mt-6">
                <h2 class="mb-2 text-lg font-semibold">Tagged Terms</h2>
                <template x-for="term in terms" :key="term.id">
                    <div class="flex items-center justify-between py-1 border-b border-gray-200">
                        <div class="flex-1 cursor-pointer" @click="scrollToTerm(term)"><span x-text="term.text" class="font-medium"></span></div>
                        <button type="button" @click.stop="deleteTerm(term.id)" class="text-red-600 hover:underline" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 py-3 text-lg font-bold text-white bg-admin-orange hover:bg-opacity-90 rounded-xl transition-all font-jakarta">Simpan</button>
                <a href="{{ url()->previous() }}" class="flex-1 py-3 text-lg font-bold text-center text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all font-jakarta">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
.term { @apply border-b border-dashed border-indigo-500; }
</style>