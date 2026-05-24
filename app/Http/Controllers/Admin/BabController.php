<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bab;

class BabController extends Controller
{

    public function index(Request $request)
    {
        $id_buku = $request->id_buku;

        $bab = Bab::where('id_buku',$id_buku)
                    ->orderBy('nomor_bab')
                    ->get();

        return view('admin.bab.index',compact('bab','id_buku'));
    }

    public function create(Request $request)
    {
        $id_buku = $request->id_buku;

        return view('admin.bab.create',compact('id_buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required',
            'nomor_bab' => 'required',
            'judul_bab' => 'required'
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

        $bab->delete();

        return redirect()->route('bab.index',['id_buku'=>$id_buku, 'active_menu' => $request->active_menu]);
    }
}