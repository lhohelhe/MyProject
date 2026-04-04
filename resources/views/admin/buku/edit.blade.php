<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">

    <div class="flex flex-col min-h-screen md:flex-row">
        <x-admin-sidebar />

        <main class="flex-1 p-6 md:p-8 lg:p-10">
            <div class="max-w-6xl mx-auto">
                <div class="bg-white rounded-3xl shadow-[0_0_8px_5px_rgba(0,0,0,0.25)] p-8 md:p-12">

                    <h1 class="mb-10 text-2xl font-bold text-center md:text-3xl font-jakarta">
                        Edit Buku
                    </h1>

                    @if ($errors->any())
                    <div class="p-4 mb-8 border-l-4 border-red-500 bg-red-50">
                        <ul class="text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('dashboard-buku.update', $buku->id_buku) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid items-start grid-cols-1 gap-12 lg:grid-cols-12">
                            
                            <!-- KIRI: Gambar Cover (tinggi & proporsional buku) -->
                            <div class="flex flex-col items-center lg:col-span-5">
                                <label class="block mb-4 text-base font-jakarta">Cover Buku Saat Ini</label>
                                
                                @if($buku->gambar)
                                    <img src="{{ Storage::url($buku->gambar) }}" 
                                         id="cover-preview"
                                         class="object-cover w-full max-w-xs border border-gray-200 shadow-sm rounded-2xl"
                                         style="aspect-ratio: 717 / 1027;">
                                @else
                                    <div id="cover-preview-placeholder"
                                         class="flex items-center justify-center w-full max-w-xs text-gray-300 bg-gray-100 border border-gray-200 h-96 text-8xl rounded-2xl">
                                        kosong
                                    </div>
                                @endif

                                <div class="w-full max-w-xs mt-6">
                                    <input type="file" 
                                           name="gambar" 
                                           accept="image/*"
                                           onchange="previewImage(this)"
                                           class="w-full text-sm text-gray-500 cursor-pointer font-jakarta file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200"/>
                                    <p class="mt-2 text-xs text-center text-gray-400">Kosongkan jika tidak ingin mengubah cover</p>
                                </div>
                            </div>

                            <!-- KANAN: Form Fields -->
                            <div class="lg:col-span-7">
                                <div class="space-y-6">

                                <div>
                                    <label for="judul_buku" class="block mb-2 text-base font-jakarta">Judul Buku</label>
                                    <input type="text" id="judul_buku" name="judul_buku" 
                                           value="{{ old('judul_buku', $buku->judul_buku) }}" required
                                           class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta"/>
                                </div>

                                <div>
                                    <label for="id_kategori" class="block mb-2 text-base font-jakarta">Kategori</label>
                                    <select name="id_kategori" id="id_kategori" required
                                            class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta">
                                        <option value="" disabled>Pilih Kategori</option>
                                        @foreach($kategori as $k)
                                            <option value="{{ $k->id_kategori }}" 
                                                    {{ old('id_kategori', $buku->id_kategori) == $k->id_kategori ? 'selected' : '' }}>
                                                {{ $k->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label for="kelas" class="block mb-2 text-base font-jakarta">Kelas</label>
                                        <select name="kelas" id="kelas" required
                                                class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta">
                                            <option value="" disabled>Pilih Kelas</option>
                                            <option value="10" {{ old('kelas', $buku->kelas) == '10' ? 'selected' : '' }}>10 (X)</option>
                                            <option value="11" {{ old('kelas', $buku->kelas) == '11' ? 'selected' : '' }}>11 (XI)</option>
                                            <option value="12" {{ old('kelas', $buku->kelas) == '12' ? 'selected' : '' }}>12 (XII)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="semester" class="block mb-2 text-base font-jakarta">Semester</label>
                                        <select name="semester" id="semester" required
                                                class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta">
                                            <option value="" disabled>Pilih Semester</option>
                                            <option value="1" {{ old('semester', $buku->semester) == '1' ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ old('semester', $buku->semester) == '2' ? 'selected' : '' }}>2</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="deskripsi" class="block mb-2 text-base font-jakarta">Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi"
                                              placeholder="Tambahkan deskripsi buku..."
                                              rows="4"
                                              class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg font-jakarta focus:outline-none focus:ring-2 focus:ring-sahabat-blue">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                                </div>

                                <div class="flex gap-4 pt-8">
                                    <a href="{{ route('dashboard-buku.index') }}" 
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
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    let img = document.getElementById('cover-preview');
                    if (!img) {
                        const placeholder = document.getElementById('cover-preview-placeholder');
                        if (placeholder) placeholder.style.display = 'none';
                        img = document.createElement('img');
                        img.id = 'cover-preview';
                        img.className = 'w-full max-w-xs rounded-2xl border border-gray-200 shadow-sm';
                        document.querySelector('.lg\\:col-span-5').prepend(img);
                    }
                    img.src = e.target.result;
                    img.style.aspectRatio = '717 / 1027';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>