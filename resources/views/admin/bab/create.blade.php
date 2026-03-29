<h2>Tambah Bab</h2>

<form method="POST" action="{{ route('bab.store') }}">

@csrf

<input type="hidden" name="id_buku" value="{{ $id_buku }}">

<input type="number" name="nomor_bab" placeholder="Nomor Bab">

<input type="text" name="judul_bab" placeholder="Judul Bab">

<button type="submit">
Simpan
</button>

</form>