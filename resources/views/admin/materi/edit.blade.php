<!DOCTYPE html>
<html>
<head>
<title>Edit Materi</title>
@vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-10">

<h1 class="text-2xl font-bold mb-6">Edit Materi</h1>

<form action="{{ route('materi.update',$materi->id_materi) }}" method="POST" enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="mb-4">
<label>Judul Materi</label>
<input type="text" name="judul_materi" value="{{ $materi->judul_materi }}" class="w-full border p-2">
</div>

<div class="mb-4">
<label>Isi Materi</label>
<textarea name="isi" rows="8" class="w-full border p-2">{{ $materi->isi }}</textarea>
</div>

<div class="mb-4">
<label>Gambar</label>
<input type="file" name="gambar">
</div>

<button class="bg-green-600 text-white px-4 py-2 rounded">
Update
</button>

</form>

</body>
</html>