<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subbab - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#F5F5F5]">
<div class="flex flex-col min-h-screen lg:flex-row">

    <x-admin-sidebar />

    <main class="flex-1 p-4 sm:p-6 lg:p-16">
        <div class="max-w-2xl">
            <h1 class="mb-8 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta">
                Edit Subbab
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

            <form method="POST" action="{{ route('subab.update', $subab->id_subbab) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nomor Subbab Field -->
                <div>
                    <label for="nomor_subbab" class="block mb-2 text-base font-jakarta">Nomor Subbab</label>
                    <input 
                        type="text" 
                        id="nomor_subbab"
                        name="nomor_subbab" 
                        value="{{ old('nomor_subbab', $subab->nomor_subbab) }}"
                        required
                        class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta"
                    />
                </div>

                <!-- Judul Subbab Field -->
                <div>
                    <label for="judul_subbab" class="block mb-2 text-base font-jakarta">Judul Subbab</label>
                    <input 
                        type="text" 
                        id="judul_subbab"
                        name="judul_subbab" 
                        value="{{ old('judul_subbab', $subab->judul_subbab) }}"
                        required
                        class="w-full pb-2 text-base bg-transparent border-0 border-b-2 border-black focus:outline-none focus:border-sahabat-blue font-jakarta"
                    />
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-6">
                    <a href="/admin/bab" class="flex-1 py-3 text-lg font-bold text-center text-white bg-gray-400 hover:bg-gray-500 rounded-xl transition-all font-jakarta">
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