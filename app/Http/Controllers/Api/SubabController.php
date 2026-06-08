<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subab;
use Illuminate\Http\Request;

class SubabController extends Controller
{
    public function index()
    {
        $subab = Subab::with('bab')->latest('id_subbab')->paginate(10);

        return response()->json($subab);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bab'       => 'required|exists:bab,id_bab',
            'nomor_subbab' => 'required',
            'judul_subbab' => 'required|string|max:255',
        ]);

        $subab = Subab::create($request->all());

        return response()->json($subab, 201);
    }

    public function show($id)
    {
        $subab = Subab::with('bab', 'materi')->findOrFail($id);

        return response()->json($subab);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_subbab' => 'required|string|max:255',
        ]);

        $subab = Subab::findOrFail($id);
        $subab->update($request->all());

        return response()->json($subab);
    }

    public function destroy($id)
    {
        $subab = Subab::findOrFail($id);
        $subab->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
