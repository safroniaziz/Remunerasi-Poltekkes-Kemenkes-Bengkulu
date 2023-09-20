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
        font-size: 12px; /* Sesuaikan ukuran font sesuai kebutuhan Anda */
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
    <h1 style="text-align: center; text-transform:uppercase">Borang Remununerasi <br> {{ $judul }}</h1>
    <!-- ... Isi laporan Anda ... -->
    <table style="width: 100%" class="striped bordered">
        @foreach ($riwayatPoints->riwayatPointAlls as $index => $riwayatPoint)
            @php
                $borangs = DB::table($riwayatPoint->kode_rubrik)
                            ->where('periode_id', $periode->id)
                            ->where('nip', $nip)
                            ->where('is_verified', 1)
                            ->get();

            @endphp
            @if ($riwayatPoint->kode_rubrik == "r01_perkuliahan_teoris")
                @include('backend/dosen/laporan._r01')
            @elseif ($riwayatPoint->kode_rubrik == "r02_perkuliahan_praktikums")
                @include('backend/dosen/laporan._r02')
            @elseif ($riwayatPoint->kode_rubrik == "r03_membimbing_pencapaian_kompetensis")
                @include('backend/dosen/laporan._r03')
            @endif
        @endforeach
    </table>
</body>
</html>
