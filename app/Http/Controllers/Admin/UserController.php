<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

    class UserController extends Controller
{
    public function index()
    {
        $users = User::latest('created_at')->paginate(15);
        return view('admin.user.dashboard-user', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'kelas'    => 'nullable|string|max:255',
            'role'     => 'required|in:user,admin',
            'foto'     => 'nullable|image|max:2048',
        ]);

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'kelas'    => $request->kelas,
            'role'     => $request->role,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto-profil', 'public');
        }

        User::create($data);
        return redirect()->route('dashboard-user.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function show(User $dashboard_user)
    {
        $user = $dashboard_user;
        return view('admin.user.show', compact('user'));
    }

    public function edit(User $dashboard_user) 
    {
        $user = $dashboard_user; 
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $dashboard_user)
    {
        $user = $dashboard_user;

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'kelas'    => 'nullable|string|max:10',
            'role'     => 'required|in:user,admin',
            'foto'     => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'kelas' => $request->kelas,
            'role'  => $request->role,
        ];

        // hanya update password kalau field password diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto-profil', 'public');
        }

        $user->update($data);

        return redirect()->route('dashboard-user.index')
                         ->with('success', 'data user berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('dashboard-user.index')->with('success', 'User berhasil dihapus!');
    }
}