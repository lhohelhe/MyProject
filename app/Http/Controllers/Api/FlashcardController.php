<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flashcard;
use Illuminate\Http\Request;

class FlashcardController extends Controller
{
    public function index()
    {
        $flashcard = Flashcard::with('subab')->latest('id_flashcard')->paginate(10);

        return response()->json($flashcard);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_subbab'  => 'required|exists:subbab,id_subbab',
            'pertanyaan' => 'required|string',
            'jawaban'    => 'required|string',
        ]);

        $flashcard = Flashcard::create($request->all());

        return response()->json($flashcard, 201);
    }

    public function show($id)
    {
        $flashcard = Flashcard::with('subab')->findOrFail($id);

        return response()->json($flashcard);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban'    => 'required|string',
        ]);

        $flashcard = Flashcard::findOrFail($id);
        $flashcard->update($request->all());

        return response()->json($flashcard);
    }

    public function destroy($id)
    {
        $flashcard = Flashcard::findOrFail($id);
        $flashcard->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
