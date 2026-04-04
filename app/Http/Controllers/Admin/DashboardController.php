<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;
use App\Models\KategoriMapel;
use App\Models\Bab;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        // hitung total data untuk kartu statistik
        $total_buku = Buku::count();
        $total_user = User::count();
        $total_kategori = KategoriMapel::count();
        $total_bab = Bab::count();

        // ambil 5 buku terbaru untuk ditampilkan
        $buku_terbaru = Buku::with('kategori')->latest('id_buku')->take(5)->get();

        return view('admin.dashboard', compact(
            'total_buku',
            'total_user',
            'total_kategori',
            'total_bab',
            'buku_terbaru'
        ));
    }
}
