<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->latest('id_buku')->paginate(10);

        return response()->json($buku);
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
            $data['gambar'] = $request->file('gambar')->store('buku', 'public');
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
        $buku = Buku::findOrFail($id);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($buku->gambar) {
                Storage::disk('public')->delete($buku->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('buku', 'public');
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