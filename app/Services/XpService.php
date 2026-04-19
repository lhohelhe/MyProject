<?php

namespace App\Services;

use App\Models\User;

class XpService
{
    const LEVEL_THRESHOLDS = [
        1 => 0, 2 => 100, 3 => 250, 4 => 500,
        5 => 900, 6 => 1400, 7 => 2000, 8 => 2700,
        9 => 3500, 10 => 4500
    ];

    /**
     * Tambahkan XP ke user dan cek level up
     * 
     * @param User $user
     * @param int $xp
     * @return array ['xp_added' => int, 'level_up' => bool, 'new_level' => int]
     */
    public static function addXp(User $user, int $xp): array
    {
        $user->total_xp += $xp;
        $user->xp += $xp;
        $newLevel = self::calculateLevel($user->total_xp);
        $levelUp = $newLevel > $user->level;
        $user->level = $newLevel;
        $user->save();

        return [
            'xp_added' => $xp,
            'level_up' => $levelUp,
            'new_level' => $newLevel
        ];
    }

    /**
     * Hitung level berdasarkan total XP
     * 
     * @param int $totalXp
     * @return int
     */
    private static function calculateLevel(int $totalXp): int
    {
        $level = 1;
        foreach (self::LEVEL_THRESHOLDS as $lvl => $threshold) {
            if ($totalXp >= $threshold) {
                $level = $lvl;
            }
        }
        return $level;
    }

    /**
     * Dapatkan XP saat ini dalam level (current level progress)
     * 
     * @param User $user
     * @return int
     */
    public static function getXpInCurrentLevel(User $user): int
    {
        $currentLevelThreshold = self::LEVEL_THRESHOLDS[$user->level] ?? 0;
        return $user->total_xp - $currentLevelThreshold;
    }

    /**
     * Dapatkan XP yang dibutuhkan untuk level berikutnya
     * 
     * @param User $user
     * @return int
     */
    public static function getXpForNextLevel(User $user): int
    {
        $nextLevel = $user->level + 1;
        $nextLevelThreshold = self::LEVEL_THRESHOLDS[$nextLevel] ?? self::LEVEL_THRESHOLDS[$user->level];
        $currentLevelThreshold = self::LEVEL_THRESHOLDS[$user->level] ?? 0;
        return $nextLevelThreshold - $currentLevelThreshold;
    }

    /**
     * Dapatkan persentase progress ke level berikutnya (0-100)
     * 
     * @param User $user
     * @return int
     */
    public static function getProgressToNextLevel(User $user): int
    {
        $xpInCurrentLevel = self::getXpInCurrentLevel($user);
        $xpForNextLevel = self::getXpForNextLevel($user);

        if ($xpForNextLevel === 0) {
            return 100; // Max level
        }

        return intval(($xpInCurrentLevel / $xpForNextLevel) * 100);
    }

    /**
     * Dapatkan XP yang diperlukan untuk level tertentu
     * 
     * @param int $level
     * @return int|null
     */
    public static function getThresholdForLevel(int $level): ?int
    {
        return self::LEVEL_THRESHOLDS[$level] ?? null;
    }
}

