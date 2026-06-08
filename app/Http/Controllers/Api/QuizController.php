<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\SoalQuiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quiz = Quiz::with('bab')->latest('id_quiz')->paginate(10);

        return response()->json($quiz);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bab'     => 'required|exists:bab,id_bab',
            'judul_quiz' => 'required|string|max:255',
            'difficulty' => 'required|in:easy,medium,hard',
        ]);

        $quiz = Quiz::create($request->all());

        return response()->json($quiz, 201);
    }

    public function show($id)
    {
        $quiz = Quiz::with('bab', 'soalQuiz')->findOrFail($id);

        return response()->json($quiz);
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function soal($id)
    {
        $quiz = Quiz::findOrFail($id);
        $soal = SoalQuiz::where('id_quiz', $id)->get();

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
            'difficulty'    => 'required|in:easy,medium,hard',
        ]);

        Quiz::findOrFail($id);

        $soal = SoalQuiz::create(array_merge($request->all(), ['id_quiz' => $id]));

        return response()->json($soal, 201);
    }
}
