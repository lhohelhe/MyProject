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

        {{-- SIDEBAR BAB --}}
        <div class="w-72 bg-white border-r p-5">

            <h2 class="text-lg font-semibold mb-4">
                Kelola Bab
            </h2>

            {{-- FORM TAMBAH BAB --}}
            <form action="{{ route('bab.store') }}" method="POST" class="space-y-2">
                @csrf

                <input type="hidden" name="id_buku" value="{{ $id_buku }}">

                <input 
                    type="number"
                    name="nomor_bab"
                    placeholder="Nomor Bab"
                    class="w-full border rounded px-3 py-2 text-sm"
                >

                <input 
                    type="text"
                    name="judul_bab"
                    placeholder="Judul Bab"
                    class="w-full border rounded px-3 py-2 text-sm"
                >

                <button class="w-full bg-blue-600 text-black py-2 rounded text-sm hover:bg-blue-700">
                    + Tambah Bab
                </button>

            </form>

            <hr class="my-5">

            {{-- DROPDOWN BAB --}}
            <label class="text-sm font-medium text-gray-600">
                Pilih Bab
            </label>

            <select 
                id="babDropdown"
                class="w-full border rounded px-3 py-2 mt-1 text-sm"
            >

                <option value="">-- Pilih Bab --</option>

                @foreach($bab as $b)

                <option value="{{ $b->id_bab }}">
                    Bab {{ $b->nomor_bab }} - {{ $b->judul_bab }}
                </option>

                @endforeach

            </select>
            <p id="babTerpilih" class="text-xs text-gray-500 mt-2"></p>
            <script>
            document.getElementById('babDropdown').addEventListener('change', function(){

                let text = this.options[this.selectedIndex].text;

                document.getElementById('babTerpilih').innerText =
                    "Bab dipilih: " + text;

            });
            </script>
            <button class="mt-3 w-full bg-yellow-500 text-white py-2 rounded text-sm hover:bg-yellow-600">
                Edit Bab
            </button>

        </div>


        {{-- KONTEN MATERI --}}
        <div class="flex-1 p-8">

            <h1 class="text-2xl font-bold mb-3">
                Materi Bab
            </h1>

            <p class="text-gray-600">
                Pilih bab di sidebar untuk melihat materi.
            </p>

            <div class="mt-6 bg-white rounded shadow p-6">

                <p class="text-gray-400 text-sm">
                    Materi akan tampil di sini nanti.
                </p>

            </div>

        </div>

    </main>

</body>
</html>