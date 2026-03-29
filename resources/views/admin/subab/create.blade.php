<h2>Tambah Subab</h2>

<form method="POST" action="{{ route('subab.store') }}">

@csrf

<input type="hidden" name="id_bab" value="{{ $id_bab }}">

<input
type="text"
name="nomor_subbab"
placeholder="Nomor Subab"
>

<input
type="text"
name="judul_subbab"
placeholder="Judul Subab"
>

<button type="submit">
Simpan
</button>

</form>