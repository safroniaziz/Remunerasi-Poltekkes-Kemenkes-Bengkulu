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
    @foreach ($riwayatPoints->riwayatPointAlls as $index => $riwayatPoint)
        @php
            $borangs = DB::table($riwayatPoint->kode_rubrik)
                        ->where('periode_id', $periode->id)
                        ->where('nip', $nip)
                        ->where('is_verified', 1)
                        ->get();

        @endphp
        @if ($riwayatPoint->kode_rubrik == "r01_perkuliahan_teoris")
            @include('backend/dosen/laporan._r01') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r02_perkuliahan_praktikums")
            @include('backend/dosen/laporan._r02') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r03_membimbing_pencapaian_kompetensis")
            @include('backend/dosen/laporan._r03') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r04_membimbing_pendampingan_ukoms")
            @include('backend/dosen/laporan._r04') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r05_membimbing_praktik_pkk_pbl_kliniks")
            @include('backend/dosen/laporan._r05') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r06_menguji_ujian_oscas")
            @include('backend/dosen/laporan._r06') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r07_membimbing_skripsi_lta_la_profesis")
            @include('backend/dosen/laporan._r07') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r08_menguji_seminar_proposal_kti_lta_skripsis")
            @include('backend/dosen/laporan._r08') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r09_menguji_seminar_hasil_kti_lta_skripsis")
            @include('backend/dosen/laporan._r09') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r010_menulis_buku_ajar_berisbns")
            @include('backend/dosen/laporan._r10') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r011_mengembangkan_modul_berisbns")
            @include('backend/dosen/laporan._r11') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r012_membimbing_pkms")
            @include('backend/dosen/laporan._r12') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r013_orasi_ilmiah_narasumber_bidang_ilmus")
            @include('backend/dosen/laporan._r13') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r014_karya_inovasis")
            @include('backend/dosen/laporan._r14') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r015_menulis_karya_ilmiah_dipublikasikans")
            @include('backend/dosen/laporan._r15') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r016_naskah_buku_bahasa_terbit_edar_inters")
            @include('backend/dosen/laporan._r16') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r017_naskah_buku_bahasa_terbit_edar_nas")
            @include('backend/dosen/laporan._r17') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r018_mendapat_hibah_pkms")
            @include('backend/dosen/laporan._r18') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r019_latih_nyuluh_natar_ceramah_wargas")
            @include('backend/dosen/laporan._r19') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r020_assessor_bkd_lkds")
            @include('backend/dosen/laporan._r20') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r021_reviewer_eclere_penelitian_dosens")
            @include('backend/dosen/laporan._r21') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r022_reviewer_eclere_penelitian_mhs")
            @include('backend/dosen/laporan._r22') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r023_auditor_mutu_assessor_akred_internals")
            @include('backend/dosen/laporan._r23') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r024_tim_akred_prodi_dan_direktorats")
            @include('backend/dosen/laporan._r24') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r025_kepanitiaan_kegiatan_institusis")
            @include('backend/dosen/laporan._r25') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r026_pengelola_jurnal_buletins")
            @include('backend/dosen/laporan._r26') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r027_keanggotaan_senats")
            @include('backend/dosen/laporan._r27') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r028_melaksanakan_pengembangan_diris")
            @include('backend/dosen/laporan._r28') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r029_memperoleh_penghargaans")
            @include('backend/dosen/laporan._r29') <br>
        @elseif ($riwayatPoint->kode_rubrik == "r030_pengelola_kepks")
            @include('backend/dosen/laporan._r30') <br>

        @endif
    @endforeach
    <table style="width: 100% !important; margin-top:20px !important;">
        <tr>
            <td style="text-align: center">Verifikator</td>
            <td></td>
            <td style="text-align: center">Pegawai</td>
        </tr>
        <tr>
            <td style="text-align: center; vertical-align: bottom;">{{ $pegawai->prodi->verifikator->nama }}</td>
            <td  style="padding-top:100px !important;"></td>
            <td style="text-align: center; vertical-align: bottom;">{{ $pegawai->nama }}</td>
        </tr>
        <tr>
            <td style="text-align: center"></td>
            <td style="text-align: center;">Penanggung Jawab</td>
            <td style="text-align: center"></td>
        </tr>
        <tr>
            <td></td>
            <td  style="padding-top:100px !important; text-align:center">{{ $pegawai->prodi->penanggungJawab->nama }}</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center">{{ $pegawai->prodi->penanggungJawab->nip }}</td>
            <td></td>
        </tr>
    </table>
</body>
</html>
