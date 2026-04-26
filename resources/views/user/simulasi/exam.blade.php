<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $simulasi->judul_simulasi }} - Ujian - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="antialiased font-jakarta bg-gray-50">
<div class="flex flex-col min-h-screen">

    {{-- header --}}
    <div class="flex items-center justify-between p-6 bg-white border-b border-gray-200 shadow-sm">
        <h1 class="text-2xl font-bold text-gray-800 font-jakarta">{{ $simulasi->judul_simulasi }}</h1>
        
        {{-- timer --}}
        <div class="font-mono text-3xl font-bold" id="timer" style="color: #333;">
            {{ floor($durasi / 3600) }}:{{ str_pad(floor(($durasi % 3600) / 60), 2, '0', STR_PAD_LEFT) }}:{{ str_pad($durasi % 60, 2, '0', STR_PAD_LEFT) }}
        </div>
    </div>

    <div class="flex flex-1 overflow-hidden">
        {{-- sidebar navigasi soal --}}
        <div class="w-24 px-2 py-6 overflow-y-auto bg-white border-r border-gray-200 sm:w-32">
            <div class="grid grid-cols-3 gap-2 sm:grid-cols-2">
                @foreach($soal as $index => $s)
                <button onclick="goToQuestion({{ $index }})" 
                        id="nav-{{ $index }}"
                        class="p-2 text-xs font-bold text-center text-gray-700 transition-colors bg-gray-300 rounded hover:bg-gray-400"
                        data-question="{{ $index }}">
                    {{ $index + 1 }}
                </button>
                @endforeach
            </div>
        </div>

        {{-- main content --}}
        <main class="flex-1 p-6 overflow-y-auto sm:p-8">
            <div class="max-w-3xl">
                <form id="examForm" action="{{ route('user.simulasi.submit') }}" method="POST" class="space-y-8">
                    @csrf

                    {{-- soal container --}}
                    @foreach($soal as $index => $s)
                    <div id="question-{{ $index }}" class="hidden question-container">
                        {{-- nomor soal --}}
                        <div class="mb-4">
                            <span class="text-sm font-semibold text-gray-600 font-jakarta">Soal {{ $index + 1 }} dari {{ $soal->count() }}</span>
                        </div>

                        {{-- pertanyaan --}}
                        <div class="mb-6 p-4 bg-white rounded-[12px] shadow-sm">
                            <p class="text-lg font-semibold text-gray-800 font-jakarta">{{ $s->pertanyaan }}</p>
                        </div>

                        {{-- pilihan jawaban --}}
                        <div class="space-y-3 p-4 bg-white rounded-[12px] shadow-sm">
                            @foreach(['a', 'b', 'c', 'd'] as $option)
                            <label class="flex items-start p-3 transition border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50" onclick="markAnswered({{ $index }})">
                                <input type="radio" 
                                       name="jawaban[{{ $s->id_soal_simulasi }}]" 
                                       value="{{ $option }}"
                                       class="mt-1"
                                       data-question="{{ $index }}">
                                <span class="ml-3 font-bold text-gray-700 font-jakarta">{{ strtoupper($option) }}.</span>
                                <span class="ml-2 text-gray-700 font-jakarta">
                                    @php
                                        $columnName = 'opsi_' . $option;
                                        echo $s->$columnName;
                                    @endphp
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                    {{-- tombol navigasi --}}
                    <div class="flex justify-between gap-4 pt-6">
                        <button type="button" 
                                id="prevBtn"
                                onclick="previousQuestion()"
                                class="flex-1 py-3 text-lg font-bold text-[#F0924E] border-2 border-[#F0924E] rounded-[12px] hover:bg-orange-50 transition font-jakarta">
                            Sebelumnya
                        </button>
                        <button type="button" 
                                id="nextBtn"
                                onclick="nextQuestion()"
                                class="flex-1 py-3 text-lg font-bold text-white bg-[#F0924E] rounded-[12px] hover:bg-opacity-90 transition font-jakarta">
                            Selanjutnya
                        </button>
                    </div>

                    {{-- tombol submit --}}
                    <div class="pt-4">
                        <button type="button" 
                                onclick="showConfirmModal()"
                                class="w-full py-3 text-lg font-bold text-white bg-green-600 rounded-[12px] hover:bg-green-700 transition font-jakarta">
                            Submit Ujian
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

