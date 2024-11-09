<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kategori</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Mengatur font menjadi Arial */
            margin: 20px; /* Menambahkan margin untuk body */
        }
        h1 {
            text-align: center; /* Memusatkan judul */
            margin-bottom: 20px; /* Menambahkan jarak di bawah judul */
            font-size: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Menambahkan jarak di atas tabel */
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
            background-color: #f2f2f2; /* Menambahkan warna latar belakang pada header tabel */
        }
        td {
            background-color: #ffffff; /* Menambahkan warna latar belakang pada sel tabel */
        }
    </style>
</head>
<body>
    <h1>Daftar Kategori</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Lokasi Buku</th>
            </tr>
        </thead>
        <tbody>
            @foreach($daftarkategori as $index => $kategori)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>{{ $kategori->lokasi_buku }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
