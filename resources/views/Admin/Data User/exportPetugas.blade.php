<!DOCTYPE html>
<html>
<head>
    <title>Daftar Petugas</title>
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
    <h1>Daftar Petugas</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Petugas</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($daftarpetugas as $index => $petugas)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $petugas->name }}</td>
                    <td>{{ $petugas->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
