<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-admin-sidebar />
        <main class="flex items-start justify-center flex-1 p-4 md:p-8 lg:p-12 xl:p-16">
            <div class="w-full max-w-5xl">
                <div class="bg-white rounded-3xl shadow-[0_0_8px_5px_rgba(0,0,0,0.25)] p-8 md:p-16 lg:p-20">
                    <h1 class="mb-12 text-3xl font-normal text-center md:text-4xl lg:text-5xl md:mb-16 font-catamaran">
                        Tambah Pengguna
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

                    <form action="/users" method="POST" enctype="multipart/form-data" class="max-w-3xl mx-auto space-y-8 md:space-y-12">
                        @csrf

                        <!-- Foto Field -->
                        <div>
                            <label class="block mb-3 text-base md:text-lg lg:text-xl md:mb-4 font-catamaran">
                                Foto Profil (opsional)
                            </label>
                            <div class="flex items-center gap-6 mb-4">
                                <div id="foto-preview-placeholder" class="flex items-center justify-center w-40 h-40 text-2xl text-gray-400 bg-gray-200 rounded-full">gaada</div>
                            </div>
                            <input
                                type="file"
                                name="foto"
                                accept="image/*"
                                onchange="previewImage(this)"
                                class="w-full text-base text-gray-500 cursor-pointer font-catamaran file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200"
                            />
                        </div>

                        <!-- Username Field -->
                        <div>
                            <label for="name" class="block mb-3 text-base md:text-lg lg:text-xl md:mb-4 font-catamaran">Username</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full pb-2 text-base transition-colors bg-transparent border-0 border-b-2 border-black md:text-lg focus:outline-none focus:border-sahabat-blue font-catamaran"/>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block mb-3 text-base md:text-lg lg:text-xl md:mb-4 font-catamaran">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full pb-2 text-base transition-colors bg-transparent border-0 border-b-2 border-black md:text-lg focus:outline-none focus:border-sahabat-blue font-catamaran"/>
                        </div>

                        <!-- Kelas Field -->
                        <div>
                            <label for="kelas" class="block mb-3 text-base md:text-lg lg:text-xl md:mb-4 font-catamaran">Kelas</label>
                            <select id="kelas" name="kelas" class="w-full pb-2 text-base transition-colors bg-transparent border-0 border-b-2 border-black md:text-lg focus:outline-none focus:border-sahabat-blue font-catamaran">
                                <option value="">-- Pilih Kelas --</option>
                                <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>10</option>
                                <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>11</option>
                                <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>12</option>
                            </select>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block mb-3 text-base md:text-lg lg:text-xl md:mb-4 font-catamaran">Buat Kata Sandi</label>
                            <input type="password" id="password" name="password" required
                                class="w-full pb-2 text-base transition-colors bg-transparent border-0 border-b-2 border-black md:text-lg focus:outline-none focus:border-sahabat-blue font-catamaran"/>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-4 pt-6 md:pt-8">
                            <a href="/dashboard" class="flex-1 py-4 text-xl font-medium text-center text-white transition-all bg-gray-400 hover:bg-gray-500 md:text-2xl lg:text-3xl md:py-5 rounded-xl hover:shadow-lg font-catamaran">
                                Batal
                            </a>
                            <button type="submit" class="flex-1 py-4 text-xl font-medium text-white transition-all bg-sahabat-orange hover:bg-opacity-90 md:text-2xl lg:text-3xl md:py-5 rounded-xl hover:shadow-lg font-catamaran">
                                Lanjut
                            </button>
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
                    const placeholder = document.getElementById('foto-preview-placeholder');
                    const img = document.createElement('img');
                    img.id = 'foto-preview';
                    img.className = 'object-cover w-20 h-20 rounded-full border-2 border-gray-200';
                    img.src = e.target.result;
                    if (placeholder) placeholder.replaceWith(img);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>