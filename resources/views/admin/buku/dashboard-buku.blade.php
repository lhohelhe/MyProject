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

        <h1>Dashboard Buku</h1>

        <a href="/books/create">Tambah Buku</a>

        <table border="1">
            <tr>
                <th>Judul Buku</th>
                <th>Kategori</th>
                <th>Kelas</th>
                <th>Semester</th>
                <th>Aksi</th>
                <th>Kelola Buku</th>
            </tr>

            @foreach($buku as $b)
            <tr>
                <td>{{ $b->judul_buku }}</td>
                <td>{{ $b->kategori->nama_kategori }}</td>
                <td>{{ $b->kelas }}</td>
                <td>{{ $b->semester }}</td>
                <td>
                    <a href="/books/{{ $b->id_buku }}/edit">Edit</a>

                    <form action="/books/{{ $b->id_buku }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
                <td>
                    <a href="{{ route('bab.index',$b->id_buku) }}" class="btn btn-sm btn-info">
                        Kelola Buku
                    </a>
                </td>
            </tr>
            @endforeach

        </table>

    </main>

</div>

</body>
</html>