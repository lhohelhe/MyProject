<?php

namespace App\Services;

use App\Models\HasilQuiz;
use App\Models\UserQuizProgress;
use Carbon\Carbon;

class QuizAdaptiveService
{
    /**
     * Hitung skor dan XP berdasarkan jawaban benar
     * 
     * @param int $jumlahBenar
     * @param int $totalSoal
     * @return array ['skor' => int, 'xp' => int]
     */
    public function calculateScoreAndXP(int $jumlahBenar, int $totalSoal): array
    {
        // Skor adalah persentase jawaban benar
        $skor = intval(($jumlahBenar / $totalSoal) * 100);

        // Hitung XP
        $xp = $jumlahBenar * 10; // +10 per jawaban benar

        // Bonus: +50 XP jika perfect score (100%)
        if ($skor === 100) {
            $xp += 50;
        }

        return [
            'skor' => $skor,
            'xp' => $xp
        ];
    }

    /**
     * Tentukan difficulty level berikutnya berdasarkan performa
     * 
     * @param int $skor (0-100)
     * @param string $difficultySekarang (easy, medium, hard)
     * @return string (easy, medium, hard)
     */
    public function getNextDifficulty(int $skor, string $difficultySekarang): string
    {
        // Benar >= 80% → naik difficulty
        if ($skor >= 80) {
            return $this->increaseDifficulty($difficultySekarang);
        }

        // Benar < 50% → turun difficulty
        if ($skor < 50) {
            return $this->decreaseDifficulty($difficultySekarang);
        }

        // 50-79% → tetap
        return $difficultySekarang;
    }

    /**
     * Naikkan level kesulitan
     */
    private function increaseDifficulty(string $difficulty): string
    {
        return match ($difficulty) {
            'easy' => 'medium',
            'medium' => 'hard',
            'hard' => 'hard', // Sudah maksimal
            default => 'easy'
        };
    }

    /**
     * Turunkan level kesulitan
     */
    private function decreaseDifficulty(string $difficulty): string
    {
        return match ($difficulty) {
            'easy' => 'easy', // Sudah minimal
            'medium' => 'easy',
            'hard' => 'medium',
            default => 'easy'
        };
    }

    /**
     * Update progress user setelah menyelesaikan quiz
     * 
     * @param int $userId
     * @param int $idBab
     * @param string $nextDifficulty
     * @param bool $isConsecutiveDay
     * @return UserQuizProgress
     */
    public function updateUserProgress(int $userId, int $idBab, string $nextDifficulty, bool $isConsecutiveDay = false): UserQuizProgress
    {
        $progress = UserQuizProgress::firstOrCreate(
            ['user_id' => $userId, 'id_bab' => $idBab],
            [
                'difficulty_level' => 'easy',
                'streak_hari' => 0,
                'last_quiz_date' => null
            ]
        );

        // Update difficulty level
        $progress->difficulty_level = $nextDifficulty;

        // Update streak dan last_quiz_date
        $today = Carbon::now()->toDateString();
        $lastQuizDate = $progress->last_quiz_date?->toDateString();

        if ($lastQuizDate === $today) {
            // Sudah mengerjakan quiz hari ini, streak tidak bertambah
        } elseif ($isConsecutiveDay) {
            // Hari berturut-turut
            $progress->streak_hari++;
        } else {
            // Hari baru tapi tidak berturut-turut
            $progress->streak_hari = 1;
        }

        $progress->last_quiz_date = Carbon::now();
        $progress->save();

        return $progress;
    }

    /**
     * Cek apakah hari ini adalah hari berturut-turut setelah last_quiz_date
     */
    public function isConsecutiveDay(?string $lastQuizDate): bool
    {
        if (!$lastQuizDate) {
            return false;
        }

        $lastDate = Carbon::parse($lastQuizDate);
        $yesterday = Carbon::now()->subDay()->toDateString();

        return $lastDate->toDateString() === $yesterday;
    }
}
