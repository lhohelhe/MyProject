<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->judul_quiz }} - Quiz - SahabatBuku</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="antialiased font-jakarta" style="background-color: #E5F8FF;">
<div class="flex flex-col min-h-screen">

    {{-- header --}}
    <div class="sticky top-0 z-30 flex items-center justify-between p-6 bg-white border-b-2 border-black shadow-sm">
        <div class="flex items-center gap-4">
            <h1 class="text-2xl font-black text-black font-jakarta">{{ $quiz->judul_quiz }}</h1>
            @php
                $difficultyLabel = [
                    'easy' => 'Mudah',
                    'medium' => 'Sedang',
                    'hard' => 'Sulit'
                ][$difficulty] ?? 'Mudah';
                $difficultyColor = [
                    'easy' => 'bg-green-500',
                    'medium' => 'bg-yellow-500',
                    'hard' => 'bg-red-500'
                ][$difficulty] ?? 'bg-green-500';
            @endphp
            <span class="px-3 py-0.5 text-sm font-bold text-white border-2 border-black rounded-full {{ $difficultyColor }} font-jakarta shadow-[2px_2px_0px_#000]">
                {{ $difficultyLabel }}
            </span>
        </div>

        <div class="flex items-center gap-4">
            {{-- Tombol Keluar --}}
            <button type="button" onclick="showExitModal()"
                    class="flex items-center gap-1.5 px-3 py-2 text-xs font-black text-black bg-white border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                Keluar
            </button>
            {{-- timer --}}
            <div class="font-mono text-3xl font-black text-black" id="timer">
                10:00
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Keluar --}}
    <div id="exitModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white border-2 border-black shadow-[6px_6px_0px_#000] rounded-xl p-6 max-w-sm w-full mx-4">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-red-50 border-2 border-black rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-red-500"></i>
                </div>
                <h3 class="text-base font-black text-black">Keluar dari Quiz?</h3>
            </div>
            <p class="text-sm font-bold text-slate-500 mb-6 leading-relaxed">
                Progres quiz akan hilang. Jawaban yang sudah kamu isi tidak akan disimpan.
                Kamu bisa kembali mengerjakan quiz ini kapan saja.
            </p>
            <div class="flex gap-3">
                <button onclick="closeExitModal()"
                        class="flex-1 py-2.5 text-sm font-black text-black bg-white border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                    Lanjutkan Quiz
                </button>
                <a href="{{ route('user.buku.show', $quiz->bab->id_buku ?? 0) }}"
                   class="flex-1 py-2.5 text-sm font-black text-center text-white bg-red-500 border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                    Keluar
                </a>
            </div>
        </div>
    </div>

    {{-- main content --}}
    <main class="flex-1 flex flex-col items-center justify-center p-6 overflow-y-auto sm:p-8">
        <div class="w-full max-w-2xl">
            <form id="quizForm" action="{{ $isAiMode ? route('user.quiz.ai.submit') : route('user.quiz.submit') }}" method="POST" class="space-y-8">
                @csrf
                @if($isAiMode)
                    <input type="hidden" name="id_bab" value="{{ $quiz->id_bab }}">
                @else
                    <input type="hidden" name="id_quiz" value="{{ $quiz->id_quiz }}">
                @endif

                {{-- progress bar --}}
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-bold text-black font-jakarta" id="progressText">
                            Soal 1 dari {{ $soal->count() }}
                        </span>
                        <span class="text-sm font-bold text-black font-jakarta" id="progressPercent">
                            10%
                        </span>
                    </div>
                    <div class="w-full bg-white border-2 border-black rounded-full h-4 overflow-hidden">
                        <div id="progressBar" class="bg-[#F4922A] h-full rounded-full transition-all duration-300" style="width: 10%;"></div>
                    </div>
                </div>

                {{-- soal container --}}
                @foreach($soal as $index => $s)
                <div id="question-{{ $index }}" class="question-container hidden">
                    {{-- teks pertanyaan --}}
                    <div class="relative mb-8 p-6 bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl">
                        @if(!empty($s->tingkat))
                        @php
                            $tingkat = strtolower($s->tingkat);
                            $badgeClass = match($tingkat) {
                                'mudah'  => 'bg-green-100 text-green-700 border-green-400',
                                'sedang' => 'bg-yellow-100 text-yellow-700 border-yellow-400',
                                'sulit'  => 'bg-red-100 text-red-600 border-red-400',
                                default  => 'bg-slate-100 text-slate-500 border-slate-300',
                            };
                            $badgeLabel = ucfirst($tingkat);
                        @endphp
                        <span class="absolute top-4 right-4 px-2.5 py-0.5 text-[10px] font-black uppercase tracking-wider border-2 rounded-full {{ $badgeClass }}">
                            {{ $badgeLabel }}
                        </span>
                        @endif
                        <p class="text-2xl font-bold text-black font-jakarta">{{ $s->pertanyaan }}</p>
                    </div>

                    {{-- pilihan jawaban sebagai button --}}
                    <div class="space-y-3 mb-8">
                        @foreach(['a', 'b', 'c', 'd', 'e'] as $option)
                        @php
                            $columnName = 'opsi_' . $option;
                            $optionValue = $s->$columnName;
                        @endphp
                        @if(!empty($optionValue))
                        <!-- DEBUG: soal id = {{ $s->id_soal_quiz }} -->
                        <button type="button" 
                                class="answer-btn w-full p-4 text-left bg-white border-2 border-black rounded-xl hover:shadow-[2px_2px_0px_#000] transition-all font-jakarta"
                                onclick="selectAnswer('{{ $s->id_soal_quiz }}', '{{ strtoupper($option) }}', this, {{ $loop->index }})"
                                data-soal="{{ $s->id_soal_quiz }}"
                                data-option="{{ $option }}"
                                data-question="{{ $index }}">
                            <div class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center font-bold text-black bg-gray-100 border-2 border-black rounded-full">
                                    {{ strtoupper($option) }}
                                </span>
                                <span class="flex-1 text-black font-bold">
                                    {{ $optionValue }}
                                </span>
                            </div>
                        </button>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endforeach

                <!-- tombol navigasi -->
                <div class="flex flex-col gap-4 items-center pt-4">
                    <div class="flex justify-between items-center w-full gap-4">
                        <button type="button" 
                                id="prevBtn"
                                onclick="prevQuestion()"
                                class="flex-1 py-3 text-lg font-bold text-black bg-white border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                            &larr; Sebelumnya
                        </button>
                        <button type="button" 
                                id="nextBtn"
                                onclick="nextQuestion()"
                                class="flex-1 py-3 text-lg font-bold text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                            Selanjutnya &rarr;
                        </button>
                        <button type="button" 
                                id="submitBtn"
                                onclick="showConfirmModal()"
                                class="flex-1 py-3 text-lg font-bold text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta hidden">
                            Submit Quiz
                        </button>
                    </div>

                    {{-- Question number indicator --}}
                    <div id="questionIndicator" class="text-sm font-black text-black font-jakarta mt-2">
                        1 / 10
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

