<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Bab</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-gray-100 flex">

    {{-- Sidebar Admin --}}
    <x-admin-sidebar />

    {{-- MAIN CONTENT --}}
    <main class="flex w-full min-h-screen">

    <!-- Sidebar Bab -->
    <div class="w-95 bg-white border-r p-5 overflow-y-auto">

        <h2 class="text-lg font-semibold mb-4">
            Struktur Buku
        </h2>

        {{-- TAMBAH BAB --}}
        <a
            href="{{ route('bab.create',['id_buku'=>$id_buku]) }}"
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

                    <div class="flex gap-2">

                        <a
                            href="{{ route('bab.edit',$b->id_bab) }}"
                            class="text-xs bg-yellow-400 px-2 py-1 rounded"
                        >
                            Edit
                        </a>

                        <form
                            action="{{ route('bab.destroy',$b->id_bab) }}"
                            method="POST"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                class="text-xs bg-red-500 text-white px-2 py-1 rounded"
                                onclick="return confirm('Hapus bab ini?')"
                            >
                                Hapus
                            </button>

                        </form>

                    </div>

                </div>


                {{-- TAMBAH SUBAB --}}
                <a
                    href="{{ route('subab.create',['id_bab'=>$b->id_bab]) }}"
                    class="text-xs text-blue-600 mt-2 inline-block"
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

                            <div class="flex gap-1">

                                <a
                                    href="{{ route('subab.edit',$s->id_subbab) }}"
                                    class="text-xs bg-yellow-400 px-2 py-1 rounded"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('subab.destroy',$s->id_subbab) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="text-xs bg-red-500 text-white px-2 py-1 rounded"
                                        onclick="return confirm('Hapus subab?')"
                                    >
                                        Hapus
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
        <div class="flex-1 p-8">

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

                <h1 id="materiJudul" class="text-xl font-bold mb-4"></h1>

                <div id="materiIsi" class="prose max-w-none"></div>
                
            </div>

        </div>

    </main>



<script>

/* =========================
   BAB
========================= */

const dropdown = document.getElementById('babDropdown');
const textInfo = document.getElementById('babTerpilih');
const editBtn = document.getElementById('editBab');
const deleteBtn = document.getElementById('deleteBabBtn');
const deleteForm = document.getElementById('deleteBabForm');

if(dropdown){

    dropdown.addEventListener('change', function(){

        let id = this.value;
        let text = this.options[this.selectedIndex].text;

        textInfo.innerText = "Bab dipilih: " + text;

        if(id){

            editBtn.href = "/bab/" + id + "/edit";
            deleteForm.action = "/bab/" + id;

        }

    });

}

if(deleteBtn){

    deleteBtn.addEventListener('click', function(){

        if(confirm('Yakin ingin menghapus bab ini?')){
            deleteForm.submit();
        }

    });

}


/* =========================
   SUBAB
========================= */

const subabDropdown = document.getElementById('subabDropdown');
const editSubab = document.getElementById('editSubab');
const deleteSubabBtn = document.getElementById('deleteSubabBtn');
const deleteSubabForm = document.getElementById('deleteSubabForm');

if(subabDropdown){

    subabDropdown.addEventListener('change', function(){

        let id = this.value;

        if(id){

            editSubab.href = "/subab/" + id + "/edit";
            deleteSubabForm.action = "/subab/" + id;

        }

    });

}

if(deleteSubabBtn){

    deleteSubabBtn.addEventListener('click', function(){

        if(confirm('Yakin ingin menghapus subab ini?')){
            deleteSubabForm.submit();
        }

    });

}


/* =========================
   MATERI
========================= */

let subabAktif = null;


/* klik subab → load materi */

document.querySelectorAll('.subab-link').forEach(function(link){

    link.addEventListener('click', function(e){

        e.preventDefault();

        let id = this.dataset.id;

        subabAktif = id;

        fetch('/materi/subab/' + id)

        .then(res => res.json())

        .then(data => {

            document.getElementById('materiJudul').innerText =
                data?.judul_materi ?? '';

            document.getElementById('materiIsi').innerHTML =
                data?.isi ?? '';

        });

    });

});


/* tombol tambah materi */

const btnTambahMateri = document.getElementById('btnTambahMateri');

if(btnTambahMateri){

    btnTambahMateri.addEventListener('click', function(){

        if(!subabAktif){

            alert('Pilih subab terlebih dahulu');
            return;

        }

        window.location.href =
            "/materi/create?id_subbab=" + subabAktif;

    });

}

</script>


</body>
</html>