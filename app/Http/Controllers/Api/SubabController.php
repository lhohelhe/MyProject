<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subab;
use Illuminate\Http\Request;

class SubabController extends Controller
{
    public function index(Request $request)
    {
        $id_bab = $request->query('id_bab');
        
        $subab = Subab::where('id_bab', $id_bab)
                       ->with('bab')
                       ->orderBy('nomor_subbab')
                       ->get();

        return response()->json($subab);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bab' => 'required',
            'nomor_subbab' => 'required',
            'judul_subbab' => 'required'
        ]);

        $subab = Subab::create([
            'id_bab' => $request->id_bab,
            'nomor_subbab' => $request->nomor_subbab,
            'judul_subbab' => $request->judul_subbab
        ]);

        return response()->json($subab, 201);
    }

    public function show($id)
    {
        $subab = Subab::with('bab')->findOrFail($id);

        return response()->json($subab);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_subbab' => 'required',
            'judul_subbab' => 'required'
        ]);

        $subab = Subab::findOrFail($id);

        $subab->update([
            'nomor_subbab' => $request->nomor_subbab,
            'judul_subbab' => $request->judul_subbab
        ]);

        return response()->json($subab);
    }

    public function destroy($id)
    {
        $subab = Subab::findOrFail($id);
        $subab->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
