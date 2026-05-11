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
    public function index()
    {
        $simulasi = Simulasi::with('buku')
                            ->where('status', 'aktif')
                            ->latest('id_simulasi')
                            ->paginate(10);

        $cooldowns = HasilSimulasi::where('user_id', auth()->id())
                        ->whereDate('created_at', today())
                        ->pluck('id_simulasi')
                        ->toArray();

        return view('user.simulasi.index', compact('simulasi', 'cooldowns'));
    }

    public function show($id)
    {
        $simulasi = Simulasi::with('buku')->findOrFail($id);

        $hasilTerakhir = HasilSimulasi::where('id_simulasi', $id)
                            ->where('user_id', auth()->id())
                            ->latest()
                            ->first();

        $cooldown = HasilSimulasi::where('id_simulasi', $id)
                        ->where('user_id', auth()->id())
                        ->whereDate('created_at', today())
                        ->exists();

        return view('user.simulasi.show', compact('simulasi', 'hasilTerakhir', 'cooldown'));
    }

    public function start($id)
    {
        $simulasi = Simulasi::findOrFail($id);

        $cooldown = HasilSimulasi::where('id_simulasi', $id)
                        ->where('user_id', auth()->id())
                        ->whereDate('created_at', today())
                        ->exists();

        if ($cooldown) {
            return redirect()->route('user.simulasi.show', $id)
                             ->with('error', 'Kamu sudah mengerjakan simulasi ini hari ini.');
        }

        $soal = SoalSimulasi::where('id_simulasi', $id)->get();

        session([
            'simulasi_id'  => $id,
            'waktu_mulai'  => Carbon::now(),
            'durasi_menit' => $simulasi->durasi_menit,
        ]);

        $durasi = $simulasi->durasi_menit * 60;

        return view('user.simulasi.exam', compact('simulasi', 'soal', 'durasi'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'id_simulasi' => 'required|exists:simulasi,id_simulasi',
            'jawaban'     => 'nullable|array',
        ]);

        $user        = Auth::user();
        $id_simulasi = $request->id_simulasi;
        $soal        = SoalSimulasi::where('id_simulasi', $id_simulasi)->get();
        $totalSoal   = $soal->count();

        $jumlahBenar  = 0;
        $jumlahSalah  = 0;
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

        $skor  = $totalSoal > 0 ? ($jumlahBenar / $totalSoal) * 100 : 0;
        $lulus = $skor >= 70;

        $hasil = HasilSimulasi::create([
            'id_simulasi'   => $id_simulasi,
            'user_id'       => $user->id,
            'skor'          => $skor,
            'jumlah_benar'  => $jumlahBenar,
            'jumlah_salah'  => $jumlahSalah,
            'jumlah_kosong' => $jumlahKosong,
            'list_jawaban'  => $request->jawaban,
            'lulus'         => $lulus,
            'waktu_mulai'   => session('waktu_mulai') ?? Carbon::now(),
            'waktu_selesai' => Carbon::now(),
        ]);

        session()->forget(['simulasi_id', 'waktu_mulai', 'durasi_menit']);

        return redirect()->route('user.simulasi.result', $hasil->id_hasil)
                         ->with('success', 'Jawaban berhasil disimpan!');
    }

    public function result($id_hasil)
    {
        $hasil = HasilSimulasi::with(['simulasi.soalSimulasi'])
                              ->findOrFail($id_hasil);

        if ($hasil->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $soal = $hasil->simulasi->soalSimulasi;
        $jawabanUser = $hasil->list_jawaban ?? [];

        $soal->transform(function ($s) use ($jawabanUser) {
            $s->user_answer = $jawabanUser[$s->id_soal] ?? null;
            $s->user_answer_correct = $s->user_answer == $s->kunci_jawaban;
            return $s;
        });

        return view('user.simulasi.result', compact('hasil', 'soal'));
    }
}