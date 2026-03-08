<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Buku</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#F5F5F5]">

<div class="flex flex-col min-h-screen lg:flex-row">

<x-admin-sidebar />

<main class="flex-1 p-10">

<h1>Tambah Buku</h1>

<form action="/books" method="POST" enctype="multipart/form-data">
@csrf

<div>
<label>Judul Buku</label>
<br>
<input type="text" name="judul_buku" required>
</div>

<br>

<div>
<label>Kategori</label>
<br>

<select name="id_kategori">

@foreach($kategori as $k)

<option value="{{ $k->id_kategori }}">
{{ $k->nama_kategori }}
</option>

@endforeach

</select>
</div>

<br>

<div>
<label>Kelas</label>
<br>
<input type="text" name="kelas" required>
</div>

<br>

<div>
<label>Semester</label>
<br>
<input type="text" name="semester" required>
</div>

<br>

<div>
<label>Gambar Buku</label>
<br>
<input type="file" name="gambar">
</div>

<br>

<button type="submit">Simpan Buku</button>

</form>

</main>

</div>

</body>
</html>