<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
<div class="flex flex-col min-h-screen md:flex-row">
    <x-admin-sidebar />
    <main class="flex-1 p-6 md:p-8 lg:p-10">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-3xl shadow-[0_0_8px_5px_rgba(0,0,0,0.25)] p-8 md:p-12">
                <h1 class="mb-10 text-2xl font-bold text-center md:text-3xl font-jakarta">
                    Tambah Buku Baru
                </h1>

                <form id="form-create" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">
<<<<<<< HEAD
=======
                        
                        <!-- KIRI -->
>>>>>>> 9c67793f02e80bf500aa472bea924463f327f82a
                        <div class="flex flex-col items-center lg:col-span-5">
                            <label class="block mb-4 text-base text-center font-jakarta">Cover Buku</label>
                            <div id="cover-preview" 
                                 class="flex items-center justify-center w-full max-w-sm text-gray-300 bg-gray-100 border border-gray-200 h-96 text-8xl rounded-2xl"
                                 style="aspect-ratio: 717 / 1027;">
                                ?
                            </div>
                            <div class="w-full max-w-sm mt-6">
                                <input type="file" 
                                       name="gambar" 
                                       accept="image/*"
                                       onchange="previewImage(this)"
                                       required
                                       class="w-full text-sm text-gray-500 cursor-pointer font-jakarta file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200"/>
                            </div>
                        </div>

                        <!-- KANAN -->
                        <div class="lg:col-span-7">
                            <div class="space-y-6">

                            <div>
                                <label class="block mb-2 text-base font-jakarta">Judul Buku</label>
                                <input type="text" id="judul_buku" required
                                       class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta"/>
                            </div>

                            <div>
                                <label class="block mb-2 text-base font-jakarta">Kategori</label>
                                <select id="id_kategori" required
                                        class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block mb-2 text-base font-jakarta">Kelas</label>
                                    <select id="kelas" required
                                            class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta">
                                        <option value="" disabled selected>Pilih Kelas</option>
                                        <option value="10">10 (X)</option>
                                        <option value="11">11 (XI)</option>
                                        <option value="12">12 (XII)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-2 text-base font-jakarta">Semester</label>
                                    <select id="semester" required
                                            class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta">
                                        <option value="" disabled selected>Pilih Semester</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-base font-jakarta">Deskripsi</label>
                                <textarea id="deskripsi"
                                          placeholder="Tambahkan deskripsi buku..."
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
                                    Tambah Buku
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
// load kategori dari API
async function loadKategori() {
    const res = await fetch('/api/kategori');
    const data = await res.json();

    let html = '<option value="" disabled selected>Pilih Kategori</option>';
    data.forEach(k => {
        html += `<option value="${k.id_kategori}">${k.nama_kategori}</option>`;
    });

    document.getElementById('id_kategori').innerHTML = html;
}

// submit ke API
document.getElementById('form-create').addEventListener('submit', async function(e){
    e.preventDefault();

    const formData = new FormData();
    formData.append('judul_buku', document.getElementById('judul_buku').value);
    formData.append('id_kategori', document.getElementById('id_kategori').value);
    formData.append('kelas', document.getElementById('kelas').value);
    formData.append('semester', document.getElementById('semester').value);
    formData.append('deskripsi', document.getElementById('deskripsi').value);

    const file = document.querySelector('input[name="gambar"]').files[0];
    if (file) formData.append('gambar', file);

    await fetch('/api/buku', {
        method: 'POST',
        body: formData
    });

    window.location.href = '/admin/dashboard-buku';
});

// preview gambar (tidak diubah)
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById('cover-preview');
            preview.innerHTML = `<img src="${e.target.result}" class="object-cover w-full h-full border border-gray-200 rounded-2xl" style="aspect-ratio: 717 / 1027;">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

loadKategori();
</script>
</body>
</html>