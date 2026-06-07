@extends('layouts.admin')

@section('title', 'Kelola Bab - SahabatBuku')

@section('content')
<div class="flex flex-col lg:flex-row gap-6 min-h-[calc(100vh-120px)]">
    <!-- Sidebar Bab -->
    <div class="w-full lg:w-96 bg-white border border-slate-200 p-5 rounded-2xl shadow-sm overflow-y-auto">

        <h2 class="text-lg font-semibold mb-4">
            Struktur Buku
        </h2>

        {{-- TAMBAH BAB --}}
        <a
            href="{{ route('bab.create',['id_buku'=>$id_buku, 'active_menu' => request()->input('active_menu')]) }}"
            class="block mb-4 text-center bg-blue-600 text-white py-2 rounded text-sm hover:bg-blue-700"
        >
            + Tambah Bab
        </a>


        {{-- LIST BAB --}}
        @foreach($bab as $b)

            <div class="mb-4 border rounded p-3 bg-gray-50">

                {{-- HEADER BAB --}}
                <div class="flex justify-between items-center">

                    <div class="font-semibold">

                        Bab {{ $b->nomor_bab }}  
                        <br>
                        <span class="text-sm text-gray-600">
                            {{ $b->judul_bab }}
                        </span>

                    </div>

                    <div class="flex items-center gap-1">
                        <a
                            href="{{ route('bab.edit',['bab' => $b->id_bab, 'active_menu' => request()->input('active_menu')]) }}"
                            class="transition-opacity hover:opacity-80"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="text-admin-green fill-admin-green">
                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                <path d="m15 5 4 4"/>
                            </svg>
                        </a>

                        <form
                            action="{{ route('bab.destroy',$b->id_bab) }}"
                            method="POST"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                class="transition-opacity hover:opacity-80"
                                onclick="return confirm('Hapus bab ini?')"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="text-admin-red fill-admin-red">
                                    <path d="M3 6h18"/>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                </div>


                {{-- TAMBAH SUBAB --}}
                <a
                    href="{{ route('subab.create',['id_bab'=>$b->id_bab, 'active_menu' => request()->input('active_menu')]) }}"
                    class="text-xs text-blue-600 mt-2 inline-block font-semibold"
                >
                    + Tambah Subab
                </a>


                {{-- LIST SUBAB --}}
                <ul class="mt-2 pl-4">

                    @foreach($b->subab as $s)

                        <li class="flex justify-between items-center text-sm py-1">

                            <span class="mr-2">
                                <a 
                                href="#"
                                class="subab-link block text-sm text-gray-700 hover:text-blue-600"
                                data-id="{{ $s->id_subbab }}"
                                >

                                {{ $s->nomor_subbab }} {{ $s->judul_subbab }}

                                </a>
                            </span>

                             <div class="flex items-center gap-1">
                                <a
                                    href="{{ route('subab.edit',['subab' => $s->id_subbab, 'active_menu' => request()->input('active_menu')]) }}"
                                    class="transition-opacity hover:opacity-80"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="text-admin-green fill-admin-green">
                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                        <path d="m15 5 4 4"/>
                                    </svg>
                                </a>

                                <form
                                    action="{{ route('subab.destroy',$s->id_subbab) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="transition-opacity hover:opacity-80"
                                        onclick="return confirm('Hapus subab?')"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="text-admin-red fill-admin-red">
                                            <path d="M3 6h18"/>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                        </li>

                    @endforeach

                </ul>

            </div>

        @endforeach

    </div>
        {{-- KONTEN MATERI --}}
        <div class="flex-1 bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">

            <div class="flex items-center mb-3 justify-between">
                <div>
                    <h1 class="text-2xl font-bold">
                    Materi Bab
                    </h1>
                    <p class="text-gray-600">
                        Pilih bab di sidebar untuk melihat materi.
                    </p>
                </div>
                    <button
                    id="btnTambahMateri"
                    class="bg-blue-600 text-white px-4 py-2 rounded text-sm"
                    >
                    + Tambah Materi
                    </button>

            </div>

            <div class="mt-6 bg-white rounded shadow p-6">

                <div class="flex justify-between items-center mb-4 border-b pb-4">
                    <h1 id="materiJudul" class="text-xl font-bold"></h1>
                    <div id="materiActions" class="flex items-center gap-2 hidden">
                        <!-- Edit Button -->
                        <a id="editMateriBtn" href="#" class="transition-opacity hover:opacity-80">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="text-admin-green fill-admin-green">
                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                <path d="m15 5 4 4"/>
                            </svg>
                        </a>
                        <!-- Delete Button -->
                        <form id="deleteMateriForm" action="#" method="POST" onsubmit="return confirm('Yakin ingin menghapus materi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="transition-opacity hover:opacity-80">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="text-admin-red fill-admin-red">
                                    <path d="M3 6h18"/>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <div id="materiIsi" class="prose max-w-none"></div>
                
            </div>

        </div>
</div>



<script>
const activeMenu = new URLSearchParams(window.location.search).get('active_menu') || 'bab';
const idBuku = new URLSearchParams(window.location.search).get('id_buku');

