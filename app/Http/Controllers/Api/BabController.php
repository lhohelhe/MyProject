<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bab;
use Illuminate\Http\Request;

class BabController extends Controller
{
    public function index()
    {
        $bab = Bab::with('buku')->latest('id_bab')->paginate(10);

        return response()->json($bab);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku'   => 'required|exists:buku,id_buku',
            'nomor_bab' => 'required',
            'judul_bab' => 'required|string|max:255',
        ]);

        $bab = Bab::create($request->all());

        return response()->json($bab, 201);
    }

    public function show($id)
    {
        $bab = Bab::with('buku', 'subab')->findOrFail($id);

        return response()->json($bab);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_bab' => 'required|string|max:255',
        ]);

        $bab = Bab::findOrFail($id);
        $bab->update($request->all());

        return response()->json($bab);
    }

    public function destroy($id)
    {
        $bab = Bab::findOrFail($id);
        $bab->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
