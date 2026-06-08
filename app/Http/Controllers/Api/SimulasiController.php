<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Simulasi;
use App\Models\SoalSimulasi;
use Illuminate\Http\Request;

class SimulasiController extends Controller
{
    public function index()
    {
        $simulasi = Simulasi::with('buku')->latest('id_simulasi')->paginate(10);

        return response()->json($simulasi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku'        => 'required|exists:buku,id_buku',
            'judul_simulasi' => 'required|string|max:255',
            'durasi_menit'   => 'required|integer|min:1',
            'jumlah_soal'    => 'required|integer|min:1',
        ]);

        $simulasi = Simulasi::create($request->all());

        return response()->json($simulasi, 201);
    }

    public function show($id)
    {
        $simulasi = Simulasi::with('buku', 'soalSimulasi')->findOrFail($id);

        return response()->json($simulasi);
    }

    public function destroy($id)
    {
        $simulasi = Simulasi::findOrFail($id);
        $simulasi->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function soal($id)
    {
        Simulasi::findOrFail($id);
        $soal = SoalSimulasi::where('id_simulasi', $id)->get();

        return response()->json($soal);
    }

    public function storeSoal(Request $request, $id)
    {
        $request->validate([
            'pertanyaan'    => 'required|string',
            'opsi_a'        => 'required|string',
            'opsi_b'        => 'required|string',
            'opsi_c'        => 'required|string',
            'opsi_d'        => 'required|string',
            'kunci_jawaban' => 'required|in:a,b,c,d',
        ]);

        Simulasi::findOrFail($id);

        $soal = SoalSimulasi::create(array_merge($request->all(), ['id_simulasi' => $id]));

        return response()->json($soal, 201);
    }
}
