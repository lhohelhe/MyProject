<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#F5F5F5]">

<div class="flex">

<x-admin-sidebar />

<main class="flex-1 p-10">

<h1>Edit Buku</h1>

<form action="/books/{{ $buku->id_buku }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div>
<label>Judul Buku</label>
<br>
<input type="text" name="judul_buku" value="{{ $buku->judul_buku }}" required>
</div>

<br>

<div>
<select name="id_kategori">

@foreach($kategori as $k)

<option value="{{ $k->id_kategori }}"
{{ $buku->id_kategori == $k->id_kategori ? 'selected' : '' }}>

{{ $k->nama_kategori }}

</option>

@endforeach

</select>
</div>

<br>

<div>
<label>Kelas</label>
<br>
<input type="text" name="kelas" value="{{ $buku->kelas }}" required>
</div>

<br>

<div>
<label>Semester</label>
<br>
<input type="text" name="semester" value="{{ $buku->semester }}" required>
</div>

<br>

<div>
<label>Gambar Buku</label>
<br>

@if($buku->gambar)
<img src="{{ asset('storage/'.$buku->gambar) }}" width="100">
<br>
@endif

<input type="file" name="gambar">
</div>

<br>

<button type="submit">Update Buku</button>

</form>

</main>

</div>

</body>
</html>