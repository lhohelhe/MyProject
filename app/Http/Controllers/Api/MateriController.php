<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        $id_subbab = $request->query('id_subbab');
        
        $materi = Materi::where('id_subbab', $id_subbab)
                         ->with('subab')
                         ->get();

        return response()->json($materi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_subbab' => 'required',
            'judul_materi' => 'required',
            'isi' => 'required'
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
            'judul_materi' => 'required',
            'isi' => 'required'
        ]);

        $materi = Materi::findOrFail($id);

        $data = $request->all();

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