{{-- modal konfirmasi submit --}}
<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white border-2 border-black p-6 max-w-sm shadow-[4px_4px_0px_#000] rounded-xl">
        <h2 class="mb-4 text-xl font-black text-black font-jakarta">Konfirmasi Submit</h2>
        <p class="mb-6 text-black font-jakarta">Apakah Anda yakin ingin mengirimkan jawaban? Anda tidak dapat mengubahnya lagi.</p>
        <div class="flex gap-4">
            <button type="button" 
                    onclick="closeConfirmModal()"
                    class="flex-1 py-2 text-lg font-bold text-black bg-white border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                Batal
            </button>
            <button type="button" 
                    onclick="submitQuiz()"
                    class="flex-1 py-2 text-lg font-bold text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                Submit
            </button>
        </div>
    </div>
</div>

<script>
let currentQuestion = 0;
const totalQuestions = {{ $soal->count() }};
const timerDuration = 10 * 60; // 10 minutes in seconds
const selectedAnswers = {};

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    showQuestion(0);
    startTimer();
});

// Timer
function startTimer() {
    let secondsRemaining = timerDuration;
    
    const timerInterval = setInterval(() => {
        const minutes = Math.floor(secondsRemaining / 60);
        const seconds = secondsRemaining % 60;
        
        const timerEl = document.getElementById('timer');
        timerEl.textContent = String(minutes).padStart(2, '0') + ':' + 
                              String(seconds).padStart(2, '0');
        
        // Warna merah jika < 1 menit
        if (secondsRemaining < 60) {
            timerEl.style.color = '#DC2626';
        }
        
        if (secondsRemaining <= 0) {
            clearInterval(timerInterval);
            autoSubmitQuiz();
        }
        
        secondsRemaining--;
    }, 1000);
}

