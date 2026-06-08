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
            'isi'          => $request->isi,
            'gambar'       => $gambar,
            'id_subbab'    => $request->id_subbab
        ]);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success']);
        }

        return redirect()->route('materi.index')->with('success', 'Materi berhasil ditambahkan!');
    }

    // New endpoint to extract text from uploaded PDF
    public function extractPdf(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf'
        ]);

        $pdf = $request->file('pdf');
        $parser = new \Smalot\PdfParser\Parser();
        $pdfDocument = $parser->parseFile($pdf->getPathname());
        $text = $pdfDocument->getText();

        return response()->json(['text' => $text]);
    }

    public function getMateri($id)
    {
        $materi = Materi::where('id_subbab', $id)->first();
        return response()->json($materi);
    }

    public function edit($id)
    {
        $materi = Materi::findOrFail($id);

        return view('admin.materi.edit', compact('materi'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_materi' => 'required|string|max:255',
            'isi'          => 'required|string',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

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

        return redirect()->route('materi.index')->with('success', 'Materi berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        $materi->delete();
        return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus!');
    }


    /**
    * Display a paginated list of materi with related subbab, bab, and buku.
    */
    public function index()
    {
        $materi = Materi::with('subab.bab.buku')->paginate(15);
        return view('admin.materi.index', compact('materi'));
    }


}