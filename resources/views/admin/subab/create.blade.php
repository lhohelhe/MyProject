@extends('layouts.admin')

@section('title', 'Tambah Subbab - SahabatBuku')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="mb-6 text-3xl font-extrabold text-slate-800 font-jakarta">Tambah Subbab Baru</h1>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
        <form id="subabForm" class="space-y-6">
            @csrf
            <input type="hidden" name="id_bab" value="{{ $id_bab }}">

            {{-- Nomor Subbab --}}
            <div>
                <label for="nomor_subbab" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Nomor Subbab</label>
                <input type="text"
                       id="nomor_subbab"
                       name="nomor_subbab"
                       value="{{ old('nomor_subbab') }}"
                       placeholder="Contoh: 1.1"
                       required
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent">
                <p id="errorNomorSubab" class="mt-1 text-sm text-red-500 hidden"></p>
            </div>

            {{-- Judul Subbab --}}
            <div>
                <label for="judul_subbab" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Judul Subbab</label>
                <input type="text"
                       id="judul_subbab"
                       name="judul_subbab"
                       value="{{ old('judul_subbab') }}"
                       placeholder="Contoh: Pengenalan Aljabar"
                       required
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent">
                <p id="errorJudulSubab" class="mt-1 text-sm text-red-500 hidden"></p>
            </div>

            <div id="successMessage" class="hidden p-4 mb-4 text-green-800 bg-green-100 rounded-xl">
                Subbab berhasil ditambahkan! Mengalihkan...
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 pt-4">
                <button type="submit"
                        class="px-6 py-3 font-semibold text-white bg-[#F4922A] rounded-xl hover:bg-opacity-90 transition-all font-jakarta">
                    Simpan Subbab
                </button>
                <a href="{{ url()->previous() }}"
                   class="px-6 py-3 font-semibold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-all font-jakarta">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('subabForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const nomorSubab = document.getElementById('nomor_subbab').value;
    const judulSubab = document.getElementById('judul_subbab').value;
    const idBab = document.querySelector('input[name="id_bab"]').value;
    
    document.getElementById('errorNomorSubab').classList.add('hidden');
    document.getElementById('errorJudulSubab').classList.add('hidden');
    
    try {
        const response = await fetch('/api/subab', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
                id_bab: idBab,
                nomor_subbab: nomorSubab,
                judul_subbab: judulSubab
            })
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            if (data.errors) {
                if (data.errors.nomor_subbab) {
                    document.getElementById('errorNomorSubab').textContent = data.errors.nomor_subbab[0];
                    document.getElementById('errorNomorSubab').classList.remove('hidden');
                }
                if (data.errors.judul_subbab) {
                    document.getElementById('errorJudulSubab').textContent = data.errors.judul_subbab[0];
                    document.getElementById('errorJudulSubab').classList.remove('hidden');
                }
            }
            return;
        }
        
        document.getElementById('successMessage').classList.remove('hidden');
        setTimeout(() => {
            window.history.back();
        }, 800);
        
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    }
});
</script>

@endsection