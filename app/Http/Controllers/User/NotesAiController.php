<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Bab;
use App\Models\Subab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotesAiController extends Controller
{
    /**
     * Generate AI notes (bullet-point summary) for a given bab via AJAX.
     */
    public function generate(Request $request, $id)
    {
        $request->validate([
            'id_bab' => 'required|integer',
        ]);

        $id_bab = $request->id_bab;

        // Ambil semua materi dari bab tersebut melalui subbab
        $subbabList = Subab::where('id_bab', $id_bab)
                           ->with('materi')
                           ->get();

        $allMateri = $subbabList->flatMap(fn($s) => $s->materi);

        if ($allMateri->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada materi di bab ini.',
            ]);
        }

        // Gabungkan semua isi materi, strip HTML, ambil maks 3000 karakter
        $combinedText = $allMateri
            ->map(fn($m) => strip_tags($m->isi ?? ''))
            ->filter()
            ->implode("\n\n");

        $combinedText = mb_substr($combinedText, 0, 3000);

        // System prompt — pure ASCII only, no unicode characters
        $systemPrompt = 'Kamu adalah asisten belajar SMA. Buat ringkasan dalam bahasa Indonesia'
            . ' berupa 5-8 poin utama dari teks berikut.'
            . ' Format output: setiap poin diawali tanda strip (-) dan dipisah newline.'
            . ' Singkat, padat, mudah dipahami siswa SMA.';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type'  => 'application/json',
            ])
            ->withOptions(['verify' => false])
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'      => 'llama-3.3-70b-versatile',
                'max_tokens' => 800,
                'messages'   => [
                    [
                        'role'    => 'system',
                        'content' => $systemPrompt,
                    ],
                    [
                        'role'    => 'user',
                        'content' => $combinedText,
                    ],
                ],
            ]);

            $content = $response->json('choices.0.message.content');

            if (empty($content)) {
                Log::error('NotesAiController: Groq returned empty content', [
                    'id_bab'       => $id_bab,
                    'http_status'  => $response->status(),
                ]);
                Log::error('Groq raw response: ' . $response->body());

                return response()->json([
                    'success' => false,
                    'message' => 'AI tidak mengembalikan respons.',
                ]);
            }

            return response()->json([
                'success'   => true,
                'ringkasan' => $content,
            ]);

        } catch (\Throwable $e) {
            Log::error('NotesAiController: Exception calling Groq API — ' . $e->getMessage(), [
                'id_bab' => $id_bab ?? null,
                'trace'  => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghubungi AI.',
            ]);
        }
    }

    /**
     * Tampilkan halaman ringkasan lengkap per bab.
     */
    public function ringkasan($id, $id_bab)
    {
        $buku = Buku::findOrFail($id);
        $bab  = Bab::findOrFail($id_bab);

        $subbabList = Subab::with(['materi' => fn($q) => $q->orderBy('id_materi')])
                           ->where('id_bab', $id_bab)
                           ->orderBy('nomor_subbab')
                           ->get();

        return view('user.ringkasan-bab', compact('buku', 'bab', 'subbabList'));
    }
}
