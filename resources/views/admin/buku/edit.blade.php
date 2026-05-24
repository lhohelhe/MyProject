@extends('layouts.admin')

@section('title', 'Edit Buku - SahabatBuku')

@section('content')
            <div class="max-w-6xl mx-auto">
                <div class="bg-white rounded-3xl shadow-[0_0_8px_5px_rgba(0,0,0,0.25)] p-8 md:p-12">

                    <h1 class="mb-10 text-2xl font-bold text-center md:text-3xl font-jakarta">
                        Edit Buku
                    </h1>

                    <form id="form-edit" enctype="multipart/form-data">
                        <div class="grid items-start grid-cols-1 gap-12 lg:grid-cols-12">
                            
                            <!-- KIRI -->
                            <div class="flex flex-col items-center lg:col-span-5">
                                <label class="block mb-4 text-base font-jakarta">Cover Buku Saat Ini</label>
                                
                                <img id="cover-preview"
                                     class="object-cover w-full max-w-xs border border-gray-200 shadow-sm rounded-2xl"
                                     style="aspect-ratio: 717 / 1027; display:none;">

                                <div id="cover-preview-placeholder"
                                     class="flex items-center justify-center w-full max-w-xs text-gray-300 bg-gray-100 border border-gray-200 h-96 text-8xl rounded-2xl">
                                    kosong
                                </div>

                                <div class="w-full max-w-xs mt-6">
                                    <input type="file" 
                                           name="gambar" 
                                           accept="image/*"
                                           onchange="previewImage(this)"
                                           class="w-full text-sm text-gray-500 cursor-pointer font-jakarta file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200"/>
                                    <p class="mt-2 text-xs text-center text-gray-400">Kosongkan jika tidak ingin mengubah cover</p>
                                </div>
                            </div>

                            <!-- KANAN -->
                            <div class="lg:col-span-7">
                                <div class="space-y-6">

                                <div>
                                    <label class="block mb-2 text-base font-jakarta">Judul Buku</label>
                                    <input type="text" id="judul_buku"
                                           class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta"/>
                                </div>

                                <div>
                                    <label class="block mb-2 text-base font-jakarta">Kategori</label>
                                    <select id="id_kategori"
                                            class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta">
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block mb-2 text-base font-jakarta">Kelas</label>
                                        <select id="kelas"
                                                class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta">
                                            <option value="10">10 (X)</option>
                                            <option value="11">11 (XI)</option>
                                            <option value="12">12 (XII)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-base font-jakarta">Semester</label>
                                        <select id="semester"
                                                class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block mb-2 text-base font-jakarta">Deskripsi</label>
                                    <textarea id="deskripsi"
                                              rows="4"
                                              class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg font-jakarta focus:outline-none focus:ring-2 focus:ring-sahabat-blue"></textarea>
                                </div>

                                <div class="flex gap-4 pt-8">
                                    <a href="/admin/dashboard-buku" 
                                       class="flex-1 py-4 text-center text-white bg-gray-400 hover:bg-gray-500 rounded-xl font-jakarta">
                                        Batal
                                    </a>
                                    <button type="submit" 
                                            class="flex-1 py-4 text-white bg-sahabat-orange hover:bg-opacity-90 rounded-xl font-jakarta">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </main>
    </div>

<script>
const id = window.location.pathname.split('/').pop();

async function loadBuku() {
    const res = await fetch(`/api/buku/${id}`);
    const result = await res.json();
    const data = result.data || result;

    document.getElementById('judul_buku').value = data.judul_buku;
    document.getElementById('kelas').value = data.kelas;
    document.getElementById('semester').value = data.semester;
    document.getElementById('deskripsi').value = data.deskripsi || '';

    if (data.gambar) {
        document.getElementById('cover-preview').src = '/storage/' + data.gambar;
        document.getElementById('cover-preview').style.display = 'block';
        document.getElementById('cover-preview-placeholder').style.display = 'none';
    }

    // kategori
    const kRes = await fetch('/api/kategori');
    const kategori = await kRes.json();

    let html = '';
    kategori.forEach(k => {
        html += `<option value="${k.id_kategori}" ${k.id_kategori == data.id_kategori ? 'selected' : ''}>${k.nama_kategori}</option>`;
    });

    document.getElementById('id_kategori').innerHTML = html;
}

document.getElementById('form-edit').addEventListener('submit', async function(e){
    e.preventDefault();

    const formData = new FormData();
    formData.append('judul_buku', document.getElementById('judul_buku').value);
    formData.append('id_kategori', document.getElementById('id_kategori').value);
    formData.append('kelas', document.getElementById('kelas').value);
    formData.append('semester', document.getElementById('semester').value);
    formData.append('deskripsi', document.getElementById('deskripsi').value);
    formData.append('_method', 'PUT');

    const file = document.querySelector('input[name="gambar"]').files[0];
    if (file) formData.append('gambar', file);

    await fetch(`/api/buku/${id}`, {
        method: 'POST',
        body: formData
    });

    window.location.href = '/admin/dashboard-buku';
});

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            let img = document.getElementById('cover-preview');
            img.src = e.target.result;
            img.style.display = 'block';
            document.getElementById('cover-preview-placeholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

loadBuku();
</script>
@endsection