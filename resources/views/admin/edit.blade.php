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
        <!-- Sidebar -->
        <aside class="w-full md:w-80 lg:w-[506px] bg-sahabat-blue p-6 md:p-8 lg:p-9 flex-shrink-0">
            <div class="flex flex-col">
                <!-- Logo -->
                <div class="mb-8 md:mb-20 lg:mb-32">
                    <a href="/dashboard">
                        <h1 class="text-2xl font-bold text-white lg:text-3xl font-jakarta">SahabatBuku</h1>
                    </a>
                </div>

                <!-- Navigation -->
                <nav>
                    <a href="/dashboard" class="block py-2 text-xl text-white transition-colors bg-sahabat-blue md:text-2xl lg:text-4xl rounded-2xl md:py-3 lg:py-4 hover:bg-opacity-90 font-catamaran">
                        Data User
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex items-start justify-center flex-1 p-4 md:p-8 lg:p-12 xl:p-16">
            <div class="w-full max-w-5xl">
                <!-- Form Card -->
                <div class="bg-white rounded-3xl shadow-[0_0_8px_5px_rgba(0,0,0,0.25)] p-8 md:p-16 lg:p-20">
                    <!-- Form Title -->
                    <h1 class="mb-12 text-3xl font-normal text-center md:text-4xl lg:text-5xl md:mb-16 font-catamaran">
                        Edit Pengguna
                    </h1>

                    <!-- Error Messages -->
                    @if ($errors->any())
                    <div class="p-4 mb-8 border-l-4 border-red-500 bg-red-50">
                        <ul class="text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Form -->
                    <form action="/users/{{ $user->id }}" method="POST" class="max-w-3xl mx-auto space-y-8 md:space-y-12">
                        @csrf
                        @method('PUT')
                        
                        <!-- Username Field -->
                        <div>
                            <label for="name" class="block mb-3 text-base md:text-lg lg:text-xl md:mb-4 font-catamaran">
                                Username
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="w-full pb-2 text-base transition-colors bg-transparent border-0 border-b-2 border-black md:text-lg focus:outline-none focus:border-sahabat-blue font-catamaran"
                            />
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block mb-3 text-base md:text-lg lg:text-xl md:mb-4 font-catamaran">
                                Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="w-full pb-2 text-base transition-colors bg-transparent border-0 border-b-2 border-black md:text-lg focus:outline-none focus:border-sahabat-blue font-catamaran"
                            />
                        </div>

                        <!-- Kelas Field -->
                        <div>
                            <label for="kelas" class="block mb-3 text-base md:text-lg lg:text-xl md:mb-4 font-catamaran">
                                Kelas
                            </label>
                            <input
                                type="text"
                                id="kelas"
                                name="kelas"
                                value="{{ old('kelas', $user->kelas) }}"
                                class="w-full pb-2 text-base transition-colors bg-transparent border-0 border-b-2 border-black md:text-lg focus:outline-none focus:border-sahabat-blue font-catamaran"
                            />
                        </div>

                        <!-- Password Field (Optional for edit) -->
                        <div>
                            <label for="password" class="block mb-3 text-base md:text-lg lg:text-xl md:mb-4 font-catamaran">
                                Kata Sandi Baru (kosongkan jika tidak ingin mengubah)
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="w-full pb-2 text-base transition-colors bg-transparent border-0 border-b-2 border-black md:text-lg focus:outline-none focus:border-sahabat-blue font-catamaran"
                            />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-4 pt-6 md:pt-8">
                            <a href="/dashboard" class="flex-1 py-4 text-xl font-medium text-center text-white transition-all bg-gray-400 hover:bg-gray-500 md:text-2xl lg:text-3xl md:py-5 rounded-xl hover:shadow-lg font-catamaran">
                                Batal
                            </a>
                            <button
                                type="submit"
                                class="flex-1 py-4 text-xl font-medium text-white transition-all bg-sahabat-orange hover:bg-opacity-90 md:text-2xl lg:text-3xl md:py-5 rounded-xl hover:shadow-lg font-catamaran"
                            >
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>