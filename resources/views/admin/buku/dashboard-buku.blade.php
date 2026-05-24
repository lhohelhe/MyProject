@extends('layouts.admin')

@section('title', 'Data Buku - SahabatBuku')

@section('content')
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
                <div>Aksi</div>
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

        const activeMenu = new URLSearchParams(window.location.search).get('active_menu') || 'bab';

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
                let actionTitle = 'Kelola Bab';
                let actionIcon = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="text-admin-blue fill-admin-blue">
                        <path d="m12 3-10 5 10 5 10-5-10-5Z"/>
                        <path d="m2 17 10 5 10-5"/>
                        <path d="m2 12 10 5 10-5"/>
                    </svg>
                `;

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
                        <div class="flex justify-center items-center gap-4 flex-wrap">
                            <a href="/admin/bab?id_buku=${b.id_buku}&active_menu=${activeMenu}" class="transition-opacity hover:opacity-80" title="${actionTitle}">
                                ${actionIcon}
                            </a>
                            <a href="/admin/dashboard-buku/${b.id_buku}/edit" class="transition-opacity hover:opacity-80" title="Edit Buku">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="text-admin-green fill-admin-green">
                                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                    <path d="m15 5 4 4"/>
                                </svg>
                            </a>
                            <button onclick="deleteBuku(${b.id_buku})" class="transition-opacity hover:opacity-80" title="Hapus Buku">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="text-admin-red fill-admin-red">
                                    <path d="M3 6h18"/>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                </svg>
                            </button>
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
@endsection