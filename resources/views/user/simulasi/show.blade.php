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
        <h1 class="mb-8 text-xl font-bold text-slate-800">{{ $simulasi->judul_simulasi }}</h1>

        <div class="max-w-2xl">
            {{-- info card --}}
            <div class="p-6 mb-8 bg-white rounded-2xl shadow-sm border border-slate-100">
                <div class="grid grid-cols-2 gap-6 sm:grid-cols-4">
                    {{-- buku --}}
                    <div>
                        <p class="mb-2 text-xs font-semibold text-gray-600 font-jakarta">Buku</p>
                        <p class="text-sm font-bold text-gray-800 font-jakarta">{{ $simulasi->buku->judul_buku ?? 'Tidak tersedia' }}</p>
                    </div>

                    {{-- durasi --}}
                    <div>
                        <p class="mb-2 text-xs font-semibold text-gray-600 font-jakarta">Durasi</p>
                        <p class="text-sm font-bold text-gray-800 font-jakarta">{{ $simulasi->durasi_menit }} menit</p>
                    </div>

                    {{-- jumlah soal --}}
                    <div>
                        <p class="mb-2 text-xs font-semibold text-gray-600 font-jakarta">Jumlah Soal</p>
                        <p class="text-sm font-bold text-gray-800 font-jakarta">{{ $simulasi->jumlah_soal }} soal</p>
                    </div>

                    {{-- passing grade --}}
                    <div>
                        <p class="mb-2 text-xs font-semibold text-gray-600 font-jakarta">Passing Grade</p>
                        <p class="text-sm font-bold text-gray-800 font-jakarta">70%</p>
                    </div>
                </div>
            </div>

            {{-- riwayat hasil terakhir --}}
            @if($hasilTerakhir)
            <div class="p-6 mb-8 bg-white rounded-2xl shadow-sm border border-slate-100">
                <h2 class="mb-4 text-lg font-bold text-slate-800 font-jakarta">Hasil Terakhir</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <p class="mb-1 text-xs font-semibold text-gray-600 font-jakarta">Skor</p>
                        <p class="text-2xl font-bold text-[#F4922A] font-jakarta">{{ $hasilTerakhir->skor }}%</p>
                    </div>
                    <div>
                        <p class="mb-1 text-xs font-semibold text-gray-600 font-jakarta">Status</p>
                        @if($hasilTerakhir->skor >= 70)
                            <span class="inline-block px-3 py-1 text-sm font-bold text-white bg-green-500 rounded-full font-jakarta">
                                Lulus
                            </span>
                        @else
                            <span class="inline-block px-3 py-1 text-sm font-bold text-white bg-red-500 rounded-full font-jakarta">
                                Tidak Lulus
                            </span>
                        @endif
                    </div>
                    <div>
                        <p class="mb-1 text-xs font-semibold text-gray-600 font-jakarta">Tanggal</p>
                        <p class="text-sm text-gray-800 font-jakarta">{{ $hasilTerakhir->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- pesan cooldown atau tombol mulai --}}
            @if($cooldown)
            <div class="p-6 mb-6 border-l-4 border-orange-400 bg-orange-50 rounded-2xl shadow-sm">
                <p class="text-sm font-semibold text-orange-800 font-jakarta">
                    Kamu sudah mengerjakan hari ini. Silakan coba lagi besok.
                </p>
            </div>
            <button disabled 
                    class="w-full py-3 text-lg font-bold text-gray-400 bg-gray-300 rounded-xl cursor-not-allowed font-jakarta">
                Mulai Ujian
            </button>
            @else
            <form action="{{ route('user.simulasi.start', $simulasi->id_simulasi) }}" method="POST" class="inline-block w-full">
                @csrf
                <button type="submit" 
                        class="w-full py-3 text-lg font-bold text-white bg-[#F4922A] rounded-xl hover:bg-opacity-90 transition font-jakarta">
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
