<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 15px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            background-color: #ffffff;
        }
        img {
            max-width: 100px; /* Ubah sesuai kebutuhan */
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Daftar Buku</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Lokasi Buku</th>
                <th>Kode Buku</th>
                <th>Judul Buku</th>
                <th>Jenis Buku</th>
                <th>Penulis Buku</th>
                <th>Penerbit Buku</th>
                <th>Tahun Buku</th>
            </tr>
        </thead>
        <tbody>
            @foreach($daftarbuku as $index => $buku)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $buku->kategori->nama_kategori }}</td>
                    <td>{{ $buku->kategori->lokasi_buku }}</td>
                    <td>{{ $buku->kode_buku }}</td>
                    <td>{{ $buku->judul_buku }}</td>
                    <td>{{ $buku->jenis_buku }}</td>
                    <td>{{ $buku->penulis }}</td>
                    <td>{{ $buku->penerbit }}</td>
                    <td>{{ $buku->tahun_terbit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
