<!DOCTYPE html>
<html>
<head>
    <title>Daftar Peminjaman</title>
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
    <h1>Daftar Peminjaman Buku</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Kode Buku</th>
                <th>Judul Buku</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Pengembalian</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($daftarpeminjaman as $index => $peminjaman)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $peminjaman->anggota->nama }}</td> <!-- Asumsikan 'nama' adalah field di model Anggota -->
                    <td>{{ $peminjaman->buku->kode_buku }}</td>
                    <td>{{ $peminjaman->buku->judul_buku }}</td>
                    <td>{{ $peminjaman->tanggal_peminjaman }}</td>
                    <td>{{ $peminjaman->tanggal_pengembalian }}</td>
                    <td>{{ $peminjaman->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
