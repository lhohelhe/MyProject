@extends('layouts.admin')

@section('title', 'Kelola Saran - SahabatBuku')

@section('content')
<div class="max-w-5xl mx-auto">

    <h1 class="mb-6 text-2xl font-black text-black uppercase tracking-wider font-jakarta">
        Kelola Saran
    </h1>

    @if(session('success'))
    <div class="px-4 py-3 mb-4 text-green-800 bg-green-100 border-2 border-green-400 rounded-xl font-jakarta text-sm font-bold">
        ✓ {{ session('success') }}
    </div>
    @endif

    {{-- Stat bar --}}
    <div class="flex items-center justify-between p-4 mb-6 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl font-jakarta">
        <p class="text-sm font-black text-black uppercase tracking-wider">
            Belum Dibaca: <span class="text-[#F4922A]">{{ $sarans->total() }}</span>
        </p>
    </div>

    {{-- Header tabel --}}
    <div class="hidden p-4 mb-3 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl lg:block">
        <div class="grid grid-cols-8 gap-4 text-sm font-black text-black uppercase tracking-wider text-center font-jakarta">
            <div>No</div>
            <div class="col-span-3 text-left">Saran</div>
            <div class="col-span-2">Tanggal</div>
            <div>Status</div>
            <div>Aksi</div>
        </div>
    </div>

    @forelse($sarans as $index => $saran)
    <div class="p-4 mb-3 bg-white border-2 border-black rounded-xl font-jakarta">

        {{-- Desktop --}}
        <div class="items-center hidden grid-cols-8 gap-4 text-center lg:grid">
            <div class="font-black text-black">{{ $sarans->firstItem() + $index }}</div>
            <div class="col-span-3 text-left font-bold text-black text-sm leading-relaxed break-words whitespace-pre-line pr-4">
                {{ $saran->isi }}
            </div>
            <div class="col-span-2 font-bold text-slate-500 text-xs">
                {{ $saran->created_at->format('d M Y H:i') }}
            </div>
            <div>
                <span class="px-2.5 py-1 text-white text-[10px] font-black uppercase tracking-wider border-2 border-black rounded-full
                    {{ $saran->status === 'belum_dibaca' ? 'bg-[#F4922A]' : 'bg-green-500' }}">
                    {{ $saran->status === 'belum_dibaca' ? 'Belum Dibaca' : 'Sudah Dibaca' }}
                </span>
            </div>
            <div class="flex justify-center items-center gap-2">
                @if($saran->status === 'belum_dibaca')
                <form action="{{ route('admin.saran.read', $saran->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="px-2.5 py-1.5 text-xs font-black text-white bg-[#1E3A5F] border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        ✓
                    </button>
                </form>
                @endif
                <form action="{{ route('admin.saran.destroy', $saran->id) }}" method="POST"
                      onsubmit="return confirm('Hapus saran ini?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-2.5 py-1.5 text-xs font-black text-white bg-red-500 border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        {{-- Mobile --}}
        <div class="space-y-2 lg:hidden">
            <p class="text-sm font-bold text-black leading-relaxed">{{ $saran->isi }}</p>
            <p class="text-xs font-bold text-slate-400">{{ $saran->created_at->format('d M Y H:i') }}</p>
            <div class="flex items-center gap-2 pt-2">
                @if($saran->status === 'belum_dibaca')
                <form action="{{ route('admin.saran.read', $saran->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="px-3 py-1.5 text-xs font-black text-white bg-[#1E3A5F] border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Tandai Dibaca
                    </button>
                </form>
                @endif
                <form action="{{ route('admin.saran.destroy', $saran->id) }}" method="POST"
                      onsubmit="return confirm('Hapus saran ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1.5 text-xs font-black text-white bg-red-500 border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

    </div>
    @empty
    <div class="p-8 text-center bg-white border-2 border-black rounded-xl">
        <p class="font-bold text-slate-400">Belum ada saran.</p>
    </div>
    @endforelse

    @if($sarans->hasPages())
    <div class="mt-6">{{ $sarans->links() }}</div>
    @endif

</div>
@endsection
