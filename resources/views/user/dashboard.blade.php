@extends('layouts.user')

@section('content')
<div class="flex flex-col min-h-screen lg:flex-row">

    <!-- Sidebar -->
    <aside class="w-full lg:w-52 bg-[#2C3E50] flex-shrink-0">
        <div class="p-6">
            <div class="flex items-center gap-2 mb-10">
                <h1 class="text-2xl font-bold text-white">SahabatBuku</h1>
            </div>

            <nav class="text-lg text-white">
                Data User
            </nav>
        </div>
    </aside>

    <!-- Main -->
    <main class="flex-1 p-6 lg:p-16">
        <h1 class="mb-12 text-4xl font-extrabold lg:text-6xl">
            Dashboard User
        </h1>

        <!-- Total User -->
        <div class="flex items-center justify-between p-8 mb-8 bg-white shadow-md rounded-2xl">
            <div class="text-3xl font-semibold">
                Total User: {{ $users->count() }}
            </div>
        </div>

        <!-- Table Header (Desktop) -->
        <div class="hidden p-8 mb-6 bg-white shadow-md lg:block rounded-2xl">
            <div class="grid grid-cols-4 gap-4 text-2xl font-medium text-center">
                <div>Username</div>
                <div>Kelas</div>
                <div>Email</div>
                <div>Aksi</div>
            </div>
        </div>

        <!-- Rows -->
        @foreach ($users as $user)
            <div class="p-6 mb-4 bg-white shadow-md rounded-2xl">
                <div class="grid grid-cols-1 gap-4 text-xl text-center lg:grid-cols-4">
                    <div>{{ $user->name }}</div>
                    <div>{{ $user->kelas }}</div>
                    <div class="break-all">{{ $user->email }}</div>
                    <div class="flex justify-center gap-4">
                        <a href="#" class="text-green-600">Edit</a>
                        <form method="POST" action="#">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    </main>
</div>
@endsection
