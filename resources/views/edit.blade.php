<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya - SahabatBuku</title>
</head>
<body>

<h1>Profil Saya</h1>

@if (session('status') === 'profile-updated')
    <p style="color:green">Profil berhasil diperbarui!</p>
@endif

<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <div>
        <label>Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        @error('name') <span style="color:red">{{ $message }}</span> @enderror
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        @error('email') <span style="color:red">{{ $message }}</span> @enderror
    </div>

    <div>
        <label>Kelas</label>
        <select name="kelas">
            <option value="10" {{ $user->kelas == '10' ? 'selected' : '' }}>10</option>
            <option value="11" {{ $user->kelas == '11' ? 'selected' : '' }}>11</option>
            <option value="12" {{ $user->kelas == '12' ? 'selected' : '' }}>12</option>
        </select>
    </div>

    <button type="submit">Simpan Perubahan</button>
</form>

<hr>

<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Logout
</a>
<form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none">
    @csrf
</form>

</body>
</html>