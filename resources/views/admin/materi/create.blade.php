<!DOCTYPE html>
<html>
<head>
<title>Tambah Materi</title>
@vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-10">

<h1 class="text-2xl font-bold mb-6">Tambah Materi</h1>

<form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">

@csrf

<input type="hidden" name="id_subbab" value="{{ $id_subbab }}">

<div class="mb-4">
<label>Judul Materi</label>
<input type="text" name="judul_materi" class="w-full border p-2">
</div>

<div class="mb-4">
<label>Isi Materi</label>
<textarea name="isi" rows="8" class="w-full border p-2"></textarea>
</div>

<div class="mb-4">
<label>Gambar</label>
<input type="file" name="gambar">
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
Simpan
</button>

</form>

</body>
</html>