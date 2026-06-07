@extends('layouts.admin')

@section('title', 'Generate Flashcard - SahabatBuku')

@section('content')
    <h1 class="mb-6 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta lg:mb-10 text-slate-800">
        Generate Flashcard
    </h1>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="px-4 py-3 mb-6 text-green-800 bg-green-100 rounded-xl font-jakarta">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="px-4 py-3 mb-6 text-red-800 bg-red-100 rounded-xl font-jakarta">
            {{ session('error') }}
        </div>
    @endif

    {{-- Generate form --}}
    <div class="overflow-hidden bg-white shadow-md rounded-2xl border border-slate-100 font-jakarta mb-8">
        <div class="p-6">
            <form method="POST" action="{{ route('admin.flashcard.generate') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="id_buku" class="block text-sm font-medium text-slate-700 mb-1">Buku</label>
                        <select name="id_buku" id="id_buku" class="block w-full border-2 border-black rounded-none focus:outline-none focus:shadow-[2px_2px_0px_#000]" required>
                            <option value="" disabled selected>Select Buku</option>
                            @foreach($books as $buku)
                                <option value="{{ $buku->id }}">{{ $buku->judul }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="id_bab" class="block text-sm font-medium text-slate-700 mb-1">Bab</label>
                        <select name="id_bab" id="id_bab" class="block w-full border-2 border-black rounded-none focus:outline-none focus:shadow-[2px_2px_0px_#000]" required disabled>
                            <option value="" disabled selected>Select Bab</option>
                        </select>
                    </div>
                    <div>
                        <label for="id_subab" class="block text-sm font-medium text-slate-700 mb-1">Subab</label>
                        <select name="id_subab" id="id_subab" class="block w-full border-2 border-black rounded-none focus:outline-none focus:shadow-[2px_2px_0px_#000]" required disabled>
                            <option value="" disabled selected>Select Subab</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="px-4 py-2 bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-none font-bold text-white hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all">
                    Generate Flashcard dengan AI
                </button>
            </form>
        </div>
    </div>

    {{-- Flashcard table --}}
    <div class="overflow-hidden bg-white shadow-md rounded-2xl border border-slate-100 font-jakarta">
        <div class="p-6">
            <div class="hidden p-4 mb-4 rounded-lg bg-slate-50 lg:block border border-slate-100">
                <div class="grid grid-cols-12 gap-4 text-base font-semibold text-center text-slate-600">
                    <div class="col-span-1">No</div>
                    <div class="col-span-3 text-left">Subab</div>
                    <div class="col-span-3 text-left">Bab</div>
                    <div class="col-span-3 text-left">Buku</div>
                    <div class="col-span-2 text-left">Aksi</div>
                </div>
            </div>
            @forelse($flashcards as $index => $flashcard)
                <div class="p-4 mb-4 border border-slate-100 rounded-xl bg-white hover:shadow-sm transition-shadow">
                    <div class="grid grid-cols-12 gap-4 text-center lg:text-left text-slate-700">
                        <div class="col-span-1 font-semibold text-slate-800">{{ $flashcards->firstItem() + $index }}</div>
                        <div class="col-span-3">
                            <div class="font-bold">{{ $flashcard->subab->judul ?? '-' }}</div>
                            <div class="text-sm text-slate-500">{{ Str::limit($flashcard->pertanyaan, 60) }}</div>
                        </div>
                        <div class="col-span-3">
                            <div class="font-medium">{{ $flashcard->subab->bab->judul ?? '-' }}</div>
                        </div>
                        <div class="col-span-3">
                            <div class="font-medium">{{ $flashcard->subab->bab->buku->judul ?? '-' }}</div>
                        </div>
                        <div class="col-span-2 flex items-center justify-center">
                            <form method="POST" action="{{ route('admin.flashcard.destroy', $flashcard->id) }}" onsubmit="return confirm('Are you sure you want to delete this flashcard?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-none font-bold hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center bg-white rounded-2xl">
                    <p class="text-lg text-gray-500">Belum ada flashcard terdaftar</p>
                </div>
            @endforelse

            @if($flashcards->hasPages())
                <div class="mt-8">
                    {{ $flashcards->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Ajax scripts for dependent dropdowns --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const idBuku = document.getElementById('id_buku');
            const idBab = document.getElementById('id_bab');
            const idSubab = document.getElementById('id_subab');

            idBuku?.addEventListener('change', function () {
                const bukuId = this.value;
                idBab.innerHTML = '<option value="" disabled selected>Loading...</option>';
                idBab.disabled = true;
                fetch(`/admin/bab/by-buku/${bukuId}`, {
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                })
                .then(r => r.json())
                .then(data => {
                    idBab.innerHTML = '<option value="" disabled selected>Select Bab</option>';
                    data.forEach(bab => {
                        const opt = document.createElement('option');
                        opt.value = bab.id;
                        opt.textContent = bab.judul;
                        idBab.appendChild(opt);
                    });
                    idBab.disabled = false;
                    idSubab.innerHTML = '<option value="" disabled selected>Select Subab</option>';
                    idSubab.disabled = true;
                });
            });

            idBab?.addEventListener('change', function () {
                const babId = this.value;
                idSubab.innerHTML = '<option value="" disabled selected>Loading...</option>';
                idSubab.disabled = true;
                fetch(`/admin/subab/by-bab/${babId}`, {
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                })
                .then(r => r.json())
                .then(data => {
                    idSubab.innerHTML = '<option value="" disabled selected>Select Subab</option>';
                    data.forEach(subab => {
                        const opt = document.createElement('option');
                        opt.value = subab.id;
                        opt.textContent = subab.judul;
                        idSubab.appendChild(opt);
                    });
                    idSubab.disabled = false;
                });
            });
        });
    </script>
@endsection
