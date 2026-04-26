<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;

class BukuController extends Controller
{
    /**
     * Menampilkan detail buku dengan relasi bab, subbab, dan materi
     */
    public function show($id)
    {
        $buku = Buku::with('bab.subbab.materi')->findOrFail($id);
        $progress = 0; // Untuk sementara progress = 0

        return view('user.buku', compact('buku', 'progress'));
    }
}
