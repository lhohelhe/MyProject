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
        $subbab = \App\Models\Subab::findOrFail($id_subbab);

        // Ambil semua flashcard untuk subbab ini
        $flashcards = Flashcard::where('id_subbab', $id_subbab)
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
        }

        // Hitung progress
        $totalFlashcard = $flashcards->count();
        $sudahDikerjakan = $userStatuses->where('status', 'sudah')->count();
        $progressPercent = $totalFlashcard > 0 ? intval(($sudahDikerjakan / $totalFlashcard) * 100) : 0;

        return view('user.flashcard.index', compact('flashcards', 'subbab', 'id_subbab', 'progressPercent', 'sudahDikerjakan', 'totalFlashcard'));
    }

    /**
     * Set flashcard sebagai sudah dikerjakan (AJAX)
     */
    public function markDone($id_flashcard)
    {
        $user = Auth::user();
        $flashcard = Flashcard::findOrFail($id_flashcard);

        // Ambil atau buat user_flashcard record
        $userFlashcard = UserFlashcard::firstOrCreate(
            ['user_id' => $user->id, 'id_flashcard' => $id_flashcard],
            ['status' => 'belum']
        );

        // Toggle status: jika sudah, jadi belum; jika belum, jadi sudah
        // Sesuai requirement "Mark done button saves... with status sudah", 
        // tapi kita buat toggle agar user bisa membatalkan.
        $newStatus = ($userFlashcard->status === 'sudah') ? 'belum' : 'sudah';
        $userFlashcard->status = $newStatus;
        $userFlashcard->save();

        // Hitung progress untuk subbab ini
        $allIds = Flashcard::where('id_subbab', $flashcard->id_subbab)->pluck('id_flashcard');
        $totalFlashcard = $allIds->count();
        $sudahDikerjakan = UserFlashcard::where('user_id', $user->id)
                                        ->whereIn('id_flashcard', $allIds)
                                        ->where('status', 'sudah')
                                        ->count();

        $progressPercent = $totalFlashcard > 0 ? intval(($sudahDikerjakan / $totalFlashcard) * 100) : 0;

        return response()->json([
            'success' => true,
            'status' => $newStatus,
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
