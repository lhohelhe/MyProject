<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bab;

class BabController extends Controller
{
    public function index($id_buku)
    {
        $bab = Bab::where('id_buku', $id_buku)
                ->orderBy('nomor_bab')
                ->get();

        return view('admin.bab.index', compact('bab','id_buku'));
    }

    public function store(Request $request)
    {
        Bab::create([
            'id_buku' => $request->id_buku,
            'nomor_bab' => $request->nomor_bab,
            'judul_bab' => $request->judul_bab
        ]);

        return back();
    }

    public function update(Request $request, $id)
    {
        $bab = Bab::findOrFail($id);

        $bab->update([
            'nomor_bab' => $request->nomor_bab,
            'judul_bab' => $request->judul_bab
        ]);

        return back();
    }

    public function destroy($id)
    {
        Bab::destroy($id);

        return back();
    }
}