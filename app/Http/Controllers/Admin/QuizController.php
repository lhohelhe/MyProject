<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\SoalQuiz;
use App\Models\Bab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuizController extends Controller
{
    /**
     * Tampilkan daftar quiz untuk Admin
     */
    public function index()
    {
        $quiz = Quiz::with('bab.buku')
                    ->latest('id_quiz')
                    ->paginate(10);

        return view('admin.quiz.index', compact('quiz'));
    }

    /**
     * Generate quiz dengan AI menggunakan Groq API
     */
    public function generateAi(Request $request)
    {
        $request->validate([
            'id_bab' => 'required|exists:bab,id_bab',
        ]);

        $bab = Bab::with('subab.materi')->findOrFail($request->id_bab);

        // Kumpulkan semua konten materi dari bab ini
        $materiTexts = [];
        foreach ($bab->subab as $subab) {
            foreach ($subab->materi as $materi) {
                $materiTexts[] = strip_tags($materi->isi);
            }
        }

        $materiContent = trim(implode("\n\n", $materiTexts));

        if (empty($materiContent)) {
            return response()->json(['error' => 'Tidak ada materi ditemukan pada bab ini untuk dijadikan quiz.'], 400);
        }

        $apiKey = env('XAI_API_KEY');

        // Panggil API Groq
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])
        ->withOptions([
            'verify' => false,
        ])
        ->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Buat 10 soal pilihan ganda dari materi berikut. Return JSON saja: {"soal":[{"pertanyaan":"...","opsi_a":"...","opsi_b":"...","opsi_c":"...","opsi_d":"...","kunci_jawaban":"A","difficulty":"easy","pembahasan":"..."}]}',
                ],
                [
                    'role' => 'user',
                    'content' => $materiContent,
                ],
            ],
            'response_format' => ['type' => 'json_object']
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Gagal menghubungi API Groq untuk generate quiz.'], 500);
        }

        $result = $response->json();
        $rawJson = $result['choices'][0]['message']['content'] ?? null;

        if (!$rawJson) {
            return response()->json(['error' => 'Respons dari AI Groq kosong.'], 500);
        }

        $quizData = json_decode($rawJson, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($quizData['soal'])) {
            return response()->json(['error' => 'Format respons dari AI tidak valid.'], 500);
        }

        // Mulai transaksi database untuk menyimpan quiz & soal_quiz
        $quiz = \DB::transaction(function () use ($bab, $quizData) {
            $quiz = Quiz::create([
                'id_bab' => $bab->id_bab,
                'judul_quiz' => "Quiz Bab " . $bab->nomor_bab,
                'difficulty' => 'easy', // Default level
            ]);

            foreach ($quizData['soal'] as $s) {
                // Gunakan model baru untuk bypass fillability opsi_e jika ada di DB, atau simpan ke opsi_a sampai d
                $soal = new SoalQuiz();
                $soal->id_quiz = $quiz->id_quiz;
                $soal->pertanyaan = $s['pertanyaan'] ?? '';
                $soal->opsi_a = $s['opsi_a'] ?? '';
                $soal->opsi_b = $s['opsi_b'] ?? '';
                $soal->opsi_c = $s['opsi_c'] ?? '';
                $soal->opsi_d = $s['opsi_d'] ?? '';
                if (isset($s['opsi_e'])) {
                    $soal->opsi_e = $s['opsi_e'];
                }
                $soal->kunci_jawaban = strtolower($s['kunci_jawaban'] ?? 'a');
                $soal->difficulty = strtolower($s['difficulty'] ?? 'easy');
                $soal->pembahasan = $s['pembahasan'] ?? null;
                $soal->save();
            }

            return $quiz;
        });

        return response()->json([
            'success' => true,
            'message' => 'Quiz berhasil digenerate!',
            'quiz_id' => $quiz->id_quiz,
        ]);
    }
}