/* =========================
   LOAD BAB FROM API
========================= */

function loadBab() {
    fetch('/api/bab?id_buku=' + idBuku)
        .then(res => res.json())
        .then(data => {
            const babList = document.getElementById('babList');
            babList.innerHTML = '';
            
            data.forEach(bab => {
                const babDiv = document.createElement('div');
                babDiv.className = 'mb-4 border rounded p-3 bg-gray-50';
                babDiv.innerHTML = `
                    <div class="flex justify-between items-center">
                        <div class="font-semibold">
                            Bab ${bab.nomor_bab}
                            <br>
                            <span class="text-sm text-gray-600">${bab.judul_bab}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <a href="/admin/bab/${bab.id_bab}/edit?id_buku=${idBuku}&active_menu=${activeMenu}" class="transition-opacity hover:opacity-80">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-admin-green fill-admin-green">
                                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/>
                                </svg>
                            </a>
                            <button onclick="deleteBab(${bab.id_bab})" class="transition-opacity hover:opacity-80">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-admin-red fill-admin-red">
                                    <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <a href="/admin/subab/create?id_bab=${bab.id_bab}&active_menu=${activeMenu}" class="text-xs text-blue-600 mt-2 inline-block font-semibold">+ Tambah Subab</a>
                    <ul class="mt-2 pl-4" id="subab-${bab.id_bab}"></ul>
                `;
                babList.appendChild(babDiv);
                loadSubab(bab.id_bab);
            });
        });
}

function loadSubab(idBab) {
    fetch('/api/subab?id_bab=' + idBab)
        .then(res => res.json())
        .then(data => {
            const subabList = document.getElementById('subab-' + idBab);
            subabList.innerHTML = '';
            
            data.forEach(subab => {
                const li = document.createElement('li');
                li.className = 'flex justify-between items-center text-sm py-1';
                li.innerHTML = `
                    <span class="mr-2">
                        <a href="#" class="subab-link block text-sm text-gray-700 hover:text-blue-600" data-id="${subab.id_subbab}">
                            ${subab.nomor_subbab} ${subab.judul_subbab}
                        </a>
                    </span>
                    <div class="flex items-center gap-1">
                        <a href="/admin/subab/${subab.id_subbab}/edit?active_menu=${activeMenu}" class="transition-opacity hover:opacity-80">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-admin-green fill-admin-green">
                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/>
                            </svg>
                        </a>
                        <button onclick="deleteSubab(${subab.id_subbab})" class="transition-opacity hover:opacity-80">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-admin-red fill-admin-red">
                                <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                            </svg>
                        </button>
                    </div>
                `;
                subabList.appendChild(li);
            });
            
            attachSubabLinks();
        });
}

function deleteBab(id) {
    if(!confirm('Hapus bab ini?')) return;
    
    fetch('/api/bab/' + id, { method: 'DELETE' })
        .then(res => res.json())
        .then(data => {
            loadBab();
        });
}

function deleteSubab(id) {
    if(!confirm('Hapus subab?')) return;
    
    fetch('/api/subab/' + id, { method: 'DELETE' })
        .then(res => res.json())
        .then(data => {
            loadBab();
        });
}

function attachSubabLinks() {
    document.querySelectorAll('.subab-link').forEach(function(link){
        link.addEventListener('click', function(e){
            e.preventDefault();
            let id = this.dataset.id;
            subabAktif = id;

            fetch('/api/materi?id_subbab=' + id)
                .then(res => res.json())
                .then(data => {
                    if(data && data.length > 0) {
                        const materi = data[0];
                        document.getElementById('materiJudul').innerText = materi.judul_materi;
                        document.getElementById('materiIsi').innerHTML = materi.isi;
                        document.getElementById('editMateriBtn').href = "/admin/materi/" + materi.id_materi + "/edit?active_menu=" + activeMenu;
                        document.getElementById('deleteMateriForm').action = "/admin/materi/" + materi.id_materi;
                        document.getElementById('materiActions').classList.remove('hidden');
                        document.getElementById('btnTambahMateri').classList.add('hidden');
                    } else {
                        document.getElementById('materiJudul').innerText = 'Belum ada materi';
                        document.getElementById('materiIsi').innerHTML = '<p class="text-slate-400">Silakan tambahkan materi untuk subab ini.</p>';
                        document.getElementById('materiActions').classList.add('hidden');
                        document.getElementById('btnTambahMateri').classList.remove('hidden');
                    }
                });
        });
    });
}

// Inisialisasi
loadBab();

/* =========================
   MATERI
========================= */

let subabAktif = null;

const btnTambahMateri = document.getElementById('btnTambahMateri');

if(btnTambahMateri){
    btnTambahMateri.addEventListener('click', function(){
        if(!subabAktif){
            alert('Pilih subab terlebih dahulu');
            return;
        }
        window.location.href = "/admin/materi/create?id_subbab=" + subabAktif + "&active_menu=" + activeMenu;
    });
}

</script>


@endsection