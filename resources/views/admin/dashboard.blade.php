@extends('layouts.admin')

@section('title', 'Dashboard Admin - SahabatBuku')

@section('content')
        <h1 class="text-2xl font-black text-black mb-6 font-jakarta uppercase tracking-wider">
            Dashboard Admin
        </h1>

        {{-- flash message --}}
        @if(session('success'))
        <div class="px-4 py-3 mb-6 text-green-800 bg-green-100 rounded-xl font-jakarta">
            {{ session('success') }}
        </div>
        @endif

        {{-- 8 kartu statistik --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">

            {{-- 1. Users (user) --}}
            <div class="bg-white rounded-xl p-5 border-2 border-black shadow-[4px_4px_0px_#000] flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-orange-50 border-2 border-black text-[#F4922A]">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider font-jakarta">Total User</p>
                    <p class="text-2xl font-black text-black font-jakarta">{{ \App\Models\User::count() }}</p>
                </div>
            </div>

            {{-- 2. ShieldCheck (admin) --}}
            <div class="bg-white rounded-xl p-5 border-2 border-black shadow-[4px_4px_0px_#000] flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-orange-50 border-2 border-black text-[#F4922A]">
                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider font-jakarta">Admin</p>
                    <p class="text-2xl font-black text-black font-jakarta">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
                </div>
            </div>

            {{-- 3. BookOpen (mapel) --}}
            <div class="bg-white rounded-xl p-5 border-2 border-black shadow-[4px_4px_0px_#000] flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-orange-50 border-2 border-black text-[#F4922A]">
                    <i data-lucide="bookmark" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider font-jakarta">Mapel</p>
                    <p class="text-2xl font-black text-black font-jakarta">{{ $total_kategori }}</p>
                </div>
            </div>

            {{-- 4. Book (buku) --}}
            <div class="bg-white rounded-xl p-5 border-2 border-black shadow-[4px_4px_0px_#000] flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-orange-50 border-2 border-black text-[#F4922A]">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider font-jakarta">Buku</p>
                    <p class="text-2xl font-black text-black font-jakarta">{{ $total_buku }}</p>
                </div>
            </div>

            {{-- 5. Layers (bab) --}}
            <div class="bg-white rounded-xl p-5 border-2 border-black shadow-[4px_4px_0px_#000] flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-orange-50 border-2 border-black text-[#F4922A]">
                    <i data-lucide="layers" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider font-jakarta">Bab</p>
                    <p class="text-2xl font-black text-black font-jakarta">{{ $total_bab }}</p>
                </div>
            </div>

            {{-- 6. BookMarked (subbab) --}}
            <div class="bg-white rounded-xl p-5 border-2 border-black shadow-[4px_4px_0px_#000] flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-orange-50 border-2 border-black text-[#F4922A]">
                    <i data-lucide="book-marked" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider font-jakarta">Subbab</p>
                    <p class="text-2xl font-black text-black font-jakarta">{{ \App\Models\Subab::count() }}</p>
                </div>
            </div>

            {{-- 7. FileText (materi) --}}
            <div class="bg-white rounded-xl p-5 border-2 border-black shadow-[4px_4px_0px_#000] flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-orange-50 border-2 border-black text-[#F4922A]">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider font-jakarta">Materi</p>
                    <p class="text-2xl font-black text-black font-jakarta">{{ \App\Models\Materi::count() }}</p>
                </div>
            </div>

            {{-- 8. ClipboardList (quiz) --}}
            <div class="bg-white rounded-xl p-5 border-2 border-black shadow-[4px_4px_0px_#000] flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-orange-50 border-2 border-black text-[#F4922A]">
                    <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider font-jakarta">Quiz</p>
                    <p class="text-2xl font-black text-black font-jakarta">{{ \App\Models\Quiz::count() }}</p>
                </div>
            </div>

        </div>

        {{-- buku terbaru --}}
        <div class="p-6 bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-black text-black uppercase tracking-wider font-jakarta">Buku Terbaru Ditambahkan</h2>
                <a href="{{ route('dashboard-buku.index') }}"
                   class="flex items-center gap-1 text-xs font-black text-slate-400 font-jakarta hover:text-[#F4922A] transition-colors uppercase tracking-wider">
                    Lihat lainnya <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            @forelse($buku_terbaru as $buku)
            <div class="flex items-center gap-4 py-3 border-b-2 border-black last:border-b-0">

                {{-- cover buku --}}
                @if($buku->gambar)
                    <img src="{{ asset('storage/' . $buku->gambar) }}"
                         class="object-cover w-12 h-16 rounded-lg border-2 border-black"
                         alt="{{ $buku->judul_buku }}">
                @else
                    <div class="flex items-center justify-center w-12 h-16 bg-slate-100 border-2 border-black rounded-lg">
                        <i data-lucide="book-open" class="w-5 h-5 text-slate-400"></i>
                    </div>
                @endif

                {{-- info buku --}}
                <div class="flex-1">
                    <p class="font-black text-black text-sm font-jakarta">{{ $buku->judul_buku }}</p>
                    <p class="text-xs font-bold text-slate-500 font-jakarta mt-0.5">
                        {{ $buku->kategori->nama_kategori ?? '-' }} · Kelas {{ $buku->kelas }} · Semester {{ $buku->semester }}
                    </p>
                </div>

            </div>
            @empty
            <p class="text-slate-400 font-bold text-sm font-jakarta">Belum ada buku yang ditambahkan.</p>
            @endforelse
        </div>
@endsection