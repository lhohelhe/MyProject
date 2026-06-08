<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\SoalQuiz;
use App\Models\HasilQuiz;
use App\Models\UserQuizProgress;
use App\Models\Bab;
use App\Services\QuizAdaptiveService;
use App\Services\QuizGeneratorService;
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
        $bab = \App\Models\Bab::findOrFail($id_bab);
        $quizList = Quiz::where('id_bab', $id_bab)
                    ->with('bab')
                    ->latest('id_quiz')
                    ->paginate(10);

        $progress = UserQuizProgress::where('user_id', Auth::id())
                                    ->where('id_bab', $id_bab)
                                    ->first();

        return view('user.quiz.index', compact('quizList', 'id_bab', 'bab', 'progress'));
    }

    /**
     * Mulai quiz mode AI — soal digenerate dari konten materi bab, bukan dari soal_quiz
     */
    public function startAi(int $id_bab)
    {
        $bab = Bab::with('subab.materi')->findOrFail($id_bab);

        // Gabungkan semua isi materi di bab ini jadi satu konteks
        $konteks = '';
        foreach ($bab->subab as $subab) {
            foreach ($subab->materi as $materi) {
                $konteks .= strip_tags($materi->isi) . "\n\n";
            }
        }

        if (empty(trim($konteks))) {
            abort(404, 'Tidak ada konten materi di bab ini untuk membuat soal.');
        }

        // Buat Materi semu sebagai carrier konteks untuk QuizGeneratorService
        $materiProxy = new \App\Models\Materi();
        $materiProxy->id_materi = $id_bab; // dipakai sebagai cache key
        $materiProxy->isi       = $konteks;

        $generator = new QuizGeneratorService();
        $rawSoal   = $generator->generate($materiProxy, 10);

        // Simpan ke session supaya submitAi() bisa memverifikasi jawaban
        session(["quiz_ai_soal_{$id_bab}" => $rawSoal]);

        // Bangun koleksi SoalQuiz-like objects agar view exam.blade kompatibel
        $soal = collect($rawSoal)->map(function ($item, $idx) use ($id_bab) {
            $s = new SoalQuiz();
            $s->exists = false; // pastikan tidak dianggap persisted record
            // Set PK sebagai string agar tidak di-cast ke integer (yang menghasilkan 0)
            $s->setKeyType('string');
            $s->setKeyName('id_soal_quiz');
            $s->setAttribute('id_soal_quiz', 'ai_' . $id_bab . '_' . $idx);
            $s->setAttribute('pertanyaan',    $item['pertanyaan'] ?? '');
            $s->setAttribute('opsi_a',        $item['opsi']['A'] ?? '');
            $s->setAttribute('opsi_b',        $item['opsi']['B'] ?? '');
            $s->setAttribute('opsi_c',        $item['opsi']['C'] ?? '');
            $s->setAttribute('opsi_d',        $item['opsi']['D'] ?? '');
            $s->setAttribute('kunci_jawaban', strtolower($item['jawaban'] ?? 'a'));
            $s->setAttribute('tingkat',       $item['tingkat'] ?? null);
            $s->setAttribute('difficulty',    match(strtolower($item['tingkat'] ?? '')) {
                'sedang' => 'medium',
                'sulit'  => 'hard',
                default  => 'easy',
            });
            return $s;
        });

        // Buat Quiz semu agar view tidak error saat akses $quiz->judul_quiz
        $quiz              = new Quiz();
        $quiz->id_quiz     = 0;
        $quiz->id_bab      = $id_bab;
        $quiz->judul_quiz  = 'Quiz AI — ' . $bab->judul_bab;
        $quiz->difficulty  = 'easy';

        $progress  = UserQuizProgress::where('user_id', Auth::id())
                                     ->where('id_bab', $id_bab)
                                     ->first();
        $difficulty = $progress?->difficulty_level ?? 'easy';

        $isAiMode = true;

        return view('user.quiz.exam', compact('quiz', 'soal', 'progress', 'difficulty', 'isAiMode'));
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

        $difficulty = $progress->difficulty_level;

        // Ambil 10 soal random sesuai difficulty
        $soal = SoalQuiz::where('id_quiz', $id_quiz)
                        ->where('difficulty', $difficulty)
                        ->inRandomOrder()
                        ->take(10)
                        ->get();

        // Jika soal tidak cukup, ambil dari difficulty lain
        if ($soal->count() < 10) {
            $remainingCount = 10 - $soal->count();
            $additionalSoal = SoalQuiz::where('id_quiz', $id_quiz)
                                      ->where('difficulty', '!=', $difficulty)
                                      ->inRandomOrder()
                                      ->take($remainingCount)
                                      ->get();
            $soal = $soal->merge($additionalSoal);
        }

        $isAiMode = false;

        return view('user.quiz.exam', compact('quiz', 'soal', 'progress', 'difficulty', 'isAiMode'));
    }

    /**
     * Proses jawaban quiz AI dari session — jangan ubah submit() yang lama
     */
    public function submitAi(Request $request)
    {
        \Log::info('submitAi called', [
            'jawaban' => $request->jawaban,
            'all' => $request->all(),
            'id_bab' => $request->id_bab,
        ]);

        $request->validate([
            'id_bab' => 'required|integer',
            'jawaban' => 'required|array',
        ]);

        $id_bab   = (int) $request->id_bab;
        $user     = Auth::user();
        $sessionKey = "quiz_ai_soal_{$id_bab}";
        $rawSoal  = session($sessionKey);

        if (empty($rawSoal)) {
            return redirect()->route('user.quiz.start-ai', $id_bab)
                             ->with('error', 'Sesi soal habis. Silakan mulai ulang.');
        }

        // Hitung benar/salah berdasarkan kunci dari session
        $jumlahBenar = 0;
        $totalSoal   = count($rawSoal);

        foreach ($rawSoal as $idx => $s) {
            $virtualId    = 'ai_' . $id_bab . '_' . $idx;
            $jawabanUser  = $request->jawaban[$virtualId] ?? null;
            $kunci        = strtolower($s['jawaban'] ?? '');

            if ($jawabanUser !== null && strtolower($jawabanUser) === $kunci) {
                $jumlahBenar++;
            }
        }

        // Skor dan XP — pakai service yang sama seperti submit() lama
        $scoreData  = $this->quizAdaptiveService->calculateScoreAndXP($jumlahBenar, $totalSoal);
        $skor       = $scoreData['skor'];
        $xpDidapat  = $scoreData['xp'];

        // Ambil atau buat progress
        $progress = UserQuizProgress::firstOrCreate(
            ['user_id' => $user->id, 'id_bab' => $id_bab],
            ['difficulty_level' => 'easy', 'streak_hari' => 0, 'last_quiz_date' => null]
        );

        $difficultySebelum = $progress->difficulty_level;
        $nextDifficulty    = $this->quizAdaptiveService->getNextDifficulty($skor, $difficultySebelum);
        $isConsecutive     = $this->quizAdaptiveService->isConsecutiveDay($progress->last_quiz_date);

        $this->quizAdaptiveService->updateUserProgress($user->id, $id_bab, $nextDifficulty, $isConsecutive);

        XpService::addXp($user, $xpDidapat);

        // Simpan ke hasil_quiz — id_quiz null (AI mode, tidak ada quiz di tabel)
        $hasil = HasilQuiz::create([
            'user_id'             => $user->id,
            'id_quiz'             => null,
            'id_bab'              => $id_bab,
            'skor'                => $skor,
            'jumlah_benar'        => $jumlahBenar,
            'total_soal'          => $totalSoal,
            'difficulty_saat_ini' => $difficultySebelum,
            'xp_didapat'          => $xpDidapat,
        ]);

        // Buat array pembahasan untuk AI mode
        $pembahasan = [];
        foreach ($rawSoal as $idx => $s) {
            $virtualId = 'ai_' . $id_bab . '_' . $idx;
            $jawabanUser = $request->jawaban[$virtualId] ?? null;
            $kunci = strtoupper($s['jawaban'] ?? 'A');

            $pembahasan[] = [
                'nomor' => $idx + 1,
                'pertanyaan' => $s['pertanyaan'] ?? '',
                'jawaban_benar' => $kunci,
                'jawaban_user' => strtoupper($jawabanUser ?? ''),
                'pembahasan' => $s['pembahasan'] ?? '',
            ];
        }

        // Simpan pembahasan di session untuk diambil di halaman result
        session(["quiz_ai_pembahasan_{$hasil->id_hasil_quiz}" => $pembahasan]);

        // Hapus session soal setelah submit
        session()->forget($sessionKey);

        return redirect()->route('user.quiz.result', $hasil->id_hasil_quiz)
                         ->with('success', 'Quiz selesai!');
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

        $difficultySebelum = $progress->difficulty_level;

        // Tentukan difficulty berikutnya berdasarkan difficulty saat ini user
        $nextDifficulty = $this->quizAdaptiveService->getNextDifficulty($skor, $difficultySebelum);

        // Cek apakah hari ini berturut-turut
        $isConsecutive = $this->quizAdaptiveService->isConsecutiveDay($progress->last_quiz_date);

        // Update user progress
        $progress = $this->quizAdaptiveService->updateUserProgress($user->id, $quiz->id_bab, $nextDifficulty, $isConsecutive);

        // Tambahkan XP ke user
        XpService::addXp($user, $xpDidapat);

        // Simpan hasil quiz
        $hasil = HasilQuiz::create([
            'user_id' => $user->id,
            'id_quiz' => $id_quiz,
            'skor' => $skor,
            'jumlah_benar' => $jumlahBenar,
            'total_soal' => $totalSoal,
            'difficulty_saat_ini' => $difficultySebelum,
            'xp_didapat' => $xpDidapat
        ]);

        return redirect()->route('user.quiz.result', $hasil->id_hasil_quiz)
                         ->with('success', 'Quiz selesai!');
    }

    /**
     * Tampilkan hasil quiz dengan pembahasan
     */
    public function result($id_hasil_quiz)
    {
        $hasil = HasilQuiz::with(['quiz.bab', 'bab', 'user'])
                          ->findOrFail($id_hasil_quiz);

        if ($hasil->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // AI mode: quiz null, ambil id_bab dari hasil langsung
        $id_bab = $hasil->quiz?->id_bab ?? $hasil->id_bab;

        $progress = $id_bab
            ? UserQuizProgress::where('user_id', $hasil->user_id)
                               ->where('id_bab', $id_bab)
                               ->first()
            : null;

        // If quiz is null (AI mode), construct a dummy quiz with bab relationship
        if ($hasil->quiz === null && $hasil->bab) {
            $quiz = new Quiz();
            $quiz->id_quiz = 0;
            $quiz->bab = $hasil->bab;
        } else {
            $quiz = $hasil->quiz;
        }

        $xpDapat           = $hasil->xp_didapat;
        $difficultySebelum = $hasil->difficulty_saat_ini;
        $difficultyBaru    = $progress?->difficulty_level ?? $difficultySebelum;
        $streakHari        = $progress?->streak_hari ?? 0;

        // Get explanations from session for AI mode
        $pembahasan = session("quiz_ai_pembahasan_{$id_hasil_quiz}");

        return view('user.quiz.result', compact('hasil', 'quiz', 'xpDapat', 'difficultySebelum', 'difficultyBaru', 'streakHari', 'pembahasan'));
    }
}