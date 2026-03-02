<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-admin-sidebar />
        <main class="flex items-start justify-center flex-1 p-4 md:p-6 lg:p-10 xl:p-10">
            <div class="w-full max-w-5xl">
                <div class="bg-white rounded-3xl shadow-[0_0_8px_5px_rgba(0,0,0,0.25)] p-8 md:p-16 lg:p-20">
                    <h1 class="mb-10 text-2xl font-bold text-center md:text-2xl lg:text-4xl md:mb-10 font-jakarta">
                        Edit Pengguna
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

                    <form action="/users/{{ $user->id }}" method="POST" enctype="multipart/form-data" class="max-w-3xl mx-auto space-y-8 md:space-y-12">
                        @csrf
                        @method('PUT')

                        <!-- Foto Field -->
                        <div>
                            <label class="block mb-3 text-base md:text-lg lg:text-l md:mb-4 font-jakarta">
                                Foto Profil
                            </label>
                            <div class="flex items-center gap-4 mb-4">
                                @if($user->foto)
                                    <img src="{{ asset('storage/' . $user->foto) }}" id="foto-preview" class="object-cover w-40 h-40 border-2 border-gray-200 rounded-full">
                                @else
                                    <div id="foto-preview-placeholder" class="flex items-center justify-center w-40 h-40 text-2xl text-gray-400 bg-gray-200 rounded-full">gaada</div>
                                @endif
                            </div>
                            <input
                                type="file"
                                name="foto"
                                accept="image/*"
                                onchange="previewImage(this)"
                                class="w-full text-base text-gray-500 cursor-pointer font-jakarta file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200"
                            />
                            <p class="mt-1 text-sm text-gray-400 font-jakarta">Kosongkan jika tidak ingin mengubah foto</p>
                        </div>

                        <!-- Username Field -->
                        <div>
                            <label for="name" class="block mb-3 text-base md:text-lg lg:text-l md:mb-4 font-jakarta">Username</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full pb-2 text-base transition-colors bg-transparent border-0 border-b-2 border-black md:text-lg focus:outline-none focus:border-sahabat-blue font-jakarta"/>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block mb-3 text-base md:text-lg lg:text-l md:mb-4 font-jakarta">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full pb-2 text-base transition-colors bg-transparent border-0 border-b-2 border-black md:text-lg focus:outline-none focus:border-sahabat-blue font-jakarta"/>
                        </div>

                        <!-- Kelas Field -->
                        <div>
                            <label for="kelas" class="block mb-3 text-base md:text-lg lg:text-l md:mb-4 font-jakarta">Kelas</label>
                            <select id="kelas" name="kelas" class="w-full pb-2 text-base transition-colors bg-transparent border-0 border-b-2 border-black md:text-lg focus:outline-none focus:border-sahabat-blue font-jakarta">
                                <option value="">-- Pilih Kelas --</option>
                                <option value="10" {{ old('kelas', $user->kelas) == '10' ? 'selected' : '' }}>10</option>
                                <option value="11" {{ old('kelas', $user->kelas) == '11' ? 'selected' : '' }}>11</option>
                                <option value="12" {{ old('kelas', $user->kelas) == '12' ? 'selected' : '' }}>12</option>
                            </select>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block mb-3 text-base md:text-lg lg:text-l md:mb-4 font-jakarta">
                                Kata Sandi Baru (kosongin aja kalau tidak diubah)
                            </label>
                            <input type="password" id="password" name="password"
                                class="w-full pb-2 text-base transition-colors bg-transparent border-0 border-b-2 border-black md:text-lg focus:outline-none focus:border-sahabat-blue font-jakarta"/>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-4 pt-6 md:pt-8">
                            <a href="/dashboard" class="flex-1 py-4 font-medium text-center text-white transition-all bg-gray-400 text-l hover:bg-gray-500 md:text-2xl lg:text-3xl md:py-5 rounded-xl hover:shadow-lg font-jakarta">
                                Batal
                            </a>
                            <button type="submit" class="flex-1 py-4 font-medium text-white transition-all text-l bg-sahabat-orange hover:bg-opacity-90 md:text-2xl lg:text-3xl md:py-3 rounded-xl hover:shadow-lg font-jakarta">
                                Simpan
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
                    let img = document.getElementById('foto-preview');
                    const placeholder = document.getElementById('foto-preview-placeholder');
                    if (!img) {
                        img = document.createElement('img');
                        img.id = 'foto-preview';
                        img.className = 'object-cover w-20 h-20 rounded-full border-2 border-gray-200';
                        if (placeholder) placeholder.replaceWith(img);
                    }
                    img.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>