<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flashcard - SahabatBuku</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .card-flip { perspective: 1200px; }
        .card-inner {
            transform-style: preserve-3d;
            transition: transform 0.45s cubic-bezier(.4,0,.2,1);
            position: relative;
            width: 100%;
            height: 100%;
        }
        .card-inner.flipped { transform: rotateY(180deg); }
        .card-face {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }
        .card-back-face { transform: rotateY(180deg); }
    </style>
</head>
<body class="antialiased font-jakarta bg-[#E5F8FF]">
<div class="flex h-screen overflow-hidden">

    <x-user-sidebar />

    <main class="flex-1 flex flex-col h-screen overflow-hidden">

        {{-- Top bar --}}
        <div class="flex-shrink-0 flex items-center justify-between px-8 py-4 bg-white border-b-2 border-black">
            <div>
                <a href="{{ route('user.buku.show', $subbab->bab->id_buku) }}"
                   class="inline-flex items-center gap-1.5 text-xs font-black text-slate-400 hover:text-[#F4922A] uppercase tracking-widest mb-1 transition">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali
                </a>
                <h1 class="text-lg font-black text-black uppercase tracking-wider leading-tight">
                    {{ $subbab->judul_subbab }}
                </h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">
                    {{ $subbab->bab->judul_bab ?? '' }}
                </p>
            </div>
            <span class="text-xs font-black text-slate-400 uppercase tracking-widest" id="cardCounter">
                Kartu 1 dari {{ $totalFlashcard }}
            </span>
        </div>

        {{-- ===== CARD AREA ===== --}}
        <div id="cardArea" class="flex-1 flex flex-col items-center justify-center px-8 py-6 overflow-hidden">

            {{-- Flip card — ukuran besar memenuhi ruang --}}
            <div class="card-flip w-full max-w-3xl mb-6" style="height: 340px;">
                <div class="card-inner" id="cardInner">

                    {{-- Depan: pertanyaan --}}
                    <div class="card-face bg-white border-2 border-black shadow-[6px_6px_0px_#000] rounded-2xl flex flex-col items-center justify-center p-10 cursor-pointer"
                         onclick="flipCard()">
                        <i data-lucide="help-circle" class="w-10 h-10 text-slate-200 mb-5 flex-shrink-0"></i>
                        <p id="frontText" class="text-2xl font-black text-black text-center leading-snug max-w-lg"></p>
                        <p class="mt-6 text-[10px] font-black text-slate-300 uppercase tracking-widest">Klik kartu untuk lihat jawaban</p>
                    </div>

                    {{-- Belakang: jawaban --}}
                    <div class="card-back-face card-face bg-[#1E3A5F] border-2 border-black shadow-[6px_6px_0px_#000] rounded-2xl flex flex-col items-center justify-center p-10 cursor-pointer"
                         onclick="flipCard()">
                        <i data-lucide="check-circle" class="w-10 h-10 text-[#F4922A] mb-5 flex-shrink-0"></i>
                        <p id="backText" class="text-2xl font-black text-white text-center leading-snug max-w-lg"></p>
                        <p class="mt-6 text-[10px] font-black text-white/30 uppercase tracking-widest">Klik untuk balik kembali</p>
                    </div>

                </div>
            </div>

            {{-- Tombol Paham / Ulangi — muncul hanya setelah dibalik --}}
            <div id="actionButtons" class="hidden w-full max-w-3xl grid grid-cols-2 gap-4 mb-4">
                <button onclick="markAndNext('belum')"
                        class="py-4 text-sm font-black text-black bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all flex items-center justify-center gap-2">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    Ulangi Nanti
                </button>
                <button onclick="markAndNext('sudah')"
                        class="py-4 text-sm font-black text-white bg-[#F4922A] border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all flex items-center justify-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    Sudah Paham
                </button>
            </div>

            {{-- Navigasi lewati --}}
            <div class="w-full max-w-3xl flex gap-3">
                <button onclick="prevCard()" id="prevBtn"
                        class="flex-1 py-3 text-sm font-bold text-black bg-white border-2 border-black rounded-xl shadow-[2px_2px_0px_#000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all disabled:opacity-30 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Sebelumnya
                </button>
                <button onclick="nextCard()" id="nextBtn"
                        class="flex-1 py-3 text-sm font-bold text-black bg-white border-2 border-black rounded-xl shadow-[2px_2px_0px_#000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all disabled:opacity-30 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    Lewati <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </div>

        </div>

        {{-- ===== LAYAR SELESAI ===== --}}
        <div id="doneScreen" class="hidden flex-1 flex flex-col items-center justify-center px-8 py-6">

            <div class="w-full max-w-lg bg-white border-2 border-black shadow-[6px_6px_0px_#000] rounded-2xl p-10 text-center mb-5">

                {{-- Icon hasil --}}
                <div class="w-16 h-16 rounded-2xl border-2 border-black bg-[#F4922A] flex items-center justify-center mx-auto mb-5 shadow-[3px_3px_0px_#000]">
                    <i data-lucide="award" class="w-8 h-8 text-white"></i>
                </div>

                <h2 class="text-2xl font-black text-black mb-2 uppercase tracking-wider">Sesi Selesai</h2>
                <p class="text-sm font-bold text-slate-500 mb-8 leading-relaxed" id="doneMessage"></p>

                <div class="space-y-3" id="doneActions"></div>
            </div>

            <form action="{{ route('user.flashcard.reset', $subbab->id_subbab) }}" method="POST">
                @csrf
                <button type="submit"
                        class="text-xs font-black text-slate-400 hover:text-red-500 uppercase tracking-widest transition flex items-center gap-1.5">
                    <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i> Reset semua &amp; mulai ulang
                </button>
            </form>

        </div>

    </main>