// Show question
function showQuestion(index) {
    currentQuestion = index;
    document.querySelectorAll('.question-container').forEach(el => el.classList.add('hidden'));
    document.getElementById('question-' + index).classList.remove('hidden');
    
    // Update progress
    const progress = Math.round((index + 1) / totalQuestions * 100);
    document.getElementById('progressBar').style.width = progress + '%';
    document.getElementById('progressText').textContent = 'Soal ' + (index + 1) + ' dari ' + totalQuestions;
    document.getElementById('progressPercent').textContent = progress + '%';
    
    // Update button visibilities
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    const questionIndicator = document.getElementById('questionIndicator');
    
    if (index === 0) {
        prevBtn.classList.add('invisible');
    } else {
        prevBtn.classList.remove('invisible');
    }
    
    if (index === totalQuestions - 1) {
        nextBtn.classList.add('hidden');
        submitBtn.classList.remove('hidden');
    } else {
        nextBtn.classList.remove('hidden');
        submitBtn.classList.add('hidden');
    }
    
    if (questionIndicator) {
        questionIndicator.textContent = (index + 1) + ' / ' + totalQuestions;
    }
    
    // Restore selected answer
    document.querySelectorAll(`[data-question="${index}"]`).forEach(btn => {
        btn.classList.remove('border-[#F4922A]', 'bg-orange-100');
        btn.classList.add('border-black', 'bg-white');
    });
    
    for (let soalId in selectedAnswers) {
        const answeredOption = selectedAnswers[soalId];
        const answeredBtn = document.querySelector(`[data-question="${index}"][data-option="${answeredOption}"]`);
        if (answeredBtn) {
            answeredBtn.classList.remove('border-black', 'bg-white');
            answeredBtn.classList.add('border-[#F4922A]', 'bg-orange-100');
        }
    }
}

// Navigation functions
function prevQuestion() {
    if (currentQuestion > 0) {
        currentQuestion--;
        showQuestion(currentQuestion);
    }
}

// Navigation functions
function nextQuestion() {
    if (currentQuestion < totalQuestions - 1) {
        currentQuestion++;
        showQuestion(currentQuestion);
    }
}

// Select answer
function selectAnswer(soalId, option, button, questionIndex) {
    console.log('soalId:', soalId, typeof soalId);
    selectedAnswers[soalId] = option;
    
    // Remove highlight from other buttons for this question
    document.querySelectorAll(`[data-question="${questionIndex}"]`).forEach(btn => {
        btn.classList.remove('border-[#F4922A]', 'bg-orange-100');
        btn.classList.add('border-black', 'bg-white');
    });
    
    // Highlight selected button
    button.classList.remove('border-black', 'bg-white');
    button.classList.add('border-[#F4922A]', 'bg-orange-100');
}

// Submit
function showConfirmModal() {
    document.getElementById('confirmModal').classList.remove('hidden');
}

function closeConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
}

function submitQuiz() {
    console.log('selectedAnswers:', selectedAnswers);
    closeConfirmModal();
    
    // Add hidden inputs for answers
    const form = document.getElementById('quizForm');
    for (let soalId in selectedAnswers) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'jawaban[' + soalId + ']';
        input.value = selectedAnswers[soalId];
        form.appendChild(input);
    }
    console.log('form inputs:', form.querySelectorAll('input[name^="jawaban"]').length);
    
    form.submit();
}

function autoSubmitQuiz() {
    alert('Waktu quiz telah habis. Quiz akan dikirimkan secara otomatis.');
    submitQuiz();
}

function showExitModal() {
    document.getElementById('exitModal').classList.remove('hidden');
}

function closeExitModal() {
    document.getElementById('exitModal').classList.add('hidden');
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeConfirmModal();
        closeExitModal();
    }
});

if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
</body>
</html>
