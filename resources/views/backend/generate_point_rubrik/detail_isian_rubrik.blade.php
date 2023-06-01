@extends('layouts.app')
@section('subTitle','Dashboard')
@section('page','Dashboard')
@push('styles')
    <link href="{{ asset('assets/select2/dist/css/select2.css') }}" rel="stylesheet"
    type="text/css" />
    @include('backend/generate_point_rubrik._loader')
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-home"></i>&nbsp;Detail Isian Rubrik {{ $rekapPerRubrik->nama_rubrik }}
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover table-bordered table-striped" style="width: 100%" id="table">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style="vertical-align:middle">No</th>
                                        <th style="vertical-align:middle">Nip Dosen</th>
                                        <th style="vertical-align:middle">Nama Dosen</th>
                                        @if ($rekapPerRubrik->kode_rubrik == "r01_perkuliahan_teoris" || $rekapPerRubrik->kode_rubrik == "r02_perkuliahan_praktikums" || $rekapPerRubrik->kode_rubrik == "r05_membimbing_praktik_pkk_pbl_kliniks")
                                            <th style="vertical-align:middle; text-align:center">Jumlah SKS</th>
                                            <th style="vertical-align:middle; text-align:center">Jumlah Mahasiswa</th>
                                            <th style="vertical-align:middle; text-align:center">Jumlah Tatap Muka</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r03_membimbing_pencapaian_kompetensis" || $rekapPerRubrik->kode_rubrik == "r04_membimbing_pendampingan_ukoms" || $rekapPerRubrik->kode_rubrik == "r06_menguji_ujian_oscas")
                                            <th style="vertical-align:middle; text-align:center">Jumlah Mahasiswa</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r07_membimbing_skripsi_lta_la_profesis")
                                            <th style="vertical-align:middle; text-align:center">Jumlah Mahasiswa</th>
                                            <th style="vertical-align:middle; text-align:center">Status Pembimbing</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r08_menguji_seminar_proposal_kti_lta_skripsis" || $rekapPerRubrik->kode_rubrik == "r09_menguji_seminar_hasil_kti_lta_skripsis")
                                            <th style="vertical-align:middle; text-align:center">Jumlah Mahasiswa</th>
                                            <th style="vertical-align:middle; text-align:center">Jenis</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r010_menulis_buku_ajar_berisbns" || $rekapPerRubrik->kode_rubrik == "r011_mengembangkan_modul_berisbns")
                                            <th style="vertical-align:middle; text-align:center">Judul Kegiatan</th>
                                            <th style="vertical-align:middle; text-align:center">ISBN</th>
                                            <th style="vertical-align:middle; text-align:center">Status Penulis</th>
                                            <th style="vertical-align:middle; text-align:center">Jumlah Penulis</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r012_membimbing_pkms")
                                            <th style="vertical-align:middle; text-align:center">Tingkatan PKM</th>
                                            <th style="vertical-align:middle; text-align:center">Predikat Juara</th>
                                            <th style="vertical-align:middle; text-align:center">Jumlah Pembimbing</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r013_orasi_ilmiah_narasumber_bidang_ilmus")
                                            <th style="vertical-align:middle; text-align:center">Judul Kegiatan</th>
                                            <th style="vertical-align:middle; text-align:center">Tingkatan Ke</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r014_karya_inovasis" || $rekapPerRubrik->kode_rubrik == "r015_menulis_karya_ilmiah_dipublikasikans")
                                            <th style="vertical-align:middle; text-align:center">Judul Kegiatan</th>
                                            <th style="vertical-align:middle; text-align:center">Status Penulis</th>
                                            <th style="vertical-align:middle; text-align:center">Jenis Luaran</th>
                                            <th style="vertical-align:middle; text-align:center">Jumlah Penulis</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r016_naskah_buku_bahasa_terbit_edar_inters" || $rekapPerRubrik->kode_rubrik == "r017_naskah_buku_bahasa_terbit_edar_nas")
                                            <th style="vertical-align:middle; text-align:center">Judul Buku</th>
                                            <th style="vertical-align:middle; text-align:center">ISBN</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r018_mendapat_hibah_pkms")
                                            <th style="vertical-align:middle; text-align:center">Judul Hibah PKM</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r019_latih_nyuluh_natar_ceramah_wargas")
                                            <th style="vertical-align:middle; text-align:center">Judul Kegiatan</th>
                                            <th style="vertical-align:middle; text-align:center">Jenis Kegiatan</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r020_assessor_bkd_lkds")
                                            <th style="vertical-align:middle; text-align:center">Jumlah Dosen</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r021_reviewer_eclere_penelitian_dosens" || $rekapPerRubrik->kode_rubrik == "r022_reviewer_eclere_penelitian_mhs")
                                            <th style="vertical-align:middle; text-align:center">Judul Protokol Penelitian</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r023_auditor_mutu_assessor_akred_internals" || $rekapPerRubrik->kode_rubrik == "r024_tim_akred_prodi_dan_direktorats")
                                            <th style="vertical-align:middle; text-align:center">Judul Kegiatan</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r025_kepanitiaan_kegiatan_institusis")
                                            <th style="vertical-align:middle; text-align:center">Judul Kegiatan</th>
                                            <th style="vertical-align:middle; text-align:center">Jabatan</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r026_pengelola_jurnal_buletins")
                                            <th style="vertical-align:middle; text-align:center">Judul Kegiatan</th>
                                            <th style="vertical-align:middle; text-align:center">Jabatan</th>
                                            <th style="vertical-align:middle; text-align:center">Edisi Terbit</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r027_keanggotaan_senats" || $rekapPerRubrik->kode_rubrik == "r030_pengelola_kepks")
                                            <th style="vertical-align:middle; text-align:center">Jabatan</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r028_melaksanakan_pengembangan_diris")
                                            <th style="vertical-align:middle; text-align:center">Jenis Kegiatan</th>
                                        @elseif ($rekapPerRubrik->kode_rubrik == "r029_memperoleh_penghargaans")
                                            <th style="vertical-align:middle; text-align:center">Judul Penghargaan</th>
                                        @endif
                                        <th style="vertical-align:middle" class="text-center">Point</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detailIsianRubriks as $index=> $detailIsianRubrik)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $detailIsianRubrik->nip }}</td>
                                            <td>{{ $detailIsianRubrik->pegawai->nama }}</td>
                                            @if ($rekapPerRubrik->kode_rubrik == "r01_perkuliahan_teoris" || $rekapPerRubrik->kode_rubrik == "r02_perkuliahan_praktikums")
                                                <td style=" text-align:center">{{ $detailIsianRubrik->jumlah_sks }}</td>
                                                <td style=" text-align:center">{{ $detailIsianRubrik->jumlah_mahasiswa }}</td>
                                                <td style=" text-align:center">{{ $detailIsianRubrik->jumlah_tatap_muka }}</td>
                                            @endif
                                            <td class="text-center" style="font-weight: bold;">{{ $detailIsianRubrik->point }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );
    </script>
@endpush