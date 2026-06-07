<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriMapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->latest('id_buku')->paginate(10);

        return response()->json($buku);
    }

    public function kategori()
    {
        return response()->json(KategoriMapel::all());
    }


    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required',
            'id_kategori' => 'required',
            'semester' => 'required',
            'kelas' => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('buku', 'public');
            $data['gambar'] = $gambar;
        }

        $buku = Buku::create($data);

        return response()->json($buku, 201);
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        return response()->json($buku);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_buku' => 'required',
            'id_kategori' => 'required',
            'semester' => 'required',
            'kelas' => 'required',
        ]);

        $buku = Buku::findOrFail($id);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($buku->gambar) {
                Storage::disk('public')->delete($buku->gambar);
            }
            $gambar = $request->file('gambar')->store('buku', 'public');
            $data['gambar'] = $gambar;
        }

        $buku->update($data);

        return response()->json($buku);
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->gambar) {
            Storage::disk('public')->delete($buku->gambar);
        }

        $buku->delete();

        return response()->json(['message' => 'Deleted']);
    }
}