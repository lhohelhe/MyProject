<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $simulasi->judul_simulasi }} - Ujian - SahabatBuku</title>
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
            <h1 class="text-2xl font-black text-black font-jakarta">{{ $simulasi->judul_simulasi }}</h1>
        </div>
        {{-- timer --}}
        <div class="font-mono text-3xl font-black text-black" id="timer">
            {{ floor($durasi / 3600) }}:{{ str_pad(floor(($durasi % 3600) / 60), 2, '0', STR_PAD_LEFT) }}:{{ str_pad($durasi % 60, 2, '0', STR_PAD_LEFT) }}
        </div>
    </div>

    <div class="flex flex-1 overflow-hidden">
        {{-- sidebar navigasi soal --}}
        <div class="w-24 px-2 py-6 overflow-y-auto bg-white border-r-2 border-black sm:w-32">
            <div class="grid grid-cols-3 gap-2 sm:grid-cols-2">
                @foreach($soal as $index => $s)
                <button onclick="goToQuestion({{ $index }})"
                        id="nav-{{ $index }}"
                        class="p-2 text-xs font-black text-center text-black transition-all bg-white border-2 border-black rounded-lg shadow-[2px_2px_0px_#000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px]"
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
<input type="hidden" name="id_simulasi" value="{{ $simulasi->id_simulasi }}">


                    {{-- soal container --}}
                    @foreach($soal as $index => $s)
                    <div id="question-{{ $index }}" class="hidden question-container">
                        {{-- nomor soal --}}
                        <div class="mb-4">
                            <span class="text-sm font-black text-black font-jakarta">Soal {{ $index + 1 }} dari {{ $soal->count() }}</span>
                        </div>

                        {{-- pertanyaan --}}
                        <div class="mb-8 p-6 bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl">
                            <p class="text-2xl font-bold text-black font-jakarta">{{ $s->pertanyaan }}</p>
                        </div>

                        {{-- pilihan jawaban sebagai button --}}
                        <div class="space-y-3 mb-8">
                            @foreach(['a', 'b', 'c', 'd'] as $option)
                            @if(!empty($s->{'opsi_' . $option}))
                            <button type="button"
                                    class="answer-btn w-full p-4 text-left bg-white border-2 border-black rounded-xl hover:shadow-[2px_2px_0px_#000] transition-all font-jakarta"
                                    onclick="selectAnswer('{{ $s->id_soal }}', '{{ $option }}', this, {{ $index }})"
                                    data-soal="{{ $s->id_soal }}"
                                    data-option="{{ $option }}"
                                    data-question="{{ $index }}">
                                <div class="flex items-start gap-3">
                                    <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center font-bold text-black bg-gray-100 border-2 border-black rounded-full">
                                        {{ strtoupper($option) }}
                                    </span>
                                    <span class="flex-1 text-black font-bold">
                                        {{ $s->{'opsi_' . $option} }}
                                    </span>
                                </div>
                            </button>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                    {{-- tombol navigasi --}}
                    <div class="flex justify-between items-center gap-4 pt-4">
                        <button type="button"
                                id="prevBtn"
                                onclick="previousQuestion()"
                                class="flex-1 py-3 text-lg font-bold text-black bg-white border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                            &larr; Sebelumnya
                        </button>
                        <button type="button"
                                id="nextBtn"
                                onclick="nextQuestion()"
                                class="flex-1 py-3 text-lg font-bold text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                            Selanjutnya &rarr;
                        </button>
                    </div>

                    {{-- tombol submit --}}
                    <div class="pt-4">
                        <button type="button"
                                onclick="showConfirmModal()"
                                class="w-full py-3 text-lg font-bold text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
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
                    onclick="submitExam()"
                    class="flex-1 py-2 text-lg font-bold text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition font-jakarta">
                Submit
            </button>
        </div>
    </div>
</div>

<script>
let currentQuestion = 0;
const totalQuestions = {{ $soal->count() }};
const durationSeconds = {{ $durasi }};
const selectedAnswers = {};

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
    currentQuestion = index;
    document.querySelectorAll('.question-container').forEach(el => el.classList.add('hidden'));
    document.getElementById('question-' + index).classList.remove('hidden');

    // Update sidebar nav
    document.querySelectorAll('[data-question]').forEach(el => {
        el.classList.remove('bg-[#F4922A]', 'text-white');
        el.classList.add('bg-white', 'text-black');
    });
    const navBtn = document.getElementById('nav-' + index);
    if (navBtn) {
        navBtn.classList.remove('bg-white', 'text-black');
        navBtn.classList.add('bg-[#F4922A]', 'text-white');
    }

    // Prev button
    const prevBtn = document.getElementById('prevBtn');
    if (index === 0) {
        prevBtn.classList.add('invisible');
    } else {
        prevBtn.classList.remove('invisible');
    }

    // Next button label
    const nextBtn = document.getElementById('nextBtn');
    nextBtn.innerHTML = index === totalQuestions - 1 ? 'Selesai' : 'Selanjutnya &rarr;';

    // Restore selected answer highlight
    document.querySelectorAll(`[data-question="${index}"]`).forEach(btn => {
        if (btn.tagName === 'BUTTON') {
            btn.classList.remove('border-[#F4922A]', 'bg-orange-100');
            btn.classList.add('border-black', 'bg-white');
        }
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

// Select answer (button-based)
function selectAnswer(soalId, option, button, questionIndex) {
    selectedAnswers[soalId] = option;

    document.querySelectorAll(`[data-question="${questionIndex}"].answer-btn`).forEach(btn => {
        btn.classList.remove('border-[#F4922A]', 'bg-orange-100');
        btn.classList.add('border-black', 'bg-white');
    });

    button.classList.remove('border-black', 'bg-white');
    button.classList.add('border-[#F4922A]', 'bg-orange-100');

    // Mark nav as answered
    const navBtn = document.getElementById('nav-' + questionIndex);
    if (navBtn && !navBtn.classList.contains('bg-[#F4922A]')) {
        navBtn.classList.remove('bg-white', 'text-black');
        navBtn.classList.add('bg-[#F4922A]', 'text-white');
    }
}

// Navigate
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

// Modal
function showConfirmModal() {
    document.getElementById('confirmModal').classList.remove('hidden');
}

function closeConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
}

function submitExam() {
    closeConfirmModal();

    // Inject hidden inputs for selected answers
    const form = document.getElementById('examForm');
    for (let soalId in selectedAnswers) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'jawaban[' + soalId + ']';
        input.value = selectedAnswers[soalId];
        form.appendChild(input);
    }

    form.submit();
}

function autoSubmitExam() {
    alert('Waktu ujian telah habis. Ujian akan dikirimkan secara otomatis.');
    submitExam();
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeConfirmModal();
});

if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
</body>
</html>
