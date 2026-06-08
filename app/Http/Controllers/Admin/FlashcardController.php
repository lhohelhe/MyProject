<?php

namespace App\Http\Controllers\Admin;

use App\Models\Flashcard;
use App\Models\Subab;
use App\Models\Buku;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http as HttpFacade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class FlashcardController extends Controller
{
    /**
     * Display a listing of the flashcards — grouped by bab.
     */
    public function index()
    {
        $flashcards = Flashcard::with(['subab.bab.buku'])->paginate(20);
        $books      = Buku::all();

        // Ringkasan per bab: buku → bab → jumlah flashcard
        $ringkasanBab = Flashcard::with(['subab.bab.buku'])
            ->get()
            ->groupBy(fn($f) => $f->subab->bab->id_bab ?? 0)
            ->map(fn($group) => [
                'bab'      => $group->first()->subab->bab,
                'buku'     => $group->first()->subab->bab->buku,
                'total'    => $group->count(),
                'items'    => $group->groupBy(fn($f) => $f->subab->id_subbab)
                                    ->map(fn($sg) => [
                                        'subbab' => $sg->first()->subab,
                                        'count'  => $sg->count(),
                                    ]),
            ])
            ->filter(fn($item) => $item['bab'] !== null)
            ->values();

        return view('admin.flashcard.index', compact('flashcards', 'books', 'ringkasanBab'));
    }

    /**
     * Show edit form for a flashcard.
     */
    public function edit($id)
    {
        $flashcard = Flashcard::with('subab.bab.buku')->findOrFail($id);
        return view('admin.flashcard.edit', compact('flashcard'));
    }

    /**
     * Update flashcard.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban'    => 'required|string',
        ]);

        $flashcard = Flashcard::findOrFail($id);
        $flashcard->update([
            'pertanyaan' => $request->pertanyaan,
            'jawaban'    => $request->jawaban,
        ]);

        return redirect()->route('admin.flashcard.index')
                         ->with('success', 'Flashcard berhasil diperbarui.');
    }

    /**
     * Generate flashcards using Groq AI for a given subab.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'id_subab' => 'required|exists:subbab,id_subbab',
        ]);

        $apiKey = env('GROQ_API_KEY');
        if (empty($apiKey)) {
            return redirect()->back()->with('error', 'GROQ_API_KEY belum dikonfigurasi di file .env.');
        }

        $subab = Subab::with('materi')->findOrFail($request->input('id_subab'));

        $content = $subab->materi->pluck('isi')->implode("\n\n");
        $content = strip_tags($content);
        $content = substr(trim($content), 0, 3000);

        if (empty($content)) {
            return redirect()->back()->with('error', 'Subbab ini belum memiliki materi. Tambahkan materi terlebih dahulu.');
        }

        $systemPrompt = "Generate 5 flashcards from the provided material. Return a JSON array where each element has 'pertanyaan' and 'jawaban' fields. Use only ASCII characters and plain text. No bullet points or special symbols. Use dash (-) for any list separators.";

        try {
            $response = HttpFacade::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])
            ->withOptions(['verify' => app()->isProduction()])
            ->timeout(30)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'       => 'llama-3.3-70b-versatile',
                'messages'    => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user',   'content' => $content],
                ],
                'temperature' => 0.7,
            ]);

            if ($response->failed()) {
                $status = $response->status();
                $body   = $response->body();
                Log::error('Flashcard Groq API error: ' . $status . ' — ' . $body);
                return redirect()->back()->with('error', 'Groq API gagal (HTTP ' . $status . '). Cek GROQ_API_KEY atau coba lagi.');
            }

            $data           = $response->json();
            $messageContent = $data['choices'][0]['message']['content'] ?? '';

            // Ekstrak JSON array dari response (handle teks sebelum/sesudah array)
            if (preg_match('/\[.*\]/s', $messageContent, $matches)) {
                $messageContent = $matches[0];
            }

            $flashcardsData = json_decode($messageContent, true);

            if (!is_array($flashcardsData) || count($flashcardsData) === 0) {
                Log::error('Flashcard parse error. Raw: ' . substr($messageContent, 0, 300));
                return redirect()->back()->with('error', 'Format respons AI tidak valid. Coba generate ulang.');
            }

            $count = 0;
            foreach ($flashcardsData as $item) {
                if (empty($item['pertanyaan']) || empty($item['jawaban'])) continue;
                Flashcard::create([
                    'id_subbab'  => $subab->id_subbab,
                    'pertanyaan' => $item['pertanyaan'],
                    'jawaban'    => $item['jawaban'],
                ]);
                $count++;
            }

            return redirect()->back()->with('success', $count . ' flashcard berhasil digenerate untuk subbab "' . $subab->judul_subbab . '".');

        } catch (\Exception $e) {
            Log::error('Flashcard generate exception: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified flashcard.
     */
    public function destroy($id)
    {
        $flashcard = Flashcard::findOrFail($id);
        $flashcard->delete();
        return redirect()->back()->with('success', 'Flashcard deleted successfully.');
    }
}
