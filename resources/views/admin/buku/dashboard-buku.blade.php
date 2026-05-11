<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#F5F5F5]">
<div class="flex flex-col min-h-screen lg:flex-row">
    <x-admin-sidebar />

    <main class="flex-1 p-4 sm:p-6 lg:p-16">
        <h1 class="mb-6 text-3xl font-extrabold lg:text-4xl font-jakarta lg:mb-10">
            Data Buku
        </h1>
        
        <!-- Header -->
        <div class="flex flex-col items-start justify-between gap-4 p-2 mb-6 bg-white shadow-md rounded-xl lg:flex-row lg:items-center">
            <div class="text-2xl font-semibold font-jakarta">
                Total Buku: <span id="total-buku">0</span>
            </div>
            <a href="{{ route('dashboard-buku.create') }}" 
               class="flex items-center gap-3 px-4 py-3 text-xl font-bold text-black bg-admin-orange rounded-xl hover:bg-opacity-90 font-jakarta">
                <span>Tambah Buku</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 lg:w-8 lg:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14"/>
                </svg>
            </a>
        </div>

        <!-- Header Tabel -->
        <div class="hidden p-4 mb-4 bg-white shadow-md lg:block rounded-2xl">
            <div class="grid grid-cols-6 gap-4 text-xl font-semibold text-center font-jakarta">
                <div>Gambar</div>
                <div class="pl-2 text-left">Judul Buku</div>
                <div>Kategori</div>
                <div>Kelas</div>
                <div>Semester</div>
                <div></div>
            </div>
        </div>

        <!-- LIST DARI API -->
        <div id="list-buku"></div>

    </main>
</div>

<script>
async function loadBuku() {
    try {
        const response = await fetch('http://127.0.0.1:8000/api/buku');
        const result = await response.json();

        let data = result.data?.data || result.data || result;

        document.getElementById('total-buku').innerText = data.length;

        let html = '';

        if (data.length === 0) {
            html = `
                <div class="p-8 text-center bg-white shadow-md rounded-2xl">
                    <p class="text-2xl text-gray-500 font-jakarta">
                        Belum ada data buku terdaftar
                    </p>
                </div>
            `;
        } else {
            data.forEach(b => {
                html += `
                <div class="p-4 mb-4 bg-white shadow-md rounded-xl">
                    <div class="grid items-center grid-cols-6 gap-4 text-center font-jakarta">

                        <!-- Gambar -->
                        <div class="flex justify-center">
                            ${b.gambar 
                                ? `<img src="/storage/${b.gambar}" class="object-cover w-24 h-32 rounded-xl border">`
                                : `<div class="flex items-center justify-center w-24 h-32 bg-gray-200 rounded-xl">!</div>`
                            }
                        </div>

                        <!-- Judul -->
                        <div class="pl-4 text-left">${b.judul_buku}</div>

                        <!-- Kategori -->
                        <div>${b.kategori ? b.kategori.nama_kategori : '-'}</div>

                        <!-- Kelas -->
                        <div>${b.kelas}</div>

                        <!-- Semester -->
                        <div>${b.semester}</div>

                        <!-- Action -->
                        <div class="flex justify-center gap-4">
                            <a href="/admin/dashboard-buku/${b.id_buku}/edit" class="text-green-600">Edit</a>
                            <button onclick="deleteBuku(${b.id_buku})" class="text-red-600">Hapus</button>
                        </div>

                    </div>
                </div>
                `;
            });
        }

        document.getElementById('list-buku').innerHTML = html;

    } catch (error) {
        console.error('Error:', error);
    }
}

async function deleteBuku(id) {
    if (!confirm('Yakin ingin menghapus buku ini?')) return;

    await fetch(`http://127.0.0.1:8000/api/buku/${id}`, {
        method: 'DELETE'
    });

    loadBuku();
}

loadBuku();
</script>

</body>
</html>