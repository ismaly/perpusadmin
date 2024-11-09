<!DOCTYPE html>
<html>

<head>
    <title>Daftar Anggota</title>
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

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
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
            max-width: 100px;
            /* Ubah sesuai kebutuhan */
            height: auto;
        }
    </style>
</head>

<body>
    <h1>Daftar Anggota</h1>
    <table>
        <thead>
            <tr>
                <th style="width: 1%">No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Kelas</th>
                {{-- <th>Alamat</th> --}}
                <th>No. Telepon</th>
                <th>Email</th>
                <th>Status Anggota</th>
            </tr>
        </thead>
        <tbody>
            @foreach($daftaranggota as $index => $anggota)
            <tr>
                <td>{{ $index + 1 }}</td>
                                        <td>{{ $anggota->nis }}</td>
                                        <td>{{ $anggota->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($anggota->tgl_lahir)->format('d-m-Y') }}</td>
                                        <td>{{ $anggota->kelas }}</td>
                                        {{-- <td>{{ $anggota->alamat }}</td> --}}
                                        <td>{{ $anggota->no_telepon }}</td>
                                        <td>{{ $anggota->email }}</td>
                                        <td>{{ $anggota->status_anggota }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>