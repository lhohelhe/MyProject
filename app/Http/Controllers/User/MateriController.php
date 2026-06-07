<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Subab;
use App\Models\UserFlashcard;
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
}
