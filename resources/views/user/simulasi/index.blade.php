<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulasi Ujian - SahabatBuku</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="antialiased font-jakarta" style="background-color: #E5F8FF;">
<div class="flex min-h-screen">

    <x-user-sidebar />

    {{-- konten utama --}}
    <main class="flex-1 px-8 py-6 overflow-y-auto">

        {{-- judul halaman --}}
        <h1 class="mb-6 text-2xl font-black uppercase tracking-wider text-black border-b-4 border-black pb-2">Simulasi Ujian</h1>

        {{-- grid simulasi --}}
        @if($simulasi->isEmpty())
            <p class="italic text-gray-400 font-jakarta">belum ada simulasi tersedia.</p>
        @else
            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
                @foreach($simulasi as $sim)
                <div class="flex flex-col bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl overflow-hidden hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all">

                    {{-- header card dengan badge status --}}
                    <div class="relative px-4 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b-2 border-black">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <h3 class="flex-1 text-sm font-black text-black line-clamp-2 font-jakarta">
                                {{ $sim->judul_simulasi }}
                            </h3>
                            @if(in_array($sim->id_simulasi, $cooldowns))
                                <span class="px-2.5 py-0.5 text-xs font-bold text-white border-2 border-black rounded-full bg-slate-400 whitespace-nowrap shadow-[2px_2px_0px_#000]">
                                    Cooldown
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 text-xs font-bold text-white border-2 border-black rounded-full bg-[#F4922A] whitespace-nowrap shadow-[2px_2px_0px_#000]">
                                    Aktif
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-black font-bold font-jakarta">
                            {{ $sim->buku->judul_buku ?? 'Buku tidak tersedia' }}
                        </p>
                    </div>

                    {{-- info simulasi --}}
                    <div class="flex-1 px-4 py-4 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-black font-bold font-jakarta">Durasi</span>
                            <span class="text-sm font-black text-black font-jakarta">{{ $sim->durasi_menit }} mnt</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-black font-bold font-jakarta">Soal</span>
                            <span class="text-sm font-black text-black font-jakarta">{{ $sim->jumlah_soal }} soal</span>
                        </div>

                        @if(in_array($sim->id_simulasi, $cooldowns))
                        <div class="p-2 text-center bg-slate-100 border-2 border-black rounded-lg">
                            <p class="text-xs font-bold text-black font-jakarta">Cooldown • Besok</p>
                        </div>
                        @endif
                    </div>

                    {{-- tombol aksi --}}
                    <div class="px-4 py-3 border-t-2 border-black bg-slate-50">
                        @if(in_array($sim->id_simulasi, $cooldowns))
                            <button disabled
                                    class="w-full py-2 text-sm font-bold text-slate-400 bg-slate-200 border-2 border-black rounded-xl cursor-not-allowed font-jakarta">
                                Mulai
                            </button>
                        @else
                            <a href="{{ route('user.simulasi.show', $sim->id_simulasi) }}"
                               class="block w-full py-2 text-sm font-bold text-center text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                                Mulai
                            </a>
                        @endif
                    </div>

                </div>
                @endforeach
            </div>
        @endif

    </main>
</div>
<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
</body>
</html>
