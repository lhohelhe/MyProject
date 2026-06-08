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
use App\Models\UserMateriProgress;
use App\Models\UserQuizProgress;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display the user's profile dashboard with book progress.
     */
    public function show(): View
    {
        $user = Auth::user();
        
        // Progress dihitung dari UserMateriProgress per bab.
        // Setiap bab punya total subbab — progress bab = (max_subbab_index + 1) / total_subbab.
        // Progress buku = rata-rata progress semua bab yang ada di buku.
        // Bab yang belum pernah dibuka user dihitung 0%.
        $bukuProgress = Buku::with(['bab.subab'])->get()->map(function ($buku) use ($user) {
            $totalBab = $buku->bab->count();

            if ($totalBab === 0) {
                $buku->progress = 0;
                return $buku;
            }

            // Ambil semua progress record user untuk bab-bab di buku ini
            $babIds = $buku->bab->pluck('id_bab');
            $progressRecords = UserMateriProgress::where('user_id', $user->id)
                ->whereIn('id_bab', $babIds)
                ->get()
                ->keyBy('id_bab');

            $totalPersen = 0;

            foreach ($buku->bab as $bab) {
                $totalSubbab = $bab->subab->count();

                if ($totalSubbab === 0) {
                    // Bab tanpa subbab tidak dihitung (admin belum input)
                    $totalBab--;
                    continue;
                }

                $record = $progressRecords->get($bab->id_bab);

                if ($record) {
                    // max_subbab_index adalah 0-based, +1 untuk jumlah subbab yang sudah dicapai
                    $babPersen = round((($record->max_subbab_index + 1) / $totalSubbab) * 100);
                    $totalPersen += min($babPersen, 100);
                }
                // Bab yang belum pernah dibuka = 0%, sudah tercakup dalam $totalPersen default 0
            }

            $buku->progress = $totalBab > 0
                ? round($totalPersen / $totalBab)
                : 0;

            return $buku;
        })->filter(function ($buku) {
            return $buku->progress > 0;
        });

        // --- Weekly streak tracker ---
        // Ambil semua last_quiz_date dari UserQuizProgress user ini
        $allProgress = UserQuizProgress::where('user_id', $user->id)
            ->whereNotNull('last_quiz_date')
            ->get();

        // Kumpulkan tanggal unik user belajar (dari quiz) 7 hari ke belakang
        $aktivitasTanggal = $allProgress
            ->pluck('last_quiz_date')
            ->map(fn($d) => Carbon::parse($d)->toDateString())
            ->unique()
            ->toArray();

        // Juga tambah dari UserMateriProgress (membaca materi)
        $materiProgress = UserMateriProgress::where('user_id', $user->id)
            ->whereNotNull('updated_at')
            ->get()
            ->pluck('updated_at')
            ->map(fn($d) => Carbon::parse($d)->toDateString())
            ->unique()
            ->toArray();

        $semuaAktivitas = array_unique(array_merge($aktivitasTanggal, $materiProgress));

        // Buat array 7 hari mulai dari Senin minggu ini
        $today      = Carbon::now();
        $senin      = $today->copy()->startOfWeek(Carbon::MONDAY);
        $weeklyStreak = [];
        $namaHari   = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

        for ($i = 0; $i < 7; $i++) {
            $tgl = $senin->copy()->addDays($i);
            $weeklyStreak[] = [
                'label'  => $namaHari[$i],
                'tanggal'=> $tgl->toDateString(),
                'aktif'  => in_array($tgl->toDateString(), $semuaAktivitas),
                'hari_ini' => $tgl->isToday(),
                'lewat'  => $tgl->isPast() && !$tgl->isToday(),
            ];
        }

        $streakHariIni = in_array($today->toDateString(), $semuaAktivitas);
        $totalStreak   = $allProgress->max('streak_hari') ?? 0;

        return view('user.profile', compact('bukuProgress', 'weeklyStreak', 'streakHariIni', 'totalStreak'));
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
