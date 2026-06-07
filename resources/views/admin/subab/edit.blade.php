@extends('layouts.admin')

@section('title', 'Edit Subbab - SahabatBuku')

@section('content')
        <div class="max-w-2xl mx-auto">
            <h1 class="mb-8 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta">
                Edit Subbab
            </h1>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
                <form id="subabEditForm" class="space-y-6">
                    @csrf
                    <input type="hidden" name="id_subab" value="{{ $subab->id_subbab }}">

                    <!-- Nomor Subbab Field -->
                    <div>
                        <label for="nomor_subbab" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Nomor Subbab</label>
                        <input 
                            type="text" 
                            id="nomor_subbab"
                            name="nomor_subbab" 
                            value="{{ old('nomor_subbab', $subab->nomor_subbab) }}"
                            required
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent"
                        />
                        <p id="errorNomorSubab" class="mt-1 text-sm text-red-500 hidden"></p>
                    </div>

                    <!-- Judul Subbab Field -->
                    <div>
                        <label for="judul_subbab" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Judul Subbab</label>
                        <input 
                            type="text" 
                            id="judul_subbab"
                            name="judul_subbab" 
                            value="{{ old('judul_subbab', $subab->judul_subbab) }}"
                            required
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent"
                        />
                        <p id="errorJudulSubab" class="mt-1 text-sm text-red-500 hidden"></p>
                    </div>

                    <div id="successMessage" class="hidden p-4 mb-4 text-green-800 bg-green-100 rounded-xl">
                        Subbab berhasil diperbarui! Mengalihkan...
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-6">
                        <button type="submit" class="flex-1 py-3 text-lg font-bold text-white bg-admin-orange hover:bg-opacity-90 rounded-xl transition-all font-jakarta">
                            Simpan
                        </button>
                        <a href="{{ url()->previous() }}" class="flex-1 py-3 text-lg font-bold text-center text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all font-jakarta">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

<script>
document.getElementById('subabEditForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const nomorSubab = document.getElementById('nomor_subbab').value;
    const judulSubab = document.getElementById('judul_subbab').value;
    const idSubab = document.querySelector('input[name="id_subab"]').value;
    
    document.getElementById('errorNomorSubab').classList.add('hidden');
    document.getElementById('errorJudulSubab').classList.add('hidden');
    
    try {
        const response = await fetch('/api/subab/' + idSubab, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
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