@extends('layouts.admin')

@section('title', 'Kelola Konten & PDF - SahabatBuku')

@section('content')
<div class="max-w-4xl mx-auto" x-data="pdfParser()">
    <!-- Header: Buku Title and Cover -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 mb-8 flex items-start gap-6">
        @if($buku->gambar)
            <img src="{{ asset('storage/' . $buku->gambar) }}" class="object-cover w-32 h-44 rounded-xl border">
        @else
            <div class="flex items-center justify-center w-32 h-44 bg-gray-200 rounded-xl">
                <i data-lucide="book-open" class="w-12 h-12 text-gray-400"></i>
            </div>
        @endif
        <div>
            <h1 class="text-2xl font-bold text-slate-800 font-jakarta mb-2">{{ $buku->judul_buku }}</h1>
            <p class="text-sm text-slate-500 font-jakarta mb-4">
                Kelas {{ $buku->kelas }} · Semester {{ $buku->semester }}
            </p>
            <a href="/admin/dashboard-buku" class="text-sm text-blue-600 hover:underline font-jakarta">
                &larr; Kembali ke Dashboard Buku
            </a>
        </div>
    </div>

    <!-- Upload PDF Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 mb-8">
        <h2 class="text-xl font-bold text-slate-800 font-jakarta mb-4">Ekstrak Konten via PDF</h2>
        <p class="text-sm text-slate-600 font-jakarta mb-6">
            Unggah file PDF buku. Sistem akan mendeteksi baris yang dimulai dengan <strong>BAB</strong> atau format <strong>A. / 1.1</strong> untuk membuat struktur Bab dan Subbab secara otomatis.
            <br><span class="text-red-500 font-semibold">Peringatan:</span> Parsing PDF baru akan menghapus seluruh Bab, Subbab, dan Materi yang sudah ada pada buku ini.
        </p>

        <form @submit.prevent="submitPdf" class="flex flex-col gap-4">
            <input type="file" x-ref="pdfFile" accept="application/pdf" required
                   class="w-full text-base text-gray-500 cursor-pointer font-jakarta file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200" />
            
            <button type="submit" :disabled="loading" 
                    class="py-3 px-6 text-white bg-sahabat-orange hover:bg-opacity-90 rounded-xl font-jakarta font-bold transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                <span x-show="!loading">Ekstrak & Parse PDF</span>
                <span x-show="loading">Sedang Memproses... Harap Tunggu...</span>
            </button>
        </form>

        <div x-show="message" class="mt-4 p-4 rounded-xl font-jakarta text-sm" :class="isError ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'" x-text="message" style="display: none;"></div>
    </div>

    <!-- Existing Bab List -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
        <h2 class="text-xl font-bold text-slate-800 font-jakarta mb-4">Struktur Konten Saat Ini</h2>
        
        @if($babs->count() > 0)
            <div class="space-y-4">
                @foreach($babs as $bab)
                    <div class="border rounded-xl p-4 bg-gray-50">
                        <div class="font-bold text-lg mb-2">Bab {{ $bab->nomor_bab }}: {{ $bab->judul_bab }}</div>
                        @if($bab->subab->count() > 0)
                            <ul class="list-disc list-inside space-y-1 text-sm text-slate-700 ml-2">
                                @foreach($bab->subab as $subab)
                                    <li>{{ $subab->nomor_subbab }} {{ $subab->judul_subbab }} <span class="text-xs text-gray-400">({{ $subab->materi->count() }} paragraf materi)</span></li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500 italic">Belum ada subbab.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-slate-500 italic font-jakarta">Buku ini belum memiliki konten Bab/Subbab.</p>
        @endif
    </div>
</div>

<script>
    function pdfParser() {
        return {
            loading: false,
            message: '',
            isError: false,
            
            async submitPdf() {
                const fileInput = this.$refs.pdfFile;
                if (!fileInput.files.length) return;

                if (!confirm('Peringatan: Melanjutkan proses ini akan MENGHAPUS SEMUA Bab, Subbab, dan Materi yang sudah ada di buku ini. Lanjutkan?')) {
                    return;
                }

                this.loading = true;
                this.message = '';
                this.isError = false;

                const formData = new FormData();
                formData.append('pdf', fileInput.files[0]);
                // Add CSRF token for Laravel POST
                formData.append('_token', '{{ csrf_token() }}');

                try {
                    const response = await fetch('/admin/buku/{{ $buku->id_buku }}/parse-pdf', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok) {
                        this.message = result.message + ' Halaman akan dimuat ulang...';
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        this.isError = true;
                        this.message = result.message || 'Terjadi kesalahan saat memproses PDF.';
                        this.loading = false;
                    }
                } catch (error) {
                    this.isError = true;
                    this.message = 'Terjadi kesalahan jaringan atau server.';
                    this.loading = false;
                }
            }
        }
    }
</script>
@endsection
