<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\HasilQuiz;
use App\Models\UserFlashcard;
use App\Models\UserMateriProgress;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();
        
        // Define relation dynamically since it is not defined in the Subab model
        \App\Models\Subab::resolveRelationUsing('materi', function ($subabModel) {
            return $subabModel->hasMany(\App\Models\Materi::class, 'id_subbab', 'id_subbab');
        });

        $buku = Buku::with([
            'bab.subab.materi',
            'bab.quiz',
            'bab.subab.flashcard',
        ])->findOrFail($id);

        // Load semua materi reading progress user untuk buku ini (hindari N+1)
        $babIds = $buku->bab->pluck('id_bab');
        $materiProgressMap = UserMateriProgress::where('user_id', $user->id)
            ->whereIn('id_bab', $babIds)
            ->pluck('max_subbab_index', 'id_bab');

        // Hitung progress per bab
        $babProgress = [];

        foreach ($buku->bab as $bab) {
            // Progress materi (berdasarkan quiz yang sudah dikerjakan per bab)
            $totalQuiz = $bab->quiz->count();
            $doneQuiz = $totalQuiz > 0
                ? HasilQuiz::where('user_id', $user->id)
                    ->whereIn('id_quiz', $bab->quiz->pluck('id_quiz'))
                    ->distinct('id_quiz')->count('id_quiz')
                : 0;

            // Progress flashcard per bab (dari semua subbab)
            $allFlashcardIds = $bab->subab->flatMap(fn($s) => $s->flashcard ?? collect())->pluck('id_flashcard');
            $totalFlashcard = $allFlashcardIds->count();
            $doneFlashcard = $totalFlashcard > 0
                ? UserFlashcard::where('user_id', $user->id)
                    ->whereIn('id_flashcard', $allFlashcardIds)
                    ->where('status', 'sudah')->count()
                : 0;

            // Progress membaca materi dari UserMateriProgress
            $totalSubbab  = $bab->subab->count();
            $maxReached   = isset($materiProgressMap[$bab->id_bab]) ? (int) $materiProgressMap[$bab->id_bab] : -1;
            $materiPct    = $totalSubbab > 0 && $maxReached >= 0
                ? round((($maxReached + 1) / $totalSubbab) * 100)
                : 0;

            $quizPct   = $totalQuiz > 0 ? round(($doneQuiz / $totalQuiz) * 100) : 0;
            $flashPct  = $totalFlashcard > 0 ? round(($doneFlashcard / $totalFlashcard) * 100) : 0;

            // Hitung overall progress per bab (rata-rata materi + quiz + flashcard)
            $components   = [$materiPct];
            if ($totalQuiz > 0)       $components[] = $quizPct;
            if ($totalFlashcard > 0)  $components[] = $flashPct;
            $overallPct   = round(array_sum($components) / count($components));

            $babProgress[$bab->id_bab] = [
                'quiz_pct'      => $quizPct,
                'quiz_done'     => $doneQuiz,
                'quiz_total'    => $totalQuiz,
                'flash_pct'     => $flashPct,
                'flash_done'    => $doneFlashcard,
                'flash_total'   => $totalFlashcard,
                'overall_pct'   => $overallPct,
            ];
        }

        // Overall buku progress
        $allPcts = collect($babProgress)->pluck('overall_pct');
        $progress = $allPcts->count() > 0 ? round($allPcts->average()) : 0;

        return view('user.buku', compact('buku', 'progress', 'babProgress'));
    }
}
