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
        <!-- Sidebar -->
        <aside class="flex-shrink-0 w-full lg:w-52 bg-admin-sidebar">
            <div class="p-4 lg:p-6">
                <!-- Logo -->
                <div class="flex items-center gap-2 mb-6 lg:mb-12">
                    <img src="/images/logo_sahabatbuku_white.png" alt="SahabatBuku Logo" class="w-10 h-10 lg:w-12 lg:h-12"/>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32
                        <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
                    </svg>
                </div>

                <!-- Menu -->
                <nav>
                    <div class="text-base text-white lg:text-lg font-jakarta">
                        Data User
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-16">
            <!-- Page Title -->
            <h1 class="mb-6 text-3xl font-extrabold sm:text-4xl lg:text-6xl font-jakarta lg:mb-12">
                Dashboard Admin
            </h1>

            <!-- Total User Card -->
            <div class="flex flex-col items-start justify-between gap-4 p-6 mb-6 bg-white shadow-md rounded-2xl lg:p-8 lg:flex-row lg:items-center">
                <div class="text-2xl font-semibold lg:text-3xl font-jakarta">
                    Total User: <span class="ml-4">{{ $users->count() }}</span>
                </div>
                <a href="/users/create" class="flex items-center gap-3 px-6 py-3 text-xl font-semibold text-black transition-colors bg-admin-orange rounded-xl lg:text-2xl font-jakarta hover:bg-opacity-90">
                    <span>Tambah pengguna</span>
                    <div class="w-6 h-6 lg:w-8 lg:h-8">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-full h-full">
                            <path d="M5 12h14"/>
                            <path d="M12 5v14"/>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Table Header - Hidden on mobile, shown on desktop -->
            <div class="hidden p-8 mb-6 bg-white shadow-md lg:block rounded-2xl">
                <div class="grid grid-cols-5 gap-4 text-4xl font-medium text-center font-catamaran">
                    <div>Username</div>
                    <div>Kelas</div>
                    <div>Email</div>
                    <div>Password</div>
                    <div></div>
                </div>
            </div>

            <!-- Table Rows -->
            @foreach ($users as $user)
            <div class="p-4 mb-4 bg-white shadow-md rounded-2xl sm:p-6 lg:p-8 lg:mb-6">
                <!-- Mobile Layout -->
                <div class="space-y-3 lg:hidden">
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-gray-600 font-catamaran">
                            Username:
                        </span>
                        <span class="text-lg font-medium font-catamaran">
                            {{ $user->name }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-gray-600 font-catamaran">
                            Kelas:
                        </span>
                        <span class="text-lg font-medium font-catamaran">
                            {{ $user->kelas ?? '-' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-gray-600 font-catamaran">
                            Email:
                        </span>
                        <span class="text-sm font-medium break-all font-catamaran">
                            {{ $user->email }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-gray-600 font-catamaran">
                            Password:
                        </span>
                        <span class="text-lg font-medium font-catamaran">
                            ••••••••
                        </span>
                    </div>
                    <div class="flex justify-center gap-4 pt-2">
                        <a href="/users/{{ $user->id }}/edit" class="transition-opacity hover:opacity-80" aria-label="Edit user">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-admin-green fill-admin-green">
                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                <path d="m15 5 4 4"/>
                            </svg>
                        </a>
                        <form action="/users/{{ $user->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="transition-opacity hover:opacity-80" aria-label="Delete user">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-admin-red fill-admin-red">
                                    <path d="M3 6h18"/>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Desktop Layout -->
                <div class="items-center hidden grid-cols-5 gap-4 text-4xl text-center lg:grid font-catamaran">
                    <div class="font-medium">{{ $user->name }}</div>
                    <div class="font-medium">{{ $user->kelas ?? '-' }}</div>
                    <div class="font-medium break-all">{{ $user->email }}</div>
                    <div class="font-medium">••••••••</div>
                    <div class="flex justify-center gap-6">
                        <a href="/users/{{ $user->id }}/edit" class="transition-opacity hover:opacity-80" aria-label="Edit user">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-admin-green fill-admin-green">
                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                <path d="m15 5 4 4"/>
                            </svg>
                        </a>
                        <form action="/users/{{ $user->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="transition-opacity hover:opacity-80" aria-label="Delete user">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-admin-red fill-admin-red">
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
                <p class="text-2xl text-gray-500 font-catamaran">Belum ada user terdaftar</p>
            </div>
            @endif
        </main>
    </div>
</body>
</html>