</div>

<script>
const FLASHCARDS = @json($flashcards);
const CSRF       = '{{ csrf_token() }}';
const ROUTE_DONE = "{{ route('user.flashcard.done', ':id') }}";
const BACK_URL   = "{{ route('user.buku.show', $subbab->bab->id_buku) }}";

let currentIndex = 0;
let isFlipped    = false;
const sesiPilihan = {};

function showCard(index) {
    currentIndex = index;
    isFlipped    = false;

    const card = FLASHCARDS[index];
    document.getElementById('frontText').textContent  = card.pertanyaan;
    document.getElementById('backText').textContent   = card.jawaban;
    document.getElementById('cardCounter').textContent = `Kartu ${index + 1} dari ${FLASHCARDS.length}`;

    document.getElementById('cardInner').classList.remove('flipped');

    const ab = document.getElementById('actionButtons');
    ab.classList.add('hidden');
    ab.classList.remove('grid');

    document.getElementById('prevBtn').disabled = index === 0;
    document.getElementById('nextBtn').disabled = index === FLASHCARDS.length - 1;

    if (window.lucide) lucide.createIcons();
}

function flipCard() {
    isFlipped = !isFlipped;
    document.getElementById('cardInner').classList.toggle('flipped', isFlipped);

    const ab = document.getElementById('actionButtons');
    if (isFlipped) {
        ab.classList.remove('hidden');
        ab.classList.add('grid');
    } else {
        ab.classList.add('hidden');
        ab.classList.remove('grid');
    }
    if (window.lucide) lucide.createIcons();
}

async function markAndNext(status) {
    const card = FLASHCARDS[currentIndex];
    sesiPilihan[card.id_flashcard] = status;

    const url = ROUTE_DONE.replace(':id', card.id_flashcard);
    try {
        await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
    } catch(e) {}

    if (currentIndex < FLASHCARDS.length - 1) {
        showCard(currentIndex + 1);
    } else {
        showDoneScreen();
    }
}

function prevCard() { if (currentIndex > 0) showCard(currentIndex - 1); }
function nextCard() { if (currentIndex < FLASHCARDS.length - 1) showCard(currentIndex + 1); }

function showDoneScreen() {
    document.getElementById('cardArea').classList.add('hidden');
    document.getElementById('doneScreen').classList.remove('hidden');
    document.getElementById('doneScreen').classList.add('flex');

    const sudahCount = Object.values(sesiPilihan).filter(v => v === 'sudah').length;
    const belumCount = Object.values(sesiPilihan).filter(v => v === 'belum').length;

    let msg = sudahCount === FLASHCARDS.length
        ? `Seluruh ${FLASHCARDS.length} flashcard berhasil kamu kuasai dalam sesi ini.`
        : `${sudahCount} dari ${FLASHCARDS.length} flashcard sudah kamu pahami.` +
          (belumCount > 0 ? ` ${belumCount} kartu masih perlu diulang.` : '');

    document.getElementById('doneMessage').textContent = msg;

    const actEl = document.getElementById('doneActions');
    actEl.innerHTML = '';

    if (belumCount > 0) {
        const btn = document.createElement('button');
        btn.className = 'w-full py-4 text-sm font-black text-white bg-[#F4922A] border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all flex items-center justify-center gap-2';
        btn.innerHTML = `<span>Ulangi ${belumCount} Kartu yang Belum Paham</span>`;
        btn.onclick = startRepeat;
        actEl.appendChild(btn);
    }

    const backBtn = document.createElement('a');
    backBtn.href      = BACK_URL;
    backBtn.className = 'block w-full py-4 text-sm font-black text-black bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all text-center';
    backBtn.textContent = 'Kembali ke Buku';
    actEl.appendChild(backBtn);

    if (window.lucide) lucide.createIcons();
}

function startRepeat() {
    const belumIds = Object.entries(sesiPilihan)
        .filter(([,v]) => v === 'belum')
        .map(([id]) => parseInt(id));

    belumIds.forEach(id => delete sesiPilihan[id]);

    const repeatCards = FLASHCARDS.filter(fc => belumIds.includes(fc.id_flashcard));
    FLASHCARDS.length = 0;
    repeatCards.forEach(fc => FLASHCARDS.push(fc));

    document.getElementById('doneScreen').classList.add('hidden');
    document.getElementById('doneScreen').classList.remove('flex');
    document.getElementById('cardArea').classList.remove('hidden');

    showCard(0);
}

document.addEventListener('DOMContentLoaded', () => {
    showCard(0);
    if (window.lucide) lucide.createIcons();
});
</script>
</body>
</html>
