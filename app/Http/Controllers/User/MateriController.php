<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Subab;
use App\Models\UserFlashcard;
use App\Models\UserMateriProgress;
use App\Models\UserQuizProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    /**
     * Display the specified material.
     */
    public function show($id)
    {
        $materi = Materi::with('subab.bab.buku')->findOrFail($id);

        $bab = $materi->subab->bab;

        // All subbab in this bab, each with their materi — for the chapter map
        $allSubbab = Subab::with('materi')
            ->where('id_bab', $bab->id_bab)
            ->orderBy('nomor_subbab')
            ->get();

        // Flat list of all materi IDs in this bab (for prev/next across subbab)
        $allMateriIds = $allSubbab->flatMap(fn($s) => $s->materi->pluck('id_materi'))->values();
        $currentIndex = $allMateriIds->search($materi->id_materi);

        $prevId = $currentIndex > 0 ? $allMateriIds[$currentIndex - 1] : null;
        $nextId = $currentIndex !== false && $currentIndex < $allMateriIds->count() - 1
            ? $allMateriIds[$currentIndex + 1] : null;

        $prev = $prevId ? Materi::find($prevId) : null;
        $next = $nextId ? Materi::find($nextId) : null;

        // Total materi count in this bab (for progress %)
        $totalMateri = $allSubbab->sum(fn($s) => $s->materi->count());

        // XP earned by the current user
        $userXp = Auth::user()->total_xp ?? 0;

        return view('user.materi', compact(
            'materi',
            'bab',
            'allSubbab',
            'prev',
            'next',
            'totalMateri',
            'userXp'
        ));
    }

    // Display material reading page
    public function baca($id)
    {
        $materi = Materi::with('subab.bab.buku')->findOrFail($id);
        $bab    = $materi->subab->bab;
        $buku   = $bab->buku;

        // All subbab in this bab with their first materi (to support easy linking)
        $subbabList = Subab::with(['materi' => function($q) {
            $q->orderBy('id_materi', 'asc');
        }])
        ->where('id_bab', $materi->subab->id_bab)
        ->orderBy('nomor_subbab')
        ->get();

        // Clean $materi->isi: remove lines matching /^\d+$|^Bab\s+\d+$/i and lines under 10 chars
        $lines = explode("\n", $materi->isi);
        $cleanedLines = [];
        foreach ($lines as $line) {
            $trimmed = trim(strip_tags($line));
            // Check if matches a number or "Bab X" (case insensitive)
            if (preg_match('/^\d+$|^Bab\s+\d+$/i', $trimmed)) {
                continue;
            }
            // Skip short fragments under 10 characters
            if (strlen($trimmed) < 10) {
                continue;
            }
            $cleanedLines[] = $line;
        }
        $materi->isi = implode("\n", $cleanedLines);

        // Flat list of all materi IDs in this bab
        $allMateriIds = $subbabList->flatMap(fn($s) => $s->materi->pluck('id_materi'))->values();
        $currentIndex = $allMateriIds->search($materi->id_materi);

        $prevId = $currentIndex > 0 ? $allMateriIds[$currentIndex - 1] : null;
        $nextId = $currentIndex !== false && $currentIndex < $allMateriIds->count() - 1 ? $allMateriIds[$currentIndex + 1] : null;

        $prev = $prevId ? Materi::find($prevId) : null;
        $next = $nextId ? Materi::find($nextId) : null;

        // --- Persistent progress (never goes backward) ---
        $totalSubbab        = $subbabList->count();
        $currentSubbabIndex = $subbabList->search(fn($s) => $s->id_subbab == $materi->id_subbab);
        $currentSubbabIndex = $currentSubbabIndex !== false ? (int) $currentSubbabIndex : 0;

        $userId = Auth::id();
        $babId  = $bab->id_bab;

        // Fetch or create the progress record for this user + bab
        $progressRecord = UserMateriProgress::firstOrNew(
            ['user_id' => $userId, 'id_bab' => $babId],
            ['max_subbab_index' => 0]
        );

        // Only advance — never go backward
        if ($currentSubbabIndex > $progressRecord->max_subbab_index) {
            $progressRecord->max_subbab_index = $currentSubbabIndex;
        }
        $progressRecord->save();

        // Convert saved max index to a percentage (index is 0-based, so +1 for count)
        $progress = $totalSubbab > 0
            ? round((($progressRecord->max_subbab_index + 1) / $totalSubbab) * 100)
            : 0;

        $userXp = Auth::user()->total_xp ?? 0;

        return view('user.materi-baca', compact(
            'materi',
            'bab',
            'buku',
            'subbabList',
            'prev',
            'next',
            'progress',
            'userXp'
        ));
    }
}
