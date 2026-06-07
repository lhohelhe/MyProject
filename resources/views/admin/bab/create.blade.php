@extends('layouts.admin')

@section('title', 'Tambah Bab - SahabatBuku')

@section('content')
        <h1 class="mb-6 text-3xl font-extrabold font-jakarta">tambah bab baru</h1>

        <div class="max-w-xl p-8 bg-white shadow-md rounded-xl">
            <form id="babForm" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="id_buku" value="{{ $id_buku }}">

                {{-- nomor bab --}}
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium font-jakarta">nomor bab</label>
                    <input type="number"
                           id="nomor_bab"
                           name="nomor_bab"
                           value="{{ old('nomor_bab') }}"
                           placeholder="contoh: 1"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-admin-orange">
                    <p id="errorNomorBab" class="mt-1 text-sm text-red-500 hidden"></p>
                </div>

                {{-- judul bab --}}
                <div class="mb-8">
                    <label class="block mb-2 text-sm font-medium font-jakarta">judul bab</label>
                    <input type="text"
                           id="judulBab"
                           name="judul_bab"
                           value="{{ old('judul_bab') }}"
                           placeholder="contoh: pengenalan sistem"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-admin-orange">
                    <p id="errorJudulBab" class="mt-1 text-sm text-red-500 hidden"></p>
                </div>

                <div id="successMessage" class="hidden p-4 mb-4 text-green-800 bg-green-100 rounded-xl">
                    Bab berhasil ditambahkan! Mengalihkan...
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                           class="px-6 py-3 font-bold text-black bg-admin-orange rounded-xl hover:bg-opacity-90 font-jakarta">
                        simpan bab
                    </button>
                    <a href="{{ route('bab.index', ['id_buku' => $id_buku, 'active_menu' => request()->input('active_menu')]) }}"
                       class="px-6 py-3 font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 font-jakarta">
                        batal
                    </a>
                </div>
            </form>
        </div>

<script>
document.getElementById('babForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const nomorBab = document.getElementById('nomor_bab').value;
    const judulBab = document.getElementById('judulBab').value;
    const idBuku = document.querySelector('input[name="id_buku"]').value;
    const activeMenu = new URLSearchParams(window.location.search).get('active_menu') || 'bab';
    
    document.getElementById('errorNomorBab').classList.add('hidden');
    document.getElementById('errorJudulBab').classList.add('hidden');
    
    try {
        const response = await fetch('/api/bab', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
                id_buku: idBuku,
                nomor_bab: nomorBab,
                judul_bab: judulBab
            })
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            if (data.errors) {
                if (data.errors.nomor_bab) {
                    document.getElementById('errorNomorBab').textContent = data.errors.nomor_bab[0];
                    document.getElementById('errorNomorBab').classList.remove('hidden');
                }
                if (data.errors.judul_bab) {
                    document.getElementById('errorJudulBab').textContent = data.errors.judul_bab[0];
                    document.getElementById('errorJudulBab').classList.remove('hidden');
                }
            }
            return;
        }
        
        document.getElementById('successMessage').classList.remove('hidden');
        setTimeout(() => {
            window.location.href = `/admin/bab?id_buku=${idBuku}&active_menu=${activeMenu}`;
        }, 800);
        
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    }
});
</script>

@endsection