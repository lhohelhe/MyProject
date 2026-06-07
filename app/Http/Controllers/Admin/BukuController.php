<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriMapel;
use App\Models\Bab;
use App\Models\Subab;
use App\Models\Materi;
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
            'penulis' => 'nullable|string',
            'penerbit' => 'nullable|string',
            'isbn' => 'nullable|string',
            'edisi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['judul_buku', 'id_kategori', 'semester', 'kelas', 'deskripsi', 'penulis', 'penerbit', 'isbn', 'edisi']);

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
            'penulis' => 'nullable|string',
            'penerbit' => 'nullable|string',
            'isbn' => 'nullable|string',
            'edisi' => 'nullable|string',
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

    public function konten($id)
    {
        $buku = Buku::with(['bab.subab.materi'])->findOrFail($id);
        $babs = $buku->bab;
        return view('admin.buku.konten', compact('buku', 'babs'));
    }

    public function parsePdf(Request $request, $id)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:50000',
        ]);

        $buku = Buku::findOrFail($id);

        // Delete existing Bab/Subbab
        foreach ($buku->bab as $bab) {
            foreach ($bab->subab as $subab) {
                $subab->materi()->delete();
                $subab->delete();
            }
            $bab->delete();
        }

        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($request->file('pdf')->path());
        $text = $pdf->getText();

        $lines = explode("\n", $text);

        $currentBab = null;
        $currentSubab = null;
        $currentMateriText = "";

        $createdData = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            if (preg_match('/^BAB\s+([IVX\d]+)(?:\s+(.*))?$/i', $line, $matches) || preg_match('/^BAB\s+([IVX\d]+)\.?$/i', $line, $matches)) {
                if ($currentSubab && !empty(trim($currentMateriText))) {
                    Materi::create([
                        'id_subbab' => $currentSubab->id_subbab,
                        'judul_materi' => $currentSubab->judul_subbab,
                        'isi' => nl2br(trim($currentMateriText))
                    ]);
                    $currentMateriText = "";
                }

                $nomorBab = $matches[1];
                $judulBab = isset($matches[2]) && !empty(trim($matches[2])) ? trim($matches[2]) : "Bab " . $nomorBab;

                $currentBab = Bab::create([
                    'id_buku' => $buku->id_buku,
                    'nomor_bab' => $nomorBab,
                    'judul_bab' => $judulBab
                ]);

                $createdData[] = ['type' => 'bab', 'title' => $judulBab];
                $currentSubab = null;
            } 
            elseif (preg_match('/^([A-Z]\.|\d+\.\d+)\s+(.+)$/i', $line, $matches) && $currentBab) {
                if ($currentSubab && !empty(trim($currentMateriText))) {
                    Materi::create([
                        'id_subbab' => $currentSubab->id_subbab,
                        'judul_materi' => $currentSubab->judul_subbab,
                        'isi' => nl2br(trim($currentMateriText))
                    ]);
                    $currentMateriText = "";
                }

                $nomorSubbab = trim($matches[1], '.');
                $judulSubbab = trim($matches[2]);

                $currentSubab = Subab::create([
                    'id_bab' => $currentBab->id_bab,
                    'nomor_subbab' => $nomorSubbab,
                    'judul_subbab' => $judulSubbab
                ]);

                $createdData[] = ['type' => 'subbab', 'title' => $judulSubbab];
            } else {
                if ($currentSubab) {
                    $currentMateriText .= $line . "\n";
                }
            }
        }

        if ($currentSubab && !empty(trim($currentMateriText))) {
            Materi::create([
                'id_subbab' => $currentSubab->id_subbab,
                'judul_materi' => $currentSubab->judul_subbab,
                'isi' => nl2br(trim($currentMateriText))
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'PDF berhasil diparse dan diekstrak',
            'data' => $createdData
        ]);
    }
}