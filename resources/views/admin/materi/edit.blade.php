<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Materi - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#F5F5F5]">
<div class="flex flex-col min-h-screen lg:flex-row">

    <x-admin-sidebar />

    <main class="flex-1 p-4 sm:p-6 lg:p-16">
        <div class="max-w-2xl">
            <h1 class="mb-8 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta">
                Edit Materi
            </h1>

            @if ($errors->any())
            <div class="p-4 mb-6 border-l-4 border-red-500 bg-red-50">
                <ul class="text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('materi.update', $materi->id_materi) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Judul Materi Field -->
                <div>
                    <label for="judul_materi" class="block mb-2 text-base font-jakarta">Judul Materi</label>
                    <input 
                        type="text" 
                        id="judul_materi"
                        name="judul_materi" 
                        value="{{ old('judul_materi', $materi->judul_materi) }}"
                        required
                        class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta"
                    />
                </div>

                <!-- Isi Materi Field -->
                <div>
                    <label for="isi" class="block mb-2 text-base font-jakarta">Isi Materi</label>
                    <textarea 
                        id="isi"
                        name="isi" 
                        rows="8"
                        required
                        class="w-full p-4 text-base border-2 border-gray-200 rounded-xl focus:outline-none focus:border-sahabat-blue focus:ring-2 focus:ring-sahabat-blue font-jakarta"
                    >{{ old('isi', $materi->isi) }}</textarea>
                </div>

                <!-- Gambar Field -->
                <div>
                    <label for="gambar" class="block mb-2 text-base font-jakarta">Gambar (opsional)</label>
                    
                    @if($materi->gambar)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2 font-jakarta">Gambar Saat Ini:</p>
                        <img src="{{ Storage::url($materi->gambar) }}" alt="Gambar Materi" class="max-w-xs h-auto rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-400 mt-2 font-jakarta">Upload gambar baru untuk menggantinya</p>
                    </div>
                    @endif

                    <input 
                        type="file" 
                        id="gambar"
                        name="gambar" 
                        accept="image/*"
                        class="w-full text-base text-gray-500 cursor-pointer font-jakarta file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200"
                    />
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-6">
                    <a href="/admin/materi" class="flex-1 py-3 text-lg font-bold text-center text-white bg-gray-400 hover:bg-gray-500 rounded-xl transition-all font-jakarta">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 py-3 text-lg font-bold text-white bg-admin-orange hover:bg-opacity-90 rounded-xl transition-all font-jakarta">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>