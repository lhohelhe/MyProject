<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\SoalQuiz;
use App\Models\HasilQuiz;
use App\Models\UserQuizProgress;
use App\Services\QuizAdaptiveService;
use App\Services\XpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class QuizController extends Controller
{
    protected $quizAdaptiveService;

    public function __construct(QuizAdaptiveService $quizAdaptiveService)
    {
        $this->quizAdaptiveService = $quizAdaptiveService;
    }

    /**
     * Tampilkan quiz yang tersedia di bab tertentu
     */
    public function index($id_bab)
    {
        $quiz = Quiz::where('id_bab', $id_bab)
                    ->with('bab')
                    ->latest('id_quiz')
                    ->paginate(10);

        // Jika tidak ada quiz, redirect
        if ($quiz->isEmpty()) {
            return redirect()->back()->with('info', 'Belum ada quiz untuk bab ini.');
        }

        return view('user.quiz.index', compact('quiz', 'id_bab'));
    }

    /**
     * Mulai quiz - ambil soal sesuai difficulty user
     */
    public function start($id_quiz)
    {
        $quiz = Quiz::findOrFail($id_quiz);
        $user = Auth::user();

        // Ambil atau buat user progress untuk bab ini
        $progress = UserQuizProgress::firstOrCreate(
            ['user_id' => $user->id, 'id_bab' => $quiz->id_bab],
            [
                'difficulty_level' => 'easy',
                'streak_hari' => 0,
                'last_quiz_date' => null
            ]
        );

        // Ambil 10 soal random sesuai difficulty
        $soal = SoalQuiz::where('id_quiz', $id_quiz)
                        ->where('difficulty', $progress->difficulty_level)
                        ->inRandomOrder()
                        ->take(10)
                        ->get();

        // Jika soal tidak cukup, ambil dari difficulty lain
        if ($soal->count() < 10) {
            $remainingCount = 10 - $soal->count();
            $additionalSoal = SoalQuiz::where('id_quiz', $id_quiz)
                                      ->where('difficulty', '!=', $progress->difficulty_level)
                                      ->inRandomOrder()
                                      ->take($remainingCount)
                                      ->get();
            $soal = $soal->merge($additionalSoal);
        }

        return view('user.quiz.exam', compact('quiz', 'soal', 'progress'));
    }

    /**
     * Proses jawaban dan hitung skor
     */
    public function submit(Request $request)
    {
        $request->validate([
            'id_quiz' => 'required|exists:quiz,id_quiz',
            'jawaban' => 'required|array',
        ]);

        $user = Auth::user();
        $id_quiz = $request->id_quiz;

        // Ambil quiz dan soal
        $quiz = Quiz::findOrFail($id_quiz);
        $soal = SoalQuiz::whereIn('id_soal_quiz', array_keys($request->jawaban))->get();

        if ($soal->isEmpty()) {
            return redirect()->back()->with('error', 'Data soal tidak ditemukan.');
        }

        // Hitung jawaban benar
        $jumlahBenar = 0;
        $totalSoal = $soal->count();

        foreach ($soal as $s) {
            $jawaban = $request->jawaban[$s->id_soal_quiz] ?? null;

            if ($jawaban === $s->kunci_jawaban) {
                $jumlahBenar++;
            }
        }

        // Hitung skor dan XP
        $scoreData = $this->quizAdaptiveService->calculateScoreAndXP($jumlahBenar, $totalSoal);
        $skor = $scoreData['skor'];
        $xpDidapat = $scoreData['xp'];

        // Ambil user progress
        $progress = UserQuizProgress::where('user_id', $user->id)
                                    ->where('id_bab', $quiz->id_bab)
                                    ->first();

        if (!$progress) {
            $progress = UserQuizProgress::create([
                'user_id' => $user->id,
                'id_bab' => $quiz->id_bab,
                'difficulty_level' => 'easy',
                'streak_hari' => 0,
                'last_quiz_date' => null
            ]);
        }

        // Tentukan difficulty berikutnya berdasarkan difficulty saat ini user
        $nextDifficulty = $this->quizAdaptiveService->getNextDifficulty($skor, $progress->difficulty_level);

        // Cek apakah hari ini berturut-turut
        $isConsecutive = $this->quizAdaptiveService->isConsecutiveDay($progress->last_quiz_date);

        // Update user progress
        $this->quizAdaptiveService->updateUserProgress($user->id, $quiz->id_bab, $nextDifficulty, $isConsecutive);

        // Tambahkan XP ke user
        $xpResult = XpService::addXp($user, $xpDidapat);

        // Simpan hasil quiz
        $hasil = HasilQuiz::create([
            'user_id' => $user->id,
            'id_quiz' => $id_quiz,
            'skor' => $skor,
            'jumlah_benar' => $jumlahBenar,
            'total_soal' => $totalSoal,
            'difficulty_saat_ini' => $progress->difficulty_level,
            'xp_didapat' => $xpDidapat
        ]);

        return redirect()->route('user.quiz.result', $hasil->id_hasil_quiz)
                         ->with('success', 'Quiz selesai! Skor Anda: ' . $skor);
    }

    /**
     * Tampilkan hasil quiz dengan pembahasan
     */
    public function result($id_hasil_quiz)
    {
        $hasil = HasilQuiz::with(['quiz.soalQuiz', 'user'])
                          ->findOrFail($id_hasil_quiz);

        // Pastikan user hanya bisa lihat hasil miliknya
        if ($hasil->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('user.quiz.result', compact('hasil'));
    }
}
