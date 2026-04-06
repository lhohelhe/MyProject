<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriMapel;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        // ambil semua kategori untuk ditampilkan di sidebar
        $kategori = KategoriMapel::all();

        // ambil semua buku, bisa difilter berdasarkan kategori
        $query = Buku::with('kategori')->latest('id_buku');

        // filter berdasarkan kategori kalau ada di query string
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('id_kategori', $request->kategori);
        }

        $buku = $query->get();

        return view('user.katalog', compact('buku', 'kategori'));
    }
}
