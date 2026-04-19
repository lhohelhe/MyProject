<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Simulasi;
use App\Models\Buku;
use Illuminate\Http\Request;

class SimulasiController extends Controller
{
    /**
     * Tampilkan daftar simulasi untuk Admin
     */
    public function index()
    {
        $simulasi = Simulasi::with('buku')
                            ->latest('id_simulasi')
                            ->paginate(10);

        return view('admin.simulasi.index', compact('simulasi'));
    }

    /**
     * Form tambah simulasi
     */
    public function create()
    {
        $buku = Buku::all();
        return view('admin.simulasi.create', compact('buku'));
    }

    /**
     * Simpan simulasi baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_simulasi' => 'required|string|max:255',
            'id_buku' => 'required|exists:buku,id_buku',
            'durasi_menit' => 'required|integer|min:1|max:180',
            'jumlah_soal' => 'required|integer|min:5|max:100',
        ]);

        $data = $request->only(['judul_simulasi', 'id_buku', 'durasi_menit', 'jumlah_soal']);
        $data['status'] = 'aktif';

        Simulasi::create($data);

        return redirect()->route('simulasi.index')
                         ->with('success', 'Simulasi berhasil ditambahkan!');
    }

    /**
     * Form edit simulasi
     */
    public function edit($id)
    {
        $simulasi = Simulasi::findOrFail($id);
        $buku = Buku::all();

        return view('admin.simulasi.edit', compact('simulasi', 'buku'));
    }

    /**
     * Update data simulasi
     */
    public function update(Request $request, $id)
    {
        $simulasi = Simulasi::findOrFail($id);

        $request->validate([
            'judul_simulasi' => 'required|string|max:255',
            'id_buku' => 'required|exists:buku,id_buku',
            'durasi_menit' => 'required|integer|min:1|max:180',
            'jumlah_soal' => 'required|integer|min:5|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->only(['judul_simulasi', 'id_buku', 'durasi_menit', 'jumlah_soal', 'status']);

        $simulasi->update($data);

        return redirect()->route('simulasi.index')
                         ->with('success', 'Simulasi berhasil diupdate!');
    }

    /**
     * Hapus simulasi
     */
    public function destroy($id)
    {
        $simulasi = Simulasi::findOrFail($id);
        $simulasi->delete();

        return redirect()->route('simulasi.index')
                         ->with('success', 'Simulasi berhasil dihapus!');
    }
}
