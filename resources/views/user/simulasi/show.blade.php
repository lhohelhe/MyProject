<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $simulasi->judul_simulasi }} - SahabatBuku</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="antialiased font-jakarta" style="background-color: #E5F8FF;">
<div class="flex min-h-screen">

    <x-user-sidebar />

    {{-- konten utama --}}
    <main class="flex-1 min-h-screen px-8 py-6 overflow-y-auto">


        {{-- judul simulasi --}}
        <h1 class="mb-6 text-2xl font-black uppercase tracking-wider text-black border-b-4 border-black pb-2">{{ $simulasi->judul_simulasi }}</h1>

        <div class="max-w-2xl">
            {{-- info card --}}
            <div class="p-6 mb-6 bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl">
                <div class="grid grid-cols-2 gap-6 sm:grid-cols-4">
                    {{-- buku --}}
                    <div>
                        <p class="mb-1 text-xs font-bold text-black uppercase tracking-wider font-jakarta">Buku</p>
                        <p class="text-sm font-black text-black font-jakarta">{{ $simulasi->buku->judul_buku ?? 'Tidak tersedia' }}</p>
                    </div>

                    {{-- durasi --}}
                    <div>
                        <p class="mb-1 text-xs font-bold text-black uppercase tracking-wider font-jakarta">Durasi</p>
                        <p class="text-sm font-black text-black font-jakarta">{{ $simulasi->durasi_menit }} menit</p>
                    </div>

                    {{-- jumlah soal --}}
                    <div>
                        <p class="mb-1 text-xs font-bold text-black uppercase tracking-wider font-jakarta">Jumlah Soal</p>
                        <p class="text-sm font-black text-black font-jakarta">{{ $simulasi->jumlah_soal }} soal</p>
                    </div>

                    {{-- passing grade --}}
                    <div>
                        <p class="mb-1 text-xs font-bold text-black uppercase tracking-wider font-jakarta">Passing Grade</p>
                        <p class="text-sm font-black text-black font-jakarta">70%</p>
                    </div>
                </div>
            </div>

            {{-- riwayat hasil terakhir --}}
            @if($hasilTerakhir)
            <div class="p-6 mb-6 bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl">
                <h2 class="mb-4 text-sm font-black text-black uppercase tracking-wider font-jakarta">Hasil Terakhir</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <p class="mb-1 text-xs font-bold text-black uppercase tracking-wider font-jakarta">Skor</p>
                        <p class="text-2xl font-black text-[#F4922A] font-jakarta">{{ $hasilTerakhir->skor }}%</p>
                    </div>
                    <div>
                        <p class="mb-1 text-xs font-bold text-black uppercase tracking-wider font-jakarta">Status</p>
                        @if($hasilTerakhir->skor >= 70)
                            <span class="inline-block px-3 py-0.5 text-sm font-bold text-white bg-green-500 border-2 border-black rounded-full shadow-[2px_2px_0px_#000] font-jakarta">
                                Lulus
                            </span>
                        @else
                            <span class="inline-block px-3 py-0.5 text-sm font-bold text-white bg-red-500 border-2 border-black rounded-full shadow-[2px_2px_0px_#000] font-jakarta">
                                Tidak Lulus
                            </span>
                        @endif
                    </div>
                    <div>
                        <p class="mb-1 text-xs font-bold text-black uppercase tracking-wider font-jakarta">Tanggal</p>
                        <p class="text-sm font-bold text-black font-jakarta">{{ $hasilTerakhir->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- pesan cooldown atau tombol mulai --}}
            @if($cooldown)
            <div class="p-4 mb-6 border-2 border-black bg-orange-50 shadow-[3px_3px_0px_#000] rounded-xl">
                <p class="text-sm font-bold text-black font-jakarta">
                    ⚠️ Kamu sudah mengerjakan hari ini. Silakan coba lagi besok.
                </p>
            </div>
            <button disabled
                    class="w-full py-3 text-lg font-bold text-slate-400 bg-slate-200 border-2 border-black rounded-xl cursor-not-allowed font-jakarta">
                Mulai Ujian
            </button>
            @else
            <form action="{{ route('user.simulasi.start', $simulasi->id_simulasi) }}" method="POST" class="inline-block w-full">
                @csrf
                <button type="submit"
                        class="w-full py-3 text-lg font-bold text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                    Mulai Ujian
                </button>
            </form>
            @endif
        </div>

    </main>
</div>
<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
</body>
</html>
