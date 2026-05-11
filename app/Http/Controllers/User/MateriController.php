<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    /**
     * Display the specified material.
     */
    public function show($id)
    {
        $materi = Materi::with('subbab.bab.buku')->findOrFail($id);

        // Get previous material in the same sub-chapter
        $prev = Materi::where('id_subbab', $materi->id_subbab)
            ->where('id_materi', '<', $materi->id_materi)
            ->orderBy('id_materi', 'desc')
            ->first();

        // Get next material in the same sub-chapter
        $next = Materi::where('id_subbab', $materi->id_subbab)
            ->where('id_materi', '>', $materi->id_materi)
            ->orderBy('id_materi', 'asc')
            ->first();

        return view('user.materi', compact('materi', 'prev', 'next'));
    }
}
