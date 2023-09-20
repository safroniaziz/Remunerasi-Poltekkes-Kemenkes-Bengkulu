@extends('layouts.app')
@section('subTitle','Detail Borang Per RUbrik')
@section('page','Detail Borang Per RUbrik')
@section('login_as')
    Selamat Datang,
@endsection
@section('user-login2')
    {{ Auth::user()->nama_user }}
@endsection
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-search"></i>&nbsp;Informasi Dosen
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 5px !important;">
                            <a href="{{ route('point_rubrik_dosen.detail',[$dosen->nip]) }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-hover table-striped" style="width: 100%">
                                <tr>
                                    <th>NIP</th>
                                    <th> : </th>
                                    <td>{{ $dosen->nip }}</td>
                                </tr>
                                <tr>
                                    <th>NIDN</th>
                                    <th> : </th>
                                    <td>{{ $dosen->nidn }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Dosen</th>
                                    <th> : </th>
                                    <td>{{ $dosen->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Prodi Homebase</th>
                                    <th> : </th>
                                    <td>{{ $dosen->prodi? $dosen->prodi->nama_prodi : '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Jurusan</th>
                                    <th> : </th>
                                    <td>{{ $dosen->jurusan ? $dosen->jurusan : '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Nomor Rekening</th>
                                    <th> : </th>
                                    <td>{{ $dosen->nomor_rekening ? $dosen->nomor_rekening : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor NPWP</th>
                                    <th> : </th>
                                    <td>{{ $dosen->npwp ? $dosen->npwp : '-' }}</td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-8 col-sm-12 col-xs-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-info-circle"></i>&nbsp;Total Point Per Dosen
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success">
                                <i class="fa fa-info-circle"></i>&nbsp;<b>Perhatian</b> : Data yang dimunculkan hanya rubrik yang berisi point
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-hover table-striped table-bordered" style="width: 100%">
                                @if ($kodeRubrik == "r01_perkuliahan_teoris")
                                    @include('backend/point_rubrik_dosen._r01')
                                @elseif ($kodeRubrik == "r02_perkuliahan_praktikums")
                                    @include('backend/point_rubrik_dosen._r02')
                                @elseif ($kodeRubrik == "r03_membimbing_pencapaian_kompetensis")
                                    @include('backend/point_rubrik_dosen._r03')
                                @elseif ($kodeRubrik == "r04_membimbing_pendampingan_ukoms")
                                    @include('backend/point_rubrik_dosen._r04')
                                @elseif ($kodeRubrik == "r05_membimbing_praktik_pkk_pbl_kliniks")
                                    @include('backend/point_rubrik_dosen._r05')
                                @elseif ($kodeRubrik == "r06_menguji_ujian_oscas")
                                    @include('backend/point_rubrik_dosen._r06')
                                @elseif ($kodeRubrik == "r07_membimbing_skripsi_lta_la_profesis")
                                    @include('backend/point_rubrik_dosen._r07')
                                @elseif ($kodeRubrik == "r08_menguji_seminar_proposal_kti_lta_skripsis")
                                    @include('backend/point_rubrik_dosen._r08')
                                @elseif ($kodeRubrik == "r09_menguji_seminar_hasil_kti_lta_skripsis")
                                    @include('backend/point_rubrik_dosen._r09')
                                @elseif ($kodeRubrik == "r010_menulis_buku_ajar_berisbns")
                                    @include('backend/point_rubrik_dosen._r010')
                                @elseif ($kodeRubrik == "r011_mengembangkan_modul_berisbns")
                                    @include('backend/point_rubrik_dosen._r011')
                                @elseif ($kodeRubrik == "r012_membimbing_pkms")
                                    @include('backend/point_rubrik_dosen._r012')
                                @elseif ($kodeRubrik == "r013_orasi_ilmiah_narasumber_bidang_ilmus")
                                    @include('backend/point_rubrik_dosen._r013')
                                @elseif ($kodeRubrik == "r014_karya_inovasis")
                                    @include('backend/point_rubrik_dosen._r014')
                                @elseif ($kodeRubrik == "r015_menulis_karya_ilmiah_dipublikasikans")
                                    @include('backend/point_rubrik_dosen._r015')
                                @elseif ($kodeRubrik == "r016_naskah_buku_bahasa_terbit_edar_inters")
                                    @include('backend/point_rubrik_dosen._r016')
                                @elseif ($kodeRubrik == "r017_naskah_buku_bahasa_terbit_edar_nas")
                                    @include('backend/point_rubrik_dosen._r017')
                                @elseif ($kodeRubrik == "r018_mendapat_hibah_pkms")
                                    @include('backend/point_rubrik_dosen._r018')
                                @elseif ($kodeRubrik == "r019_latih_nyuluh_natar_ceramah_wargas")
                                    @include('backend/point_rubrik_dosen._r019')
                                @elseif ($kodeRubrik == "r020_assessor_bkd_lkds")
                                    @include('backend/point_rubrik_dosen._r020')
                                @elseif ($kodeRubrik == "r021_reviewer_eclere_penelitian_dosens")
                                    @include('backend/point_rubrik_dosen._r021')
                                @elseif ($kodeRubrik == "r022_reviewer_eclere_penelitian_mhs")
                                    @include('backend/point_rubrik_dosen._r022')
                                @elseif ($kodeRubrik == "r023_auditor_mutu_assessor_akred_internals")
                                    @include('backend/point_rubrik_dosen._r023')
                                @elseif ($kodeRubrik == "r024_tim_akred_prodi_dan_direktorats")
                                    @include('backend/point_rubrik_dosen._r024')
                                @elseif ($kodeRubrik == "r025_kepanitiaan_kegiatan_institusis")
                                    @include('backend/point_rubrik_dosen._r025')
                                @elseif ($kodeRubrik == "r026_pengelola_jurnal_buletins")
                                    @include('backend/point_rubrik_dosen._r026')
                                @elseif ($kodeRubrik == "r027_keanggotaan_senats")
                                    @include('backend/point_rubrik_dosen._r027')
                                @elseif ($kodeRubrik == "r028_melaksanakan_pengembangan_diris")
                                    @include('backend/point_rubrik_dosen._r028')
                                @elseif ($kodeRubrik == "r029_memperoleh_penghargaans")
                                    @include('backend/point_rubrik_dosen._r029')
                                @elseif ($kodeRubrik == "r030_pengelola_kepks")
                                    @include('backend/point_rubrik_dosen._r030')
                                @endif
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
