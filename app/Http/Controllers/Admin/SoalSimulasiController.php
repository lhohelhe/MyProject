<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SoalSimulasi;
use App\Models\Simulasi;
use Illuminate\Http\Request;

class SoalSimulasiController extends Controller
{
    public function index($id)
    {
        $simulasi = Simulasi::findOrFail($id);
        $soal = SoalSimulasi::where('id_simulasi', $id)
                            ->latest('id_soal')
                            ->paginate(10);

        return view('admin.soal-simulasi.index', compact('simulasi', 'soal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_simulasi' => 'required|exists:simulasi,id_simulasi',
            'pertanyaan' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'kunci_jawaban' => 'required|in:a,b,c,d',
            'pembahasan' => 'nullable|string',
        ]);

        $data = $request->only([
            'id_simulasi',
            'pertanyaan',
            'opsi_a',
            'opsi_b',
            'opsi_c',
            'opsi_d',
            'kunci_jawaban',
            'pembahasan'
        ]);

        SoalSimulasi::create($data);

        return redirect()->route('soal-simulasi.index', $request->id_simulasi)
                         ->with('success', 'Soal berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $soal = SoalSimulasi::findOrFail($id);

        $request->validate([
            'pertanyaan' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'kunci_jawaban' => 'required|in:a,b,c,d',
            'pembahasan' => 'nullable|string',
        ]);

        $data = $request->only([
            'pertanyaan',
            'opsi_a',
            'opsi_b',
            'opsi_c',
            'opsi_d',
            'kunci_jawaban',
            'pembahasan'
        ]);

        $soal->update($data);

        return redirect()->route('soal-simulasi.index', $soal->id_simulasi)
                         ->with('success', 'Soal berhasil diupdate!');
    }

    public function destroy($id)
    {
        $soal = SoalSimulasi::findOrFail($id);
        $id_simulasi = $soal->id_simulasi;

        $soal->delete();

        return redirect()->route('soal-simulasi.index', $id_simulasi)
                         ->with('success', 'Soal berhasil dihapus!');
    }
}
