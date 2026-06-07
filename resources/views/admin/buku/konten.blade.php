@extends('layouts.admin')

@section('title', 'Kelola Konten - SahabatBuku')

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-6">
        <div class="flex items-center gap-6">
            @if($buku->gambar)
                <img src="{{ asset('storage/' . $buku->gambar) }}" class="object-cover w-24 h-32 rounded-2xl shadow-sm border border-slate-100">
            @else
                <div class="flex items-center justify-center w-24 h-32 bg-gray-200 rounded-2xl shadow-sm">
                    <i data-lucide="book-open" class="w-8 h-8 text-gray-400"></i>
                </div>
            @endif
            <div>
                <h1 class="text-3xl font-bold text-slate-800 font-jakarta mb-2">{{ $buku->judul_buku }}</h1>
                <p class="text-sm text-slate-500 font-jakarta mb-3">
                    Kelas {{ $buku->kelas }} · Semester {{ $buku->semester }}
                </p>
                <a href="/admin/dashboard-buku" class="text-sm text-blue-600 hover:underline font-jakarta inline-flex items-center gap-1">
                    &larr; Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    {{-- Bab & Subbab List with Inline Materi Editor --}}
    @if($babs->count() > 0)
        {{-- Card grid overview --}}
        <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 mb-8">
            @foreach($babs as $bab)
            <div class="relative flex flex-col bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition-all p-5">
                <div class="absolute z-10 top-3 left-3 bg-[#F4922A] text-white rounded-[8px] px-2 py-1 shadow-sm">
                    <span class="text-[11px] font-bold font-jakarta">
                        Bab {{ $bab->nomor_bab }}
                    </span>
                </div>

                <div class="flex-1 mt-6">
                    <h3 class="font-bold text-slate-800 font-jakarta mb-1 text-sm leading-tight">{{ $bab->judul_bab }}</h3>
                    <p class="text-[11px] text-slate-500 font-jakarta mb-3">{{ $bab->subab->count() }} Subbab</p>
                    
                    @if($bab->subab->count() > 0)
                        <ul class="text-[11px] text-slate-600 space-y-1 list-disc pl-3">
                            @foreach($bab->subab->take(3) as $subab)
                                <li class="truncate">{{ $subab->nomor_subbab }} {{ $subab->judul_subbab }}</li>
                            @endforeach
                            @if($bab->subab->count() > 3)
                                <li class="italic text-gray-400 list-none -ml-3 mt-1">... {{ $bab->subab->count() - 3 }} subbab lainnya</li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- Kelola Struktur Bab & Subbab + Inline Materi Editor --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 font-jakarta">
            <h2 class="text-xl font-bold text-slate-800 mb-6">Kelola Struktur Bab & Subbab</h2>
            
            <div class="space-y-6">
                @foreach($babs as $bab)
                    <div class="border-b border-slate-100 pb-6 last:border-b-0 last:pb-0" 
                         x-data="{ 
                            editing: false, 
                            title: '{{ addslashes($bab->judul_bab) }}', 
                            originalTitle: '{{ addslashes($bab->judul_bab) }}',
                            async save() {
                                if (this.title.trim() === '') return;
                                try {
                                    const res = await fetch('/admin/bab/{{ $bab->id_bab }}', {
                                        method: 'PUT',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({ judul_bab: this.title })
                                    });
                                    if (res.ok) {
                                        this.originalTitle = this.title;
                                        this.editing = false;
                                        alert('Judul Bab berhasil diperbarui!');
                                    } else {
                                        alert('Gagal memperbarui judul Bab');
                                    }
                                } catch (e) {
                                    alert('Terjadi kesalahan: ' + e.message);
                                }
                            },
                            cancel() {
                                this.title = this.originalTitle;
                                this.editing = false;
                            }
                         }">
                        
                        {{-- Bab Row --}}
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50 p-4 rounded-xl">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-bold text-[#F4922A] uppercase tracking-wider">Bab {{ $bab->nomor_bab }}</span>
                                </div>
                                <template x-if="!editing">
                                    <h3 class="font-bold text-slate-800 text-base" x-text="title"></h3>
                                </template>
                                <template x-if="editing">
                                    <input type="text" x-model="title" @keyup.enter="save" @keyup.escape="cancel"
                                           class="w-full text-sm font-semibold text-slate-800 bg-white border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:border-[#F4922A]">
                                </template>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <template x-if="!editing">
                                    <div class="flex items-center gap-2">
                                        <button @click="editing = true" class="px-4 py-2 text-xs font-bold text-blue-600 hover:bg-blue-50 border border-blue-100 rounded-xl transition-all">
                                            Edit Nama Bab
                                        </button>
                                        <button @click="generateQuizAI({{ $bab->id_bab }}, $el)" 
                                                class="px-4 py-2 text-xs font-bold text-white bg-purple-600 hover:bg-purple-700 rounded-xl shadow-sm transition-all inline-flex items-center gap-1">
                                            <span>Generate Quiz AI</span>
                                        </button>
                                    </div>
                                </template>
                                <template x-if="editing">
                                    <div class="flex items-center gap-2">
                                        <button @click="save" class="px-4 py-2 text-xs font-bold text-white bg-green-600 hover:bg-green-700 rounded-xl transition-all">
                                            Simpan
                                        </button>
                                        <button @click="cancel" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-100 border border-slate-200 rounded-xl transition-all">
                                            Batal
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Subbab list under this Bab --}}
                        @if($bab->subab->count() > 0)
                            <div class="mt-4 pl-4 sm:pl-8 space-y-3">
                                @foreach($bab->subab as $subbab)
                                    @php
                                        $hasMateri   = $subbab->materi->count() > 0;
                                        $existingMateri = $subbab->materi->first();
                                    @endphp
                                    <div class="border border-slate-100 rounded-xl hover:bg-slate-50/50 transition-all overflow-hidden"
                                         x-data="{
                                            deleted: false,
                                            formOpen: false,
                                            saving: false,
                                            successMsg: '',
                                            errorMsg: '',
                                            isEdit: {{ $hasMateri ? 'true' : 'false' }},
                                            materiId: {{ $hasMateri ? $existingMateri->id_materi : 'null' }},
                                            judul: '{{ $hasMateri ? addslashes($existingMateri->judul_materi) : '' }}',
                                            isi: {{ $hasMateri ? json_encode($existingMateri->isi) : '""' }},
                                            async deleteSubbab() {
                                                if (!confirm('Apakah Anda yakin ingin menghapus Subbab ini beserta seluruh materinya?')) return;
                                                try {
                                                    const res = await fetch('/admin/subbab/{{ $subbab->id_subbab }}', {
                                                        method: 'DELETE',
                                                        headers: {
                                                            'Accept': 'application/json',
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                        }
                                                    });
                                                    if (res.ok) {
                                                        this.deleted = true;
                                                    } else {
                                                        alert('Gagal menghapus Subbab');
                                                    }
                                                } catch (e) {
                                                    alert('Terjadi kesalahan: ' + e.message);
                                                }
                                            },
                                            async submitMateri() {
                                                if (!this.judul.trim() || !this.isi.trim()) {
                                                    this.errorMsg = 'Judul materi dan isi wajib diisi.';
                                                    return;
                                                }
                                                this.saving = true;
                                                this.successMsg = '';
                                                this.errorMsg = '';

                                                let url, method;
                                                if (this.isEdit && this.materiId) {
                                                    url = '/admin/materi/' + this.materiId;
                                                    method = 'PUT';
                                                } else {
                                                    url = '/admin/materi';
                                                    method = 'POST';
                                                }

                                                try {
                                                    const res = await fetch(url, {
                                                        method: method,
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'Accept': 'application/json',
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                        },
                                                        body: JSON.stringify({
                                                            judul_materi: this.judul,
                                                            isi: this.isi,
                                                            id_subbab: {{ $subbab->id_subbab }}
                                                        })
                                                    });

                                                    if (res.ok) {
                                                        const data = await res.json().catch(() => null);
                                                        this.successMsg = this.isEdit ? 'Materi berhasil diperbarui!' : 'Materi berhasil ditambahkan!';
                                                        if (!this.isEdit && data && data.id_materi) {
                                                            this.materiId = data.id_materi;
                                                        }
                                                        this.isEdit = true;
                                                        setTimeout(() => { this.successMsg = ''; }, 3000);
                                                    } else {
                                                        const err = await res.json().catch(() => ({}));
                                                        this.errorMsg = err.message || 'Gagal menyimpan materi.';
                                                    }
                                                } catch (e) {
                                                    this.errorMsg = 'Terjadi kesalahan: ' + e.message;
                                                } finally {
                                                    this.saving = false;
                                                }
                                            }
                                         }"
                                         x-show="!deleted"
                                         x-transition>

                                        {{-- Subbab Header Row --}}
                                        <div class="flex items-center justify-between gap-4 p-3">
                                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                                <span class="text-xs font-bold text-slate-400 shrink-0">{{ $subbab->nomor_subbab }}</span>
                                                <span class="text-sm font-medium text-slate-700 truncate">{{ $subbab->judul_subbab }}</span>
                                            </div>
                                            <div class="flex items-center gap-2 shrink-0">
                                                <button @click="formOpen = !formOpen" 
                                                        class="px-3 py-1.5 text-xs font-bold rounded-xl transition-all"
                                                        :class="isEdit 
                                                            ? 'text-blue-600 hover:bg-blue-50 border border-blue-100' 
                                                            : 'text-white bg-[#F4922A] hover:bg-[#d67b1b]'">
                                                    <span x-text="formOpen ? 'Tutup' : (isEdit ? 'Edit Materi' : 'Tambah Materi')"></span>
                                                </button>
                                                @if($hasMateri)
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-green-500 shrink-0"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                @endif
                                                <button @click="deleteSubbab" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-xl transition-all shrink-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Inline Materi Form --}}
                                        <div x-show="formOpen" x-collapse class="border-t border-slate-100 bg-slate-50/70 p-4 space-y-4">
                                            {{-- Form heading --}}
                                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider" x-text="isEdit ? 'Edit Materi' : 'Tambah Materi'"></h4>
                                            {{-- Success / Error Messages --}}
                                            <div x-show="successMsg" x-transition class="p-3 rounded-xl bg-green-100 text-green-800 text-xs font-medium" x-text="successMsg"></div>
                                            <div x-show="errorMsg" x-transition class="p-3 rounded-xl bg-red-100 text-red-800 text-xs font-medium" x-text="errorMsg"></div>

                                            <div>
                                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Judul Materi</label>
                                                <input type="text" x-model="judul" placeholder="Masukkan judul materi..."
                                                       class="w-full text-sm text-slate-800 bg-white border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-[#F4922A] focus:ring-1 focus:ring-[#F4922A]/20 transition-all">
                                            </div>

                                            <div>
                                                <label class="block text-xs font-bold text-slate-600 mb-1.5">Isi Materi</label>
                                                <textarea x-model="isi" rows="8" placeholder="Tulis isi materi di sini..."
                                                          class="w-full text-sm text-slate-700 bg-white border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-[#F4922A] focus:ring-1 focus:ring-[#F4922A]/20 transition-all leading-relaxed resize-y"></textarea>
                                            </div>

                                            <div class="flex items-center justify-end gap-3 pt-1">
                                                <button @click="formOpen = false; errorMsg = ''" 
                                                        class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-200 border border-slate-200 rounded-xl transition-all">
                                                    Batal
                                                </button>
                                                <button @click="submitMateri" :disabled="saving"
                                                        class="px-5 py-2 text-xs font-bold text-white bg-[#F4922A] hover:bg-[#d67b1b] rounded-xl transition-all disabled:opacity-50 flex items-center gap-2">
                                                    <template x-if="saving">
                                                        <svg class="animate-spin h-3.5 w-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                    </template>
                                                    <span x-text="saving ? 'Menyimpan...' : (isEdit ? 'Perbarui Materi' : 'Simpan Materi')"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-4 pl-8">
                                <p class="text-xs italic text-slate-400">Tidak ada subbab di bab ini.</p>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center p-12 bg-white rounded-2xl shadow-sm border border-slate-100">
            <i data-lucide="folder-open" class="w-16 h-16 text-gray-300 mb-4"></i>
            <p class="text-slate-500 italic font-jakarta text-center">Buku ini belum memiliki konten Bab/Subbab.</p>
        </div>
    @endif
</div>

<script>
async function generateQuizAI(idBab, btnEl) {
    if (!confirm('Apakah Anda yakin ingin membuat 10 soal quiz dengan AI untuk Bab ini?')) return;
    
    const originalText = btnEl.innerHTML;
    btnEl.disabled = true;
    btnEl.innerHTML = `
        <svg class="animate-spin h-3.5 w-3.5 text-white inline-block mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>Generating...</span>
    `;

    try {
        const res = await fetch('/admin/quiz/generate-ai', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id_bab: idBab })
        });
        const data = await res.json();
        if (res.ok && data.success) {
            alert('Quiz berhasil digenerate oleh AI!');
            window.location.href = '/admin/quiz';
        } else {
            alert('Gagal: ' + (data.error || 'Terjadi kesalahan.'));
        }
    } catch (e) {
        alert('Terjadi kesalahan: ' + e.message);
    } finally {
        btnEl.disabled = false;
        btnEl.innerHTML = originalText;
    }
}
</script>
@endsection
