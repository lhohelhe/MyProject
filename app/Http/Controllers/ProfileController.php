<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\Buku;
use App\Models\HasilQuiz;

class ProfileController extends Controller
{
    /**
     * Display the user's profile dashboard with book progress.
     */
    public function show(): View
    {
        $user = Auth::user();
        
        // Progress is calculated from hasil_quiz table — count distinct id_quiz where user answered, 
        // divided by total quiz in that book's bab.
        $bukuProgress = Buku::with(['bab.quiz'])->get()->map(function ($buku) use ($user) {
            $allQuizIds = $buku->bab->flatMap(function ($bab) {
                return $bab->quiz->pluck('id_quiz');
            });

            $totalQuizzes = $allQuizIds->count();
            
            if ($totalQuizzes > 0) {
                $answeredQuizzes = HasilQuiz::where('user_id', $user->id)
                    ->whereIn('id_quiz', $allQuizIds)
                    ->distinct('id_quiz')
                    ->count('id_quiz');
                
                $buku->progress = round(($answeredQuizzes / $totalQuizzes) * 100);
            } else {
                $buku->progress = 0;
            }
            
            return $buku;
        })->filter(function ($buku) {
            return $buku->progress > 0;
        });

        return view('user.profile', compact('bukuProgress'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'kelas' => 'required|in:10,11,12',
            'foto' => 'nullable|image|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->kelas = $request->kelas;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto-profil', 'public');
            $user->foto = $path;
        }

        $user->save();

        return response()->json(['success' => true]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
