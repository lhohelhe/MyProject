<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index()
    {
        $materi = Materi::with('subab')->latest('id_materi')->paginate(10);

        return response()->json($materi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_subbab'    => 'required|exists:subbab,id_subbab',
            'judul_materi' => 'required|string|max:255',
            'isi'          => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('materi', 'public');
        }

        $materi = Materi::create($data);

        return response()->json($materi, 201);
    }

    public function show($id)
    {
        $materi = Materi::with('subab')->findOrFail($id);

        return response()->json($materi);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_materi' => 'required|string|max:255',
            'isi'          => 'required|string',
        ]);

        $materi = Materi::findOrFail($id);
        $data   = $request->all();

        if ($request->hasFile('gambar')) {
            if ($materi->gambar) {
                Storage::disk('public')->delete($materi->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('materi', 'public');
        }

        $materi->update($data);

        return response()->json($materi);
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);

        if ($materi->gambar) {
            Storage::disk('public')->delete($materi->gambar);
        }

        $materi->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
