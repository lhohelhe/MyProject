<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
        public function create(): View
        {
            return view('auth.register');
        }

        /**
         * Handle an incoming registration request.
         */
            public function store(Request $request): RedirectResponse
        {
            // Validasi
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
                'kelas' => ['nullable', 'string', 'max:10'],
                'password' => ['required', 'confirmed', 'min:3'],
            ]);

            // Buat user baru, password disimpan plain text untuk proyek pembelajaran
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'kelas' => $request->kelas,
                'password' => $request->password,
                'role' => 'user',
                'email_verified_at' => now(),
            ]);

            // Auto login
            Auth::login($user);

            // Redirect ke landing page
            return redirect()->route('user.profile');
        }
}