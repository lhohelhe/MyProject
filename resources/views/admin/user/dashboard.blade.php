<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#F5F5F5]">
<div class="flex flex-col min-h-screen lg:flex-row">

    <x-admin-sidebar />

    <main class="flex-1 p-4 sm:p-6 lg:p-16">

        <h1 class="mb-6 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta lg:mb-10">
            Dashboard Admin
        </h1>

        <div class="flex flex-col items-start justify-between gap-4 p-2 mb-6 bg-white shadow-md rounded-xl lg:p-2 lg:flex-row lg:items-center">
            <div class="text-2xl font-semibold lg:text-xl font-jakarta">
                Total User: <span class="ml-2">{{ $users->count() }}</span>
            </div>
            <a href="/users/create" class="flex items-center gap-3 px-4 py-3 text-xl font-bold text-black bg-admin-orange rounded-xl hover:bg-opacity-90 lg:text-xl font-jakarta">
                <span>Tambah pengguna</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 lg:w-8 lg:h-8" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14"/>
                </svg>
            </a>
        </div>

        <!-- HEADER -->
        <div class="hidden p-4 mb-4 bg-white shadow-md lg:block rounded-2xl">
            <div class="grid grid-cols-6 gap-4 text-xl font-semibold text-center font-jakarta">
                <div>Foto</div>
                <div>Username</div>
                <div>Kelas</div>
                <div>Email</div>
                <div>Password</div>
                <div></div>
            </div>
        </div>

        @foreach ($users as $user)
        <div class="p-4 mb-4 bg-white shadow-md rounded-xl sm:p-6 lg:p-4 lg:mb-2">

            <!-- MOBILE (TIDAK DIUBAH) -->
            <div class="space-y-3 lg:hidden">
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">Username:</span>
                    <span>{{ $user->name }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">Kelas:</span>
                    <span>{{ $user->kelas ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">Email:</span>
                    <span class="break-all">{{ $user->email }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-600">Password:</span>
                    <span>{{ $user->password }}</span>
                </div>
            </div>

            <!-- DESKTOP -->
            <div class="items-center hidden grid-cols-6 gap-4 text-center text-l lg:grid font-jakarta">

                <!-- FOTO (BARU) -->
                <div class="flex justify-center">
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" class="object-cover w-12 h-12 rounded-full">
                    @else
                        <div class="flex items-center justify-center w-12 h-12 text-lg text-gray-400 bg-gray-200 rounded-full">?</div>
                    @endif
                </div>

                <div class="font-medium">{{ $user->name }}</div>
                <div class="font-medium">{{ $user->kelas ?? '-' }}</div>
                <div class="font-medium break-all">{{ $user->email }}</div>
                <div class="font-medium text-black">{{ $user->password }}</div>

                <!-- ACTION (ASLI, TIDAK DIUBAH) -->
                <div class="flex justify-center gap-6">
                    <a href="/users/{{ $user->id }}/edit" class="transition-opacity hover:opacity-80">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="text-admin-green fill-admin-green">
                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                            <path d="m15 5 4 4"/>
                        </svg>
                    </a>

                    <form action="/users/{{ $user->id }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="transition-opacity hover:opacity-80">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
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
        </div>
        @endforeach

        @if($users->isEmpty())
        <div class="p-8 text-center bg-white shadow-md rounded-2xl">
            <p class="text-2xl text-gray-500 font-jakarta">Belum ada user terdaftar</p>
        </div>
        @endif

    </main>
</div>
</body>
</html>