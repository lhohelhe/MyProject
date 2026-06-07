<?php

namespace App\Http\Controllers\Admin;

use App\Models\Flashcard;
use App\Models\Subab;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http as HttpFacade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class FlashcardController extends Controller
{
    /**
     * Display a listing of the flashcards.
     */
    public function index()
    {
        $flashcards = Flashcard::with(['subab.bab.buku'])->paginate(15);
        $books = Buku::all();
        return view('admin.flashcard.index', compact('flashcards', 'books'));
    }

    /**
     * Generate flashcards using Groq AI for a given subab.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'id_subab' => 'required|exists:subabs,id_subab',
        ]);

        $subab = Subab::with('materi')->findOrFail($request->input('id_subab'));
        // Concatenate all materi isi into a single string (limit to 3000 chars for safety)
        $content = $subab->materi->pluck('isi')->implode("\n\n");
        $content = substr($content, 0, 3000);

        $systemPrompt = "Generate 5 flashcards from the provided material. Return a JSON array where each element has 'pertanyaan' and 'jawaban' fields. Use only ASCII characters and plain text. No bullet points or special symbols. Use dash (-) for any list separators.";
        $payload = [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $content],
            ],
            'temperature' => 0.7,
        ];

        try {
            $response = HttpFacade::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])
            ->withOptions(['verify' => false])
            ->post('https://api.groq.com/openai/v1/chat/completions', $payload);

            $data = $response->json();
            $messageContent = $data['choices'][0]['message']['content'] ?? '';
            $flashcardsData = json_decode($messageContent, true);
            if (!is_array($flashcardsData)) {
                throw new \Exception('Invalid response format from Groq API');
            }
            foreach ($flashcardsData as $item) {
                Flashcard::create([
                    'id_subab'   => $subab->id,
                    'pertanyaan' => $item['pertanyaan'] ?? '',
                    'jawaban'    => $item['jawaban'] ?? '',
                ]);
            }
            return redirect()->back()->with('success', 'Flashcards generated successfully.');
        } catch (\Exception $e) {
            Log::error('Flashcard generate error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to generate flashcards.');
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
