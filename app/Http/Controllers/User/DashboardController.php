<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriMapel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // data untuk halaman selamat datang user
        $user = Auth::user();
        $total_buku = Buku::count();
        $kategori = KategoriMapel::all();
        $buku_terbaru = Buku::with('kategori')->latest('id_buku')->take(6)->get();

        return view('user.dashboard', compact(
            'user',
            'total_buku',
            'kategori',
            'buku_terbaru'
        ));
    }
}
