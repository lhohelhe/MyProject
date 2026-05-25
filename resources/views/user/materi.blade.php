<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap');
    .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>

<div class="flex min-h-screen font-jakarta" style="background-color: #E5F8FF;">

    <x-user-sidebar />

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="flex-1 px-8 py-6 overflow-y-auto">

        {{-- Breadcrumbs --}}
        <nav class="flex mb-8 text-sm font-medium text-gray-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('user.katalog') }}" class="hover:text-[#F4922A]">Katalog</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                        <a href="{{ route('user.buku.show', $materi->subab->bab->buku->id_buku) }}" class="ml-1 hover:text-[#F4922A] md:ml-2">{{ $materi->subab->bab->buku->judul_buku }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                        <span class="ml-1 text-gray-400 md:ml-2 line-clamp-1">{{ $materi->judul_materi }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Title --}}
        <h1 class="text-2xl font-bold text-slate-800 mb-8 leading-tight">
            {{ $materi->judul_materi }}
        </h1>

        {{-- Content Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-10 mb-10">
            
            {{-- Materi Image --}}
            @if($materi->gambar)
                <div class="mb-10 overflow-hidden rounded-xl">
                    <img src="{{ Storage::url($materi->gambar) }}" alt="{{ $materi->judul_materi }}" class="w-full h-auto object-cover max-h-[500px]">
                </div>
            @endif

            {{-- Materi Content --}}
            <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed font-jakarta">
                {!! $materi->isi !!}
            </div>
        </div>

        {{-- Navigation Buttons --}}
        <div class="flex justify-between items-center gap-4">
            @if($prev)
                <a href="{{ route('user.materi.show', $prev->id_materi) }}" class="flex items-center gap-2 px-6 py-3 bg-white border-2 border-[#F4922A] text-[#F4922A] font-bold rounded-xl hover:bg-[#F4922A] hover:text-white transition-all shadow-md">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    Sebelumnya
                </a>
            @else
                <div></div>
            @endif

            @if($next)
                <a href="{{ route('user.materi.show', $next->id_materi) }}" class="flex items-center gap-2 px-6 py-3 bg-[#F4922A] text-white font-bold rounded-xl hover:bg-[#e07f1d] transition-all shadow-md">
                    Selanjutnya
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            @endif
        </div>

    </main>

</div>
</x-app-layout>