{{-- modal konfirmasi submit --}}
<div id="confirmModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-[12px] p-6 max-w-sm shadow-xl">
        <h2 class="mb-4 text-xl font-bold text-gray-800 font-jakarta">Konfirmasi Submit</h2>
        <p class="mb-6 text-gray-700 font-jakarta">Apakah Anda yakin ingin mengirimkan jawaban? Anda tidak dapat mengubahnya lagi.</p>
        <div class="flex gap-4">
            <button type="button" 
                    onclick="closeConfirmModal()"
                    class="flex-1 py-2 text-lg font-bold text-gray-700 border-2 border-gray-300 rounded-[12px] hover:bg-gray-50 transition font-jakarta">
                Batal
            </button>
            <button type="button" 
                    onclick="submitExam()"
                    class="flex-1 py-2 text-lg font-bold text-white bg-green-600 rounded-[12px] hover:bg-green-700 transition font-jakarta">
                Submit
            </button>
        </div>
    </div>
</div>

<script>
let currentQuestion = 0;
const totalQuestions = {{ $soal->count() }};
const durationSeconds = {{ $durasi }};
let answeredQuestions = new Set();

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    showQuestion(0);
    startTimer();
});

// Timer
function startTimer() {
    let secondsRemaining = durationSeconds;
    
    const timerInterval = setInterval(() => {
        const hours = Math.floor(secondsRemaining / 3600);
        const minutes = Math.floor((secondsRemaining % 3600) / 60);
        const seconds = secondsRemaining % 60;
        
        const timerEl = document.getElementById('timer');
        timerEl.textContent = String(hours).padStart(2, '0') + ':' + 
                              String(minutes).padStart(2, '0') + ':' + 
                              String(seconds).padStart(2, '0');
        
        // Warna merah jika < 5 menit
        if (secondsRemaining < 300) {
            timerEl.style.color = '#DC2626';
        }
        
        if (secondsRemaining <= 0) {
            clearInterval(timerInterval);
            autoSubmitExam();
        }
        
        secondsRemaining--;
    }, 1000);
}

// Show question
function showQuestion(index) {
    document.querySelectorAll('.question-container').forEach(el => el.classList.add('hidden'));
    document.getElementById('question-' + index).classList.remove('hidden');
    
    // Update navigation
    document.querySelectorAll('[data-question]').forEach(el => {
        el.classList.remove('bg-[#F0924E]', 'text-white');
        el.classList.add('bg-gray-300', 'text-gray-700');
    });
    document.getElementById('nav-' + index).classList.add('bg-[#F0924E]', 'text-white');
    
    // Update button states
    document.getElementById('prevBtn').disabled = index === 0;
    document.getElementById('prevBtn').style.opacity = index === 0 ? '0.5' : '1';
    document.getElementById('prevBtn').style.cursor = index === 0 ? 'not-allowed' : 'pointer';
    
    document.getElementById('nextBtn').disabled = index === totalQuestions - 1;
    document.getElementById('nextBtn').textContent = index === totalQuestions - 1 ? 'Selesai' : 'Selanjutnya';
}

// Navigate questions
function goToQuestion(index) {
    currentQuestion = index;
    showQuestion(index);
}

function previousQuestion() {
    if (currentQuestion > 0) {
        currentQuestion--;
        showQuestion(currentQuestion);
    }
}

function nextQuestion() {
    if (currentQuestion < totalQuestions - 1) {
        currentQuestion++;
        showQuestion(currentQuestion);
    }
}

// Mark answered
function markAnswered(index) {
    answeredQuestions.add(index);
    document.getElementById('nav-' + index).classList.remove('bg-gray-300', 'text-gray-700');
    document.getElementById('nav-' + index).classList.add('bg-[#F0924E]', 'text-white');
}

// Modal
function showConfirmModal() {
    document.getElementById('confirmModal').classList.remove('hidden');
}

function closeConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
}

function submitExam() {
    closeConfirmModal();
    document.getElementById('examForm').submit();
}

function autoSubmitExam() {
    alert('Waktu ujian telah habis. Ujian akan dikirimkan secara otomatis.');
    document.getElementById('examForm').submit();
}

// Close modal on escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeConfirmModal();
    }
});
</script>
</body>
</html>
