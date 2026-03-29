<h2>Edit Subab</h2>

<form method="POST" action="{{ route('subab.update',$subab->id_subbab) }}">

@csrf
@method('PUT')

<input
type="text"
name="nomor_subbab"
value="{{ $subab->nomor_subbab }}"
>

<input
type="text"
name="judul_subbab"
value="{{ $subab->judul_subbab }}"
>

<button type="submit">
Update
</button>

</form>