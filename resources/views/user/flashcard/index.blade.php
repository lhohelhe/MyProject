<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flashcard - SahabatBuku</title>
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
        <h1 class="mb-6 text-2xl font-black uppercase tracking-wider text-black border-b-4 border-black pb-2">Flashcard — {{ $subbab->judul_subbab }}</h1>

        {{-- progress bar --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-bold text-black font-jakarta">Progres Belajar</span>
                <span class="text-sm font-bold text-black font-jakarta" id="progressText">
                    {{ $sudahDikerjakan }} / {{ $totalFlashcard }} selesai
                </span>
            </div>
            <div class="w-full bg-white border-2 border-black rounded-full h-4 overflow-hidden">
                <div id="progressBar" class="bg-green-500 h-full rounded-full transition-all duration-300" style="width: {{ $progressPercent }}%;"></div>
            </div>
        </div>

        {{-- main content --}}
        <div class="flex flex-col items-center justify-center mb-12">
            {{-- flip card --}}
            <div class="w-full max-w-2xl mb-8">
                <div id="flipCard" class="relative w-full h-64 cursor-pointer" style="perspective: 1000px;">
                    <div class="relative w-full h-full transition-transform duration-500" id="cardInner" style="transform-style: preserve-3d;">
                        
                        {{-- kartu depan (pertanyaan) --}}
                        <div class="absolute w-full h-full p-8 bg-white border-2 border-black rounded-xl shadow-[4px_4px_0px_#000] flex flex-col items-center justify-center" style="backface-visibility: hidden;">
                            <div class="text-center">
                                <p class="text-3xl text-black mb-4 font-jakarta">
                                    <i data-lucide="circle-help" class="w-12 h-12 mx-auto"></i>
                                </p>
                                <p id="frontText" class="text-2xl font-bold text-black font-jakarta"></p>
                            </div>
                            <p class="mt-6 text-xs text-slate-500 font-bold font-jakarta">Klik untuk melihat jawaban</p>
                        </div>

                        {{-- kartu belakang (jawaban) --}}
                        <div class="absolute w-full h-full p-8 bg-[#F4922A] border-2 border-black rounded-xl shadow-[4px_4px_0px_#000] flex flex-col items-center justify-center" style="backface-visibility: hidden; transform: rotateY(180deg);">
                            <div class="text-center">
                                <p class="text-3xl text-white mb-4 font-jakarta">
                                    <i data-lucide="check-circle" class="w-12 h-12 mx-auto"></i>
                                </p>
                                <p id="backText" class="text-2xl font-bold text-white font-jakarta"></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- counter --}}
            <div class="mb-8 text-center">
                <p class="text-lg font-black text-black font-jakarta">
                    Kartu <span id="cardNumber">1</span> dari {{ $totalFlashcard }}
                </p>
            </div>

            {{-- tombol navigasi --}}
            <div class="flex gap-4 mb-8">
                <button onclick="previousCard()" 
                        id="prevBtn"
                        class="px-6 py-2 text-lg font-bold text-black bg-white border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition disabled:opacity-50 disabled:cursor-not-allowed font-jakarta">
                    <i data-lucide="arrow-left" class="w-5 h-5 inline-block mb-1"></i> Sebelumnya
                </button>
                <button onclick="nextCard()" 
                        id="nextBtn"
                        class="px-6 py-2 text-lg font-bold text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition disabled:opacity-50 disabled:cursor-not-allowed font-jakarta">
                    Selanjutnya <i data-lucide="arrow-right" class="w-5 h-5 inline-block mb-1"></i>
                </button>
            </div>

            {{-- tombol sudah paham --}}
            <div class="mb-6">
                <button type="button" 
                        id="sudahPahamBtn"
                        onclick="toggleSudahPaham()"
                        class="px-8 py-3 text-lg font-bold transition-all duration-300 rounded-xl font-jakarta">
                    Belum Paham
                </button>
            </div>

            {{-- tombol reset semua --}}
            <form action="{{ route('user.flashcard.reset', $subbab->id_subbab) }}" method="POST" class="w-full max-w-sm">
                @csrf
                <button type="submit" 
                        class="w-full px-6 py-2 text-lg font-bold text-red-600 bg-white border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                    Reset Semua Progres
                </button>
            </form>
        </div>

    </main>
</div>

<script>
const flashcards = @json($flashcards);
let currentIndex = 0;
let flipped = false;

document.addEventListener('DOMContentLoaded', function() {
    showCard(0);
});

function showCard(index) {
    currentIndex = index;
    const card = flashcards[index];
    
    // Update text
    document.getElementById('frontText').textContent = card.pertanyaan;
    document.getElementById('backText').textContent = card.jawaban;
    document.getElementById('cardNumber').textContent = index + 1;
    
    // Reset flip
    flipped = false;
    document.getElementById('cardInner').style.transform = 'rotateY(0deg)';
    
    // Update button states
    document.getElementById('prevBtn').disabled = index === 0;
    document.getElementById('nextBtn').disabled = index === flashcards.length - 1;
    
    // Update sudah paham button
    updatePahamButtonState(card.user_status === 'sudah');
}

function updatePahamButtonState(isSudah) {
    const btn = document.getElementById('sudahPahamBtn');
    if (isSudah) {
        btn.innerHTML = '<i data-lucide="check" class="w-5 h-5 inline-block mb-1"></i> Sudah Paham';
        btn.className = 'px-8 py-3 text-lg font-bold text-white bg-green-600 border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all font-jakarta';
    } else {
        btn.innerHTML = 'Belum Paham';
        btn.className = 'px-8 py-3 text-lg font-bold text-black bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all font-jakarta';
    }
    if (window.lucide) lucide.createIcons();
}

function flipCard() {
    if (flipped) {
        document.getElementById('cardInner').style.transform = 'rotateY(0deg)';
    } else {
        document.getElementById('cardInner').style.transform = 'rotateY(180deg)';
    }
    flipped = !flipped;
}

function previousCard() {
    if (currentIndex > 0) {
        showCard(currentIndex - 1);
    }
}

function nextCard() {
    if (currentIndex < flashcards.length - 1) {
        showCard(currentIndex + 1);
    }
}

async function toggleSudahPaham() {
    const card = flashcards[currentIndex];
    const url = "{{ route('user.flashcard.done', ':id') }}".replace(':id', card.id_flashcard);
    
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Update local state
            card.user_status = data.status;
            
            // Update UI
            updatePahamButtonState(data.status === 'sudah');
            
            // Update progress bar & text
            document.getElementById('progressBar').style.width = data.progress + '%';
            document.getElementById('progressText').textContent = `${data.sudah_dikerjakan} / ${data.total} selesai`;
            
            // Auto-next after short delay if marked as done
            if (data.status === 'sudah' && currentIndex < flashcards.length - 1) {
                setTimeout(nextCard, 500);
            }
        }
    } catch (error) {
        console.error('Error toggling flashcard status:', error);
    }
}

// Flip card on click
document.getElementById('flipCard').addEventListener('click', flipCard);

if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
</body>
</html>
