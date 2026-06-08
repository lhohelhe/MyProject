@extends('layouts.admin')

@section('title', 'Kelola Flashcard - SahabatBuku')

@section('content')
<div class="max-w-5xl mx-auto">

    <h1 class="mb-6 text-2xl font-black text-black uppercase tracking-wider font-jakarta">
        Kelola Flashcard
    </h1>

    @if(session('success'))
    <div class="px-4 py-3 mb-4 text-green-800 bg-green-100 border-2 border-green-400 rounded-xl font-jakarta text-sm font-bold">
        ✓ {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="px-4 py-3 mb-4 text-red-800 bg-red-100 border-2 border-red-400 rounded-xl font-jakarta text-sm font-bold flex items-start gap-2">
        <span class="flex-shrink-0 text-base">✗</span>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    {{-- Generate form --}}
    <div class="p-5 mb-6 bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl font-jakarta">
        <p class="text-xs font-black text-black uppercase tracking-wider mb-4">Generate Flashcard dengan AI</p>
        <form method="POST" action="{{ route('admin.flashcard.generate') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-black text-black uppercase tracking-wider mb-1.5">Buku</label>
                    <select name="id_buku" id="id_buku" required
                            class="w-full px-3 py-2.5 text-sm font-bold border-2 border-black rounded-xl focus:outline-none focus:ring-2 focus:ring-[#F4922A]">
                        <option value="" disabled selected>Pilih Buku</option>
                        @foreach($books as $buku)
                            <option value="{{ $buku->id_buku }}">{{ $buku->judul_buku }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-black text-black uppercase tracking-wider mb-1.5">Bab</label>
                    <select name="id_bab" id="id_bab" required disabled
                            class="w-full px-3 py-2.5 text-sm font-bold border-2 border-black rounded-xl focus:outline-none focus:ring-2 focus:ring-[#F4922A] disabled:opacity-50">
                        <option value="" disabled selected>Pilih Bab</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-black text-black uppercase tracking-wider mb-1.5">Subbab</label>
                    <select name="id_subab" id="id_subab" required disabled
                            class="w-full px-3 py-2.5 text-sm font-bold border-2 border-black rounded-xl focus:outline-none focus:ring-2 focus:ring-[#F4922A] disabled:opacity-50">
                        <option value="" disabled selected>Pilih Subbab</option>
                    </select>
                </div>
            </div>
            <button type="submit"
                    class="px-5 py-2.5 text-sm font-black text-white bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all">
                Generate Flashcard
            </button>
        </form>
    </div>

    {{-- Ringkasan Flashcard per Bab --}}
    @if($ringkasanBab->isNotEmpty())
    <div class="mb-6">
        <p class="text-xs font-black text-black uppercase tracking-wider mb-3">Ringkasan Flashcard per Bab</p>
        <div class="space-y-3" x-data="{}">
            @foreach($ringkasanBab as $item)
            <div class="bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl overflow-hidden"
                 x-data="{ open: false }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-5 py-3 text-left hover:bg-slate-50 transition">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 flex items-center justify-center bg-[#F4922A] border-2 border-black text-white font-black text-xs rounded-lg flex-shrink-0">
                            {{ $item['bab']->nomor_bab ?? '?' }}
                        </span>
                        <div>
                            <p class="font-black text-black text-sm">{{ $item['bab']->judul_bab ?? '-' }}</p>
                            <p class="text-[10px] font-bold text-slate-400">{{ $item['buku']->judul_buku ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <span class="px-2.5 py-1 text-[10px] font-black text-white bg-[#F4922A] border-2 border-black rounded-full">
                            {{ $item['total'] }} flashcard
                        </span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </div>
                </button>

                <div x-show="open" x-collapse class="border-t-2 border-black">
                    @foreach($item['items'] as $subbabId => $subbabData)
                    <div class="px-5 py-3 flex items-center justify-between border-b border-slate-100 last:border-b-0">
                        <div>
                            <p class="text-xs font-black text-black">{{ $subbabData['subbab']->judul_subbab ?? '-' }}</p>
                            <p class="text-[10px] font-bold text-slate-400">{{ $subbabData['count'] }} flashcard</p>
                        </div>
                        <div class="flex items-center gap-1.5">
                            @for($i = 0; $i < min($subbabData['count'], 5); $i++)
                            <div class="w-2 h-2 rounded-full bg-[#F4922A] border border-black"></div>
                            @endfor
                            @if($subbabData['count'] > 5)
                            <span class="text-[9px] font-black text-slate-400">+{{ $subbabData['count'] - 5 }}</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Header tabel --}}
    <div class="hidden p-4 mb-3 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl lg:grid grid-cols-12 gap-4 text-xs font-black text-black uppercase tracking-wider text-center font-jakarta">
        <div class="col-span-1">No</div>
        <div class="col-span-3 text-left">Subbab</div>
        <div class="col-span-3 text-left">Pertanyaan</div>
        <div class="col-span-2 text-left">Bab</div>
        <div class="col-span-2 text-left">Buku</div>
        <div class="col-span-1">Aksi</div>
    </div>

    {{-- List --}}
    @forelse($flashcards as $index => $flashcard)
    <div class="p-4 mb-3 bg-white border-2 border-black rounded-xl font-jakarta">
        <div class="hidden lg:grid grid-cols-12 gap-4 items-center">
            <div class="col-span-1 font-black text-black text-center">{{ $flashcards->firstItem() + $index }}</div>
            <div class="col-span-3 font-black text-black text-sm truncate">
                {{ $flashcard->subab->judul_subbab ?? '-' }}
            </div>
            <div class="col-span-3 font-bold text-slate-600 text-xs truncate">
                {{ Str::limit(strip_tags($flashcard->pertanyaan), 50) }}
            </div>
            <div class="col-span-2 font-bold text-slate-600 text-xs truncate">
                {{ $flashcard->subab->bab->judul_bab ?? '-' }}
            </div>
            <div class="col-span-2 font-bold text-slate-600 text-xs truncate">
                {{ $flashcard->subab->bab->buku->judul_buku ?? '-' }}
            </div>
            <div class="col-span-1 flex justify-center">
                <form method="POST" action="{{ route('admin.flashcard.destroy', $flashcard->id_flashcard) }}"
                      onsubmit="return confirm('Hapus flashcard ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1.5 text-xs font-black text-white bg-red-500 border-2 border-black shadow-[2px_2px_0px_#000] rounded-lg hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        {{-- Mobile --}}
        <div class="lg:hidden space-y-2">
            <p class="font-black text-black text-sm">{{ $flashcard->subab->judul_subbab ?? '-' }}</p>
            <p class="font-bold text-slate-500 text-xs">{{ Str::limit(strip_tags($flashcard->pertanyaan), 80) }}</p>
            <p class="text-[10px] font-bold text-slate-400">
                {{ $flashcard->subab->bab->judul_bab ?? '-' }} · {{ $flashcard->subab->bab->buku->judul_buku ?? '-' }}
            </p>
            <form method="POST" action="{{ route('admin.flashcard.destroy', $flashcard->id_flashcard) }}"
                  onsubmit="return confirm('Hapus flashcard ini?')">
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
    <div class="p-8 text-center bg-white border-2 border-black rounded-xl">
        <p class="font-bold text-slate-400">Belum ada flashcard terdaftar</p>
    </div>
    @endforelse

    @if($flashcards->hasPages())
    <div class="mt-6">{{ $flashcards->links() }}</div>
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const idBuku  = document.getElementById('id_buku');
    const idBab   = document.getElementById('id_bab');
    const idSubab = document.getElementById('id_subab');

    idBuku?.addEventListener('change', function () {
        idBab.innerHTML = '<option value="" disabled selected>Loading...</option>';
        idBab.disabled = true;
        idSubab.innerHTML = '<option value="" disabled selected>Pilih Subbab</option>';
        idSubab.disabled = true;
        fetch(`/admin/bab/by-buku/${this.value}`, { headers: { 'X-CSRF-TOKEN': csrfToken } })
            .then(r => r.json())
            .then(data => {
                idBab.innerHTML = '<option value="" disabled selected>Pilih Bab</option>';
                data.forEach(b => {
                    const o = document.createElement('option');
                    o.value = b.id_bab;
                    o.textContent = 'Bab ' + b.nomor_bab + ' — ' + b.judul_bab;
                    idBab.appendChild(o);
                });
                idBab.disabled = false;
            });
    });

    idBab?.addEventListener('change', function () {
        idSubab.innerHTML = '<option value="" disabled selected>Loading...</option>';
        idSubab.disabled = true;
        fetch(`/admin/subab/by-bab/${this.value}`, { headers: { 'X-CSRF-TOKEN': csrfToken } })
            .then(r => r.json())
            .then(data => {
                idSubab.innerHTML = '<option value="" disabled selected>Pilih Subbab</option>';
                data.forEach(s => {
                    const o = document.createElement('option');
                    o.value = s.id_subbab;
                    o.textContent = s.nomor_subbab + ' ' + s.judul_subbab;
                    idSubab.appendChild(o);
                });
                idSubab.disabled = false;
            });
    });
});
</script>
@endsection
