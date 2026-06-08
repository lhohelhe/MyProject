@extends('layouts.admin')

@section('title', 'Data User - SahabatBuku')

@section('content')
<div class="max-w-5xl mx-auto">

    <h1 class="mb-6 text-2xl font-black text-black uppercase tracking-wider font-jakarta">
        Data User
    </h1>

    {{-- Header bar --}}
    <div class="flex items-center justify-between p-4 mb-6 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl">
        <p class="text-sm font-black text-black font-jakarta uppercase tracking-wider">
            Total: <span class="text-[#F4922A]">{{ $users->total() }}</span> pengguna
        </p>
        <a href="{{ route('dashboard-user.create') }}"
           class="flex items-center gap-2 px-4 py-2.5 text-sm font-black text-white bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all font-jakarta">
            + Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
    <div class="px-4 py-3 mb-4 text-green-800 bg-green-100 border-2 border-green-400 rounded-xl font-jakarta text-sm font-bold">
        ✓ {{ session('success') }}
    </div>
    @endif

    {{-- Header tabel desktop --}}
    <div class="hidden p-4 mb-3 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl lg:grid grid-cols-12 gap-4 text-xs font-black text-black uppercase tracking-wider text-center font-jakarta">
        <div class="col-span-1">Foto</div>
        <div class="col-span-2 text-left">Nama</div>
        <div class="col-span-1">Kelas</div>
        <div class="col-span-3 text-left">Email</div>
        <div class="col-span-1">Role</div>
        <div class="col-span-1">XP</div>
        <div class="col-span-1">Level</div>
        <div class="col-span-2">Aksi</div>
    </div>

    {{-- List --}}
    @forelse($users as $user)
    <div class="p-4 mb-3 bg-white border-2 border-black rounded-xl font-jakarta">

        {{-- Desktop --}}
        <div class="hidden lg:grid grid-cols-12 gap-4 items-center text-center">
            {{-- Foto --}}
            <div class="col-span-1 flex justify-center">
                @if($user->foto)
                    <img src="{{ asset('storage/' . $user->foto) }}"
                         class="w-10 h-10 rounded-full object-cover border-2 border-black">
                @else
                    <div class="w-10 h-10 rounded-full bg-slate-100 border-2 border-black flex items-center justify-center text-slate-400 text-sm font-black">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            {{-- Nama --}}
            <div class="col-span-2 font-black text-black text-left text-sm truncate">{{ $user->name }}</div>
            {{-- Kelas --}}
            <div class="col-span-1 font-bold text-black text-sm">{{ $user->kelas ?? '-' }}</div>
            {{-- Email --}}
            <div class="col-span-3 font-bold text-slate-600 text-xs text-left truncate">{{ $user->email }}</div>
            {{-- Role --}}
            <div class="col-span-1">
                <span class="px-2.5 py-1 text-[10px] font-black text-white border-2 border-black rounded-full
                    {{ $user->role === 'admin' ? 'bg-[#1E3A5F]' : 'bg-[#F4922A]' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
            {{-- XP --}}
            <div class="col-span-1 font-black text-[#F4922A] text-sm">{{ number_format($user->total_xp ?? 0) }}</div>
            {{-- Level --}}
            <div class="col-span-1">
                <span class="w-7 h-7 inline-flex items-center justify-center bg-[#1E3A5F] text-white font-black text-xs border-2 border-black rounded-lg">
                    {{ $user->level ?? 1 }}
                </span>
            </div>
            {{-- Aksi --}}
            <div class="col-span-2 flex justify-center gap-2">
                <a href="{{ route('dashboard-user.edit', $user->id) }}"
                   class="px-3 py-2 text-xs font-black text-black bg-white border-2 border-black shadow-[2px_2px_0px_#000] rounded-lg hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                    Edit
                </a>
                <form action="{{ route('dashboard-user.destroy', $user->id) }}" method="POST"
                      onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-3 py-2 text-xs font-black text-white bg-red-500 border-2 border-black shadow-[2px_2px_0px_#000] rounded-lg hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        {{-- Mobile --}}
        <div class="lg:hidden space-y-3">
            <div class="flex items-center gap-3">
                @if($user->foto)
                    <img src="{{ asset('storage/' . $user->foto) }}"
                         class="w-12 h-12 rounded-full object-cover border-2 border-black flex-shrink-0">
                @else
                    <div class="w-12 h-12 rounded-full bg-slate-100 border-2 border-black flex items-center justify-center text-slate-500 font-black flex-shrink-0">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <p class="font-black text-black text-sm">{{ $user->name }}</p>
                    <p class="text-xs font-bold text-slate-500">{{ $user->email }}</p>
                </div>
                <span class="ml-auto px-2.5 py-1 text-[10px] font-black text-white border-2 border-black rounded-full {{ $user->role === 'admin' ? 'bg-[#1E3A5F]' : 'bg-[#F4922A]' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
            <div class="flex items-center gap-4 text-xs font-bold text-slate-500 pl-1">
                <span>Kelas {{ $user->kelas ?? '-' }}</span>
                <span>·</span>
                <span class="text-[#F4922A] font-black">{{ number_format($user->total_xp ?? 0) }} XP</span>
                <span>·</span>
                <span>Level {{ $user->level ?? 1 }}</span>
            </div>
            <div class="flex gap-2 pt-2 border-t-2 border-black">
                <a href="{{ route('dashboard-user.edit', $user->id) }}"
                   class="flex-1 py-2 text-xs font-black text-center text-black bg-white border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                    Edit
                </a>
                <form action="{{ route('dashboard-user.destroy', $user->id) }}" method="POST"
                      onsubmit="return confirm('Hapus user {{ $user->name }}?')" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full py-2 text-xs font-black text-white bg-red-500 border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

    </div>
    @empty
    <div class="p-10 text-center bg-white border-2 border-black rounded-xl">
        <p class="font-bold text-slate-400">Belum ada user terdaftar</p>
    </div>
    @endforelse

    {{-- Pagination --}}
    @if($users->hasPages())
    <div class="mt-6">{{ $users->links() }}</div>
    @endif

</div>
@endsection
