<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
            'kelas'    => 'nullable|string|max:255',
            'foto'     => 'nullable|image|max:2048',
        ]);

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'kelas'    => $request->kelas,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto-profil', 'public');
        }

        User::create($data);
        return redirect('/dashboard')->with('success', 'User berhasil ditambahkan!');
    }

    public function show(User $user)
    {
        return view('admin.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:5',
            'kelas'    => 'nullable|string|max:255',
            'foto'     => 'nullable|image|max:2048',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->kelas = $request->kelas;

        if ($request->hasFile('foto')) {
            $user->foto = $request->file('foto')->store('foto-profil', 'public');
        }

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->save();
        return redirect('/dashboard')->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/dashboard')->with('success', 'User berhasil dihapus!');
    }
}