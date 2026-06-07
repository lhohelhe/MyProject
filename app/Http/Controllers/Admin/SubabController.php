<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subab;

class SubabController extends Controller
{
    public function destroyWithMateri($id)
    {
        $subab = Subab::findOrFail($id);
        
        \DB::transaction(function() use ($subab) {
            // Delete associated materi
            \DB::table('materi')->where('id_subbab', $subab->id_subbab)->delete();
            // Delete subbab
            $subab->delete();
        });

        return response()->json(['status' => 'success', 'message' => 'Subbab dan materinya berhasil dihapus']);
    }

    public function create(Request $request)
    {
        $id_bab = $request->id_bab;

        return view('admin.subab.create', compact('id_bab'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_bab' => 'required',
            'nomor_subbab' => 'required',
            'judul_subbab' => 'required'
        ]);

        Subab::create([
            'id_bab' => $request->id_bab,
            'nomor_subbab' => $request->nomor_subbab,
            'judul_subbab' => $request->judul_subbab
        ]);

        return redirect()->back();
    }


    public function edit($id)
    {
        $subab = Subab::findOrFail($id);

        return view('admin.subab.edit', compact('subab'));
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

        return redirect()->back();
    }


    public function destroy($id)
    {
        $subab = Subab::findOrFail($id);

        $subab->delete();

        return redirect()->back();
    }

    public function byBab($id_bab)
    {
        $subab = Subab::where('id_bab', $id_bab)->orderBy('nomor_subbab')->get();
        return response()->json($subab);
    }
}