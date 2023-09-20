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
        @foreach ($riwayatPoints->riwayatPoints as $riwayatPoint)
            <tr>
                <td>{{ $riwayatPoint->nama_rubrik }}</td>
            </tr>
            <tr>
                <td>Total Point {{ $riwayatPoint->point }}</td>
            </tr>
            @php
                $className = 'App\\Models\\' . Str::studly(Str::singular($riwayatPoint->kode_rubrik));
                $borangs = $className::where('periode_id',$periode->id)
                            ->where('nip',$nip)
                            ->where('is_verified',1)
                            ->get();
            @endphp
            <tr>
                <td>{{ $borangs }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
