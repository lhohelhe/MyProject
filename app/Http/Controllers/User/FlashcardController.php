<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Flashcard;
use App\Models\UserFlashcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlashcardController extends Controller
{
    /**
     * Ambil semua flashcard di subbab + status user
     */
    public function index($id_subbab)
    {
        $user = Auth::user();

        // Ambil semua flashcard untuk subbab ini
        $flashcards = Flashcard::where('id_subbab', $id_subbab)
                               ->with('subab')
                               ->latest('id_flashcard')
                               ->get();

        if ($flashcards->isEmpty()) {
            return redirect()->back()->with('info', 'Belum ada flashcard untuk subbab ini.');
        }

        // Ambil status user untuk setiap flashcard
        $userStatuses = UserFlashcard::where('user_id', $user->id)
                                     ->whereIn('id_flashcard', $flashcards->pluck('id_flashcard'))
                                     ->get()
                                     ->keyBy('id_flashcard');

        // Tambahkan status ke flashcard collection
        foreach ($flashcards as $fc) {
            $fc->user_status = $userStatuses[$fc->id_flashcard]?->status ?? 'belum';
            $fc->user_flashcard_id = $userStatuses[$fc->id_flashcard]?->id ?? null;
        }

        // Hitung progress
        $totalFlashcard = $flashcards->count();
        $sudahDikerjakan = $userStatuses->where('status', 'sudah')->count();
        $progressPercent = $totalFlashcard > 0 ? intval(($sudahDikerjakan / $totalFlashcard) * 100) : 0;

        return view('user.flashcard.index', compact('flashcards', 'id_subbab', 'progressPercent', 'sudahDikerjakan', 'totalFlashcard'));
    }

    /**
     * Set flashcard sebagai sudah dikerjakan
     */
    public function markDone($id_flashcard)
    {
        $user = Auth::user();

        // Cek flashcard ada atau tidak
        $flashcard = Flashcard::findOrFail($id_flashcard);

        // Ambil atau buat user_flashcard record
        $userFlashcard = UserFlashcard::firstOrCreate(
            ['user_id' => $user->id, 'id_flashcard' => $id_flashcard],
            ['status' => 'belum']
        );

        // Update status ke sudah
        $userFlashcard->status = 'sudah';
        $userFlashcard->save();

        // Hitung progress untuk subbab ini
        $totalFlashcard = Flashcard::where('id_subbab', $flashcard->id_subbab)->count();
        $sudahDikerjakan = UserFlashcard::where('user_id', $user->id)
                                        ->whereIn('id_flashcard', 
                                                  Flashcard::where('id_subbab', $flashcard->id_subbab)->pluck('id_flashcard')
                                                 )
                                        ->where('status', 'sudah')
                                        ->count();

        $progressPercent = $totalFlashcard > 0 ? intval(($sudahDikerjakan / $totalFlashcard) * 100) : 0;

        return response()->json([
            'success' => true,
            'progress' => $progressPercent,
            'sudah_dikerjakan' => $sudahDikerjakan,
            'total' => $totalFlashcard
        ]);
    }

    /**
     * Reset semua flashcard di subbab ke belum
     */
    public function reset($id_subbab)
    {
        $user = Auth::user();

        // Ambil semua flashcard untuk subbab ini
        $flashcardIds = Flashcard::where('id_subbab', $id_subbab)->pluck('id_flashcard');

        // Reset semua status ke belum untuk user ini
        UserFlashcard::where('user_id', $user->id)
                     ->whereIn('id_flashcard', $flashcardIds)
                     ->update(['status' => 'belum']);

        return redirect()->route('user.flashcard', $id_subbab)
                         ->with('success', 'Semua flashcard berhasil di-reset!');
    }
}
