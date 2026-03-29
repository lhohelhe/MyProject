<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;

class MateriController extends Controller
{

    public function create(Request $request)
    {
        $id_subbab = $request->id_subbab;

        return view('admin.materi.create', compact('id_subbab'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'judul_materi' => 'required',
            'isi' => 'required',
            'id_subbab' => 'required'
        ]);

        $gambar = null;

        if($request->hasFile('gambar'))
        {
            $gambar = $request->file('gambar')->store('materi','public');
        }

        Materi::create([
            'judul_materi' => $request->judul_materi,
            'isi' => $request->isi,
            'gambar' => $gambar,
            'id_subbab' => $request->id_subbab
        ]);

        return redirect()->back();
    }

    public function edit($id)
    {
        $materi = Materi::findOrFail($id);

        return view('admin.materi.edit', compact('materi'));
    }


    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);

        $gambar = $materi->gambar;

        if($request->hasFile('gambar'))
        {
            $gambar = $request->file('gambar')->store('materi','public');
        }

        $materi->update([
            'judul_materi' => $request->judul_materi,
            'isi' => $request->isi,
            'gambar' => $gambar
        ]);

        return redirect()->back();
    }


    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);

        $materi->delete();

        return redirect()->back();
    }


    public function getMateri($id)
    {
        $materi = Materi::where('id_subbab',$id)->first();

        return response()->json($materi);
    }

}