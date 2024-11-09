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
    <h1>Daftar Pengembalian Buku</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Kode Buku</th>
                <th>Judul Buku</th>
                <th>Status</th>
                <th>Denda</th>
                <th>Tanggal Pengembalian Real</th>
            </tr>
        </thead>
        <tbody>
            @foreach($daftarpengembalian as $index => $pengembalian)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pengembalian->anggota->nama }}</td> <!-- Asumsikan 'nama' adalah field di model Anggota -->
                    <td>{{ $pengembalian->buku->kode_buku }}</td>
                    <td>{{ $pengembalian->buku->judul_buku }}</td>
                    <td>{{ $pengembalian->status }}</td>
                    <td>{{ $pengembalian->denda }}</td>
                    <td>{{ $pengembalian->tanggal_pengembalian_real ?? 'Belum Pengembalian' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
