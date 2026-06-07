<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bab;
use Illuminate\Http\Request;

class BabController extends Controller
{
    public function index(Request $request)
    {
        $id_buku = $request->query('id_buku');
        
        $bab = Bab::where('id_buku', $id_buku)
                    ->with('subab')
                    ->orderBy('nomor_bab')
                    ->get();

        return response()->json($bab);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required',
            'nomor_bab' => 'required',
            'judul_bab' => 'required'
        ]);

        $bab = Bab::create([
            'id_buku' => $request->id_buku,
            'nomor_bab' => $request->nomor_bab,
            'judul_bab' => $request->judul_bab
        ]);

        return response()->json($bab, 201);
    }

    public function show($id)
    {
        $bab = Bab::with('subab')->findOrFail($id);

        return response()->json($bab);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_bab' => 'required',
            'judul_bab' => 'required'
        ]);

        $bab = Bab::findOrFail($id);

        $bab->update([
            'nomor_bab' => $request->nomor_bab,
            'judul_bab' => $request->judul_bab
        ]);

        return response()->json($bab);
    }

    public function destroy($id)
    {
        $bab = Bab::findOrFail($id);
        $bab->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
