<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bab;

class BabController extends Controller
{
    public function updateTitle(Request $request, $id)
    {
        $request->validate([
            'judul_bab' => 'required|string|max:255'
        ]);

        $bab = Bab::findOrFail($id);
        $bab->update([
            'judul_bab' => $request->judul_bab
        ]);

        return response()->json(['status' => 'success', 'message' => 'Judul bab berhasil diperbarui']);
    }

    public function index(Request $request)
    {
        $id_buku = $request->id_buku;

        // Jika id_buku ada → tampilkan bab milik buku itu (dari shortcut Data Buku)
        // Jika tidak → tampilkan SEMUA bab lintas buku (dari menu sidebar)
        if ($id_buku) {
            $buku = \App\Models\Buku::findOrFail($id_buku);
            $bab  = Bab::with(['subab.materi'])
                        ->where('id_buku', $id_buku)
                        ->orderBy('nomor_bab')
                        ->get();
        } else {
            $buku = null;
            $bab  = Bab::with(['buku', 'subab.materi'])
                        ->orderBy('id_buku')
                        ->orderBy('nomor_bab')
                        ->get();
        }

        return view('admin.bab.index', compact('bab', 'id_buku', 'buku'));
    }

    public function create(Request $request)
    {
        $id_buku = $request->id_buku;

        return view('admin.bab.create',compact('id_buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku'   => 'required|exists:buku,id_buku',
            'nomor_bab' => 'required|integer|min:1',
            'judul_bab' => 'required|string|max:255',
        ]);

        Bab::create([
            'id_buku' => $request->id_buku,
            'nomor_bab' => $request->nomor_bab,
            'judul_bab' => $request->judul_bab
        ]);

        return redirect()->route('bab.index',['id_buku'=>$request->id_buku, 'active_menu' => $request->active_menu]);
    }

    public function edit($id)
    {
        $bab = Bab::findOrFail($id);

        return view('admin.bab.edit',compact('bab'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'nomor_bab'=>'required',
            'judul_bab'=>'required'
        ]);

        $bab = Bab::findOrFail($id);

        $bab->update([
            'nomor_bab'=>$request->nomor_bab,
            'judul_bab'=>$request->judul_bab
        ]);

        return redirect()->route('bab.index',['id_buku'=>$bab->id_buku, 'active_menu' => $request->active_menu]);
    }

    public function destroy(Request $request, $id)
    {
        $bab = Bab::findOrFail($id);

        $id_buku = $bab->id_buku;

        \DB::transaction(function () use ($bab) {
            $subbabIds = \DB::table('subbab')->where('id_bab', $bab->id_bab)->pluck('id_subbab');
            \DB::table('materi')->whereIn('id_subbab', $subbabIds)->delete();
            \DB::table('subbab')->where('id_bab', $bab->id_bab)->delete();
            $bab->delete();
        });

        return redirect()->route('bab.index',['id_buku'=>$id_buku, 'active_menu' => $request->active_menu]);
    }

    public function byBuku($id_buku)
    {
        $bab = Bab::where('id_buku', $id_buku)->orderBy('nomor_bab')->get();
        return response()->json($bab);
    }
}