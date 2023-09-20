<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Remun</title>
    <style>
        body {
            font-family: sans-serif; /* Menggunakan font sans-serif default */
        }

        h1 {
            font-size: 18px; /* Atur ukuran teks h1 sesuai preferensi Anda */
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; text-transform:uppercase">Laporan Remununerasi <br> {{ $judul }}</h1>
    <!-- ... Isi laporan Anda ... -->
    <table style="width: 100%">
        {{ $riwayatPoints }}
        {{-- @foreach ($riwayatPoints as $riwayatPoint)
            <tr>
                <th>Rubrik {{ $riwayatPoint->nama_rubrik }}</th>
            </tr>
            <tr>
                <th>Total Point {{ $riwayatPoint->point }}</th>
            </tr>
            <tr>

            </tr>
        @endforeach --}}
    </table>
</body>
</html>
