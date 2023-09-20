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

        table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px; /* Sesuaikan ukuran font sesuai kebutuhan Anda */
        }

        table.striped tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
        }

        table.bordered th,
        table.bordered td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
        }

        table.bordered th {
        background-color: #f2f2f2;
        }


    </style>
</head>
<body>
    <h1 style="text-align: center; text-transform:uppercase">Laporan Remununerasi <br> {{ $judul }}</h1>
    <!-- ... Isi laporan Anda ... -->
    <table style="width: 100%" class="striped bordered">
        @foreach ($riwayatPoints->riwayatPoints as $riwayatPoint)
            @php
                $className = 'App\\Models\\' . Str::studly(Str::singular($riwayatPoint->kode_rubrik));
                $borangs = $className::where('periode_id',$periode->id)
                            ->where('nip',$nip)
                            ->where('is_verified',1)
                            ->get();
            @endphp
            @if ($riwayatPoint->kode_rubrik == "r01_perkuliahan_teoris")
                @include('backend/dosen/laporan._r01')
            @endif
        @endforeach
    </table>
</body>
</html>
