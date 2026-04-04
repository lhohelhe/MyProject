<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriMapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')
                    ->latest('id_buku') 
                    ->paginate(10);

        return view('admin.buku.dashboard-buku', compact('buku'));
    }

    public function create()
    {
        $kategori = KategoriMapel::all();
        return view('admin.buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_mapel,id_kategori',
            'semester' => 'required|string',
            'kelas' => 'required|string',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['judul_buku', 'id_kategori', 'semester', 'kelas', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('buku', 'public');
        }

        Buku::create($data);

        return redirect()->route('dashboard-buku.index')
                         ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = KategoriMapel::all();

        return view('admin.buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_mapel,id_kategori',
            'semester' => 'required|string',
            'kelas' => 'required|string',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['judul_buku', 'id_kategori', 'semester', 'kelas', 'deskripsi']);

        if ($request->hasFile('gambar')) {// Hapus gambar lama kalau ada
            if ($buku->gambar) {
                Storage::disk('public')->delete($buku->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('buku', 'public');
        }

        $buku->update($data);

        return redirect()->route('dashboard-buku.index')
                         ->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->gambar) {
            Storage::disk('public')->delete($buku->gambar);
        }

        $buku->delete();

        return redirect()->route('dashboard-buku.index')
                         ->with('success', 'Buku berhasil dihapus!');
    }
}