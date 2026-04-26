<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->judul_quiz }} - Quiz - SahabatBuku</title>
    @vite('resources/css/app.css')
</head>
<body class="antialiased font-jakarta bg-gray-50">
<div class="flex flex-col min-h-screen">

    {{-- header --}}
    <div class="flex items-center justify-between p-6 bg-white border-b border-gray-200 shadow-sm">
        <div class="flex items-center gap-4">
            <h1 class="text-2xl font-bold text-gray-800 font-jakarta">{{ $quiz->judul_quiz }}</h1>
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
            <span class="px-3 py-1 text-sm font-bold text-white rounded-full {{ $difficultyColor }} font-jakarta">
                {{ $difficultyLabel }}
            </span>
        </div>
        
        {{-- timer --}}
        <div class="font-mono text-3xl font-bold" id="timer" style="color: #333;">
            10:00
        </div>
    </div>

    {{-- main content --}}
    <main class="flex-1 flex flex-col items-center justify-center p-6 overflow-y-auto sm:p-8">
        <div class="w-full max-w-2xl">
            <form id="quizForm" action="{{ route('user.quiz.submit') }}" method="POST" class="space-y-8">
                @csrf

                {{-- progress bar --}}
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-600 font-jakarta" id="progressText">
                            Soal 1 dari {{ $soal->count() }}
                        </span>
                        <span class="text-sm font-semibold text-gray-600 font-jakarta" id="progressPercent">
                            10%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="progressBar" class="bg-[#F0924E] h-2 rounded-full transition-all duration-300" style="width: 10%;"></div>
                    </div>
                </div>

                {{-- soal container --}}
                @foreach($soal as $index => $s)
                <div id="question-{{ $index }}" class="question-container hidden">
                    {{-- teks pertanyaan --}}
                    <div class="mb-8 p-6 bg-white rounded-[12px] shadow-sm">
                        <p class="text-2xl font-bold text-gray-800 font-jakarta">{{ $s->pertanyaan }}</p>
                    </div>

                    {{-- pilihan jawaban sebagai button --}}
                    <div class="space-y-3 mb-8">
                        @foreach(['a', 'b', 'c', 'd'] as $option)
                        <button type="button" 
                                class="answer-btn w-full p-4 text-left bg-white border-2 border-gray-200 rounded-[12px] transition-all hover:border-[#F0924E] hover:bg-orange-50 font-jakarta"
                                onclick="selectAnswer('{{ $s->id_soal_quiz }}', '{{ $option }}', this, {{ $index }})"
                                data-soal="{{ $s->id_soal_quiz }}"
                                data-option="{{ $option }}"
                                data-question="{{ $index }}">
                            <div class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center font-bold text-gray-700 bg-gray-100 rounded-full">
                                    {{ strtoupper($option) }}
                                </span>
                                <span class="flex-1 text-gray-700">
                                    @php
                                        $columnName = 'opsi_' . $option;
                                        echo $s->$columnName;
                                    @endphp
                                </span>
                            </div>
                        </button>
                        @endforeach
                    </div>
                </div>
                @endforeach

                {{-- tombol navigasi --}}
                <div class="pt-4">
                    <button type="button" 
                            id="submitBtn"
                            onclick="showConfirmModal()"
                            class="w-full py-3 text-lg font-bold text-white bg-green-600 rounded-[12px] hover:bg-green-700 transition font-jakarta">
                        Selanjutnya
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

{{-- modal konfirmasi submit --}}
<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
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
                    onclick="submitQuiz()"
                    class="flex-1 py-2 text-lg font-bold text-white bg-green-600 rounded-[12px] hover:bg-green-700 transition font-jakarta">
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
    document.querySelectorAll('.question-container').forEach(el => el.classList.add('hidden'));
    document.getElementById('question-' + index).classList.remove('hidden');
    
    // Update progress
    const progress = Math.round((index + 1) / totalQuestions * 100);
    document.getElementById('progressBar').style.width = progress + '%';
    document.getElementById('progressText').textContent = 'Soal ' + (index + 1) + ' dari ' + totalQuestions;
    document.getElementById('progressPercent').textContent = progress + '%';
    
    // Update submit button
    const submitBtn = document.getElementById('submitBtn');
    if (index === totalQuestions - 1) {
        submitBtn.textContent = 'Submit';
        submitBtn.style.backgroundColor = '#16a34a';
    } else {
        submitBtn.textContent = 'Selanjutnya';
        submitBtn.style.backgroundColor = '#16a34a';
    }
    
    // Restore selected answer
    const selectedBtn = document.querySelector(`[data-question="${index}"][data-option]`);
    document.querySelectorAll(`[data-question="${index}"]`).forEach(btn => {
        btn.classList.remove('border-[#F0924E]', 'bg-orange-100', 'border-2');
        btn.classList.add('border-gray-200', 'bg-white');
    });
    
    // Highlight previously selected answer if exists
    for (let soalId in selectedAnswers) {
        const answeredOption = selectedAnswers[soalId];
        const answeredBtn = document.querySelector(`[data-question="${index}"][data-option="${answeredOption}"]`);
        if (answeredBtn) {
            answeredBtn.classList.remove('border-gray-200', 'bg-white');
            answeredBtn.classList.add('border-[#F0924E]', 'bg-orange-100', 'border-2');
        }
    }
}

// Select answer
function selectAnswer(soalId, option, button, questionIndex) {
    selectedAnswers[soalId] = option;
    
    // Remove highlight from other buttons for this question
    document.querySelectorAll(`[data-question="${questionIndex}"]`).forEach(btn => {
        btn.classList.remove('border-[#F0924E]', 'bg-orange-100', 'border-2');
        btn.classList.add('border-gray-200', 'bg-white');
    });
    
    // Highlight selected button
    button.classList.remove('border-gray-200', 'bg-white');
    button.classList.add('border-[#F0924E]', 'bg-orange-100', 'border-2');
    
    // Auto-next to next question
    if (currentQuestion < totalQuestions - 1) {
        setTimeout(() => {
            currentQuestion++;
            showQuestion(currentQuestion);
        }, 300);
    }
}

// Submit
function showConfirmModal() {
    if (currentQuestion === totalQuestions - 1) {
        document.getElementById('confirmModal').classList.remove('hidden');
    } else {
        currentQuestion++;
        if (currentQuestion >= totalQuestions) {
            currentQuestion = totalQuestions - 1;
        }
        showQuestion(currentQuestion);
    }
}

function closeConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
}

function submitQuiz() {
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
    
    form.submit();
}

function autoSubmitQuiz() {
    alert('Waktu quiz telah habis. Quiz akan dikirimkan secara otomatis.');
    submitQuiz();
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
