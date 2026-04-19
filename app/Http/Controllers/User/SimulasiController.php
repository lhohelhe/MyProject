<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Simulasi;
use App\Models\SoalSimulasi;
use App\Models\HasilSimulasi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SimulasiController extends Controller
{
    /**
     * Tampilkan daftar semua simulasi aktif
     */
    public function index()
    {
        $simulasi = Simulasi::where('status', 'aktif')
                            ->with('buku')
                            ->latest('id_simulasi')
                            ->paginate(10);

        return view('user.simulasi.index', compact('simulasi'));
    }

    /**
     * Tampilkan detail simulasi + tombol mulai
     */
    public function show($id)
    {
        $simulasi = Simulasi::with('buku')->findOrFail($id);
        $user = Auth::user();

        // Cek apakah user sudah pernah mengerjakan simulasi ini
        $hasilTerakhir = HasilSimulasi::where('id_simulasi', $id)
                                      ->where('user_id', $user->id)
                                      ->latest('created_at')
                                      ->first();

        // Cek cooldown: 1x per hari
        $dapatDikerjakan = true;
        $waktuTerakses = null;

        if ($hasilTerakhir) {
            $selisihJam = Carbon::now()->diffInHours($hasilTerakhir->created_at);
            if ($selisihJam < 24) {
                $dapatDikerjakan = false;
                $waktuTerakses = $hasilTerakhir->created_at;
            }
        }

        return view('user.simulasi.show', compact('simulasi', 'hasilTerakhir', 'dapatDikerjakan', 'waktuTerakses'));
    }

    /**
     * Mulai mengerjakan simulasi - set session + timer
     */
    public function start($id)
    {
        $simulasi = Simulasi::findOrFail($id);
        $user = Auth::user();

        // Cek cooldown
        $hasilTerakhir = HasilSimulasi::where('id_simulasi', $id)
                                      ->where('user_id', $user->id)
                                      ->latest('created_at')
                                      ->first();

        if ($hasilTerakhir) {
            $selisihJam = Carbon::now()->diffInHours($hasilTerakhir->created_at);
            if ($selisihJam < 24) {
                return redirect()->route('user.simulasi.show', $id)
                                 ->with('error', 'Anda sudah mengerjakan simulasi ini dalam 24 jam terakhir.');
            }
        }

        // Ambil semua soal untuk simulasi ini
        $soal = SoalSimulasi::where('id_simulasi', $id)->get();

        // Simpan ke session
        session([
            'simulasi_id' => $id,
            'waktu_mulai' => Carbon::now(),
            'durasi_menit' => $simulasi->durasi_menit,
        ]);

        return view('user.simulasi.exam', compact('simulasi', 'soal'));
    }

    /**
     * Proses jawaban user, hitung skor, simpan hasil
     */
    public function submit(Request $request)
    {
        $request->validate([
            'id_simulasi' => 'required|exists:simulasi,id_simulasi',
            'jawaban' => 'nullable|array',
        ]);

        $user = Auth::user();
        $id_simulasi = $request->id_simulasi;

        // Ambil semua soal
        $soal = SoalSimulasi::where('id_simulasi', $id_simulasi)->get();
        $totalSoal = $soal->count();

        // Hitung jawaban
        $jumlahBenar = 0;
        $jumlahSalah = 0;
        $jumlahKosong = 0;

        foreach ($soal as $s) {
            $jawaban = $request->jawaban[$s->id_soal] ?? null;

            if ($jawaban === null || $jawaban === '') {
                $jumlahKosong++;
            } elseif ($jawaban == $s->kunci_jawaban) {
                $jumlahBenar++;
            } else {
                $jumlahSalah++;
            }
        }

        // Hitung skor (persentase)
        $skor = ($totalSoal > 0) ? ($jumlahBenar / $totalSoal) * 100 : 0;

        // Tentukan lulus/tidak (skor >= 70)
        $lulus = $skor >= 70;

        // Simpan hasil
        $hasil = HasilSimulasi::create([
            'id_simulasi'   => $id_simulasi,
            'user_id'       => $user->id,
            'skor'          => $skor,
            'jumlah_benar'  => $jumlahBenar,
            'jumlah_salah'  => $jumlahSalah,
            'jumlah_kosong' => $jumlahKosong,
            'lulus'         => $lulus,
            'waktu_mulai'   => session('waktu_mulai') ?? Carbon::now(),
            'waktu_selesai' => Carbon::now(),
        ]);

        // Clear session
        session()->forget(['simulasi_id', 'waktu_mulai', 'durasi_menit']);

        return redirect()->route('user.simulasi.result', $hasil->id_hasil)
                         ->with('success', 'Jawaban berhasil disimpan!');
    }

    /**
     * Tampilkan hasil + pembahasan
     */
    public function result($id_hasil)
    {
        $hasil = HasilSimulasi::with(['simulasi.soalSimulasi', 'user'])
                              ->findOrFail($id_hasil);

        // Pastikan user hanya bisa lihat hasil miliknya sendiri
        if ($hasil->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $soal = $hasil->simulasi->soalSimulasi;

        return view('user.simulasi.result', compact('hasil', 'soal'));
    }
}
