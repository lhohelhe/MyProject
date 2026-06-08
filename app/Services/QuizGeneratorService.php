<?php

namespace App\Services;

use App\Models\Materi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class QuizGeneratorService
{
    private const GROQ_ENDPOINT = 'https://api.groq.com/openai/v1/chat/completions';
    private const GROQ_MODEL    = 'llama-3.3-70b-versatile';

    /**
     * Generate soal pilihan ganda dari satu materi.
     *
     * @param  Materi  $materi
     * @param  int     $jumlah  Jumlah soal yang dihasilkan (default 5)
     * @return array   Array of soal, each: { pertanyaan, opsi:{A,B,C,D}, jawaban, tingkat }
     *
     * @throws \RuntimeException  Jika API gagal atau response tidak bisa di-parse
     */
    public function generate(Materi $materi, int $jumlah = 5): array
    {
        $cacheKey = "quiz_generated_{$materi->id_materi}_" . auth()->id();

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($materi, $jumlah) {
            $apiKey = env('GROQ_API_KEY');

            if (empty($apiKey)) {
                throw new \RuntimeException('GROQ_API_KEY belum dikonfigurasi di .env.');
            }

            $systemPrompt = <<<PROMPT
Kamu adalah pembuat soal ujian. Buat {$jumlah} soal pilihan ganda A-D berdasarkan HANYA teks materi yang diberikan. Jangan gunakan pengetahuan di luar teks.
Variasikan soal dengan kombinasi acak dari:
- Sudut tanya: fakta langsung / sebab-akibat / perbandingan / analisis / "apa yang terjadi jika"
- Tingkat: mengingat / memahami / menganalisis
Jawab HANYA dalam JSON array, tidak ada teks lain:
[{"pertanyaan":"...","opsi":{"A":"...","B":"...","C":"...","D":"..."},"jawaban":"A","tingkat":"mudah/sedang/sulit","pembahasan":"Penjelasan singkat 1-2 kalimat mengapa jawaban ini benar, berdasarkan teks materi saja"}]
PROMPT;

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])
            ->withOptions(['verify' => false])
            ->post(self::GROQ_ENDPOINT, [
                'model'    => self::GROQ_MODEL,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user',   'content' => strip_tags($materi->isi)],
                ],
            ]);

            if ($response->failed()) {
                throw new \RuntimeException(
                    'Groq API gagal: HTTP ' . $response->status() . ' — ' . $response->body()
                );
            }

            $content = $response->json('choices.0.message.content');

            if (empty($content)) {
                throw new \RuntimeException('Groq API mengembalikan response kosong.');
            }

            // Ekstrak JSON array dari dalam content (ada kemungkinan ada teks sebelum/sesudah)
            if (preg_match('/\[.*\]/s', $content, $matches)) {
                $content = $matches[0];
            }

            $soal = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE || ! is_array($soal)) {
                throw new \RuntimeException(
                    'Gagal parse JSON dari Groq: ' . json_last_error_msg() . '. Raw: ' . substr($content, 0, 300)
                );
            }

            if (count($soal) === 0) {
                throw new \RuntimeException('Groq mengembalikan array soal kosong.');
            }

            return $soal;
        });
    }
}
