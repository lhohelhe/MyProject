<h2>Edit Bab</h2>

<form method="POST" action="{{ route('bab.update',$bab->id_bab) }}">

@csrf
@method('PUT')

<input type="number"
       name="nomor_bab"
       value="{{ $bab->nomor_bab }}">

<input type="text"
       name="judul_bab"
       value="{{ $bab->judul_bab }}">

<button type="submit">
Update
</button>

</form>