@extends('layouts.app')
@section('subTitle','Data Rubrik 01 Perkuliahan Teori')
@section('page','Data Rubrik 01 Perkuliahan Teori')
@section('subPage','Semua Data')
@section('sidebar')
    @include('layouts.partials.sidebar_dosen')
@endsection
@section('login_as')
    Halaman Dosen
@endsection
@section('user-login2')
    @if (isset($_SESSION['data']['namatitle']))
        {{ $_SESSION['data']['nama'] }}
    @endif
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-users"></i>&nbsp; Riwayat Kinerja Remunerasi
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <div class="col-md-12">
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>	
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12" style="margin-bottom: 10px !important;">
                            <div class="row">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Periode</th>
                                            <th>Point</th>
                                            <th>Remun Diterima</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($riwayatKinerjas as $index => $riwayat)
                                            <tr>
                                                <td>{{ $index+1 }}</td>
                                                <td>{{ $riwayat->dosen->nama }}</td>
                                                <td>{{ $riwayat->periode->nama_periode }}</td>
                                                <td>{{ $riwayat->total_point }}</td>
                                                <td>
                                                    @if ($riwayat->dosen->nama_jabatan_fungsional_aktif && $riwayat->dosen->nama_jabatan_dt_aktif)
                                                        @if ($riwayat->dosen->grade_jabatan_fungsional_aktif > $riwayat->dosen->grade_jabatan_dt_aktif) 
                                                            {{ $riwayat->dosen->gaji_blu_jabatan_fungsional_aktif }}
                                                            @php
                                                                $gaji_blu = $riwayat->dosen->gaji_blu_jabatan_fungsional_aktif;
                                                            @endphp
                                                        @elseif ($riwayat->dosen->grade_jabatan_fungsional_aktif < $riwayat->dosen->grade_jabatan_dt_aktif) 
                                                            {{ $riwayat->dosen->gaji_blu_jabatan_dt_aktif }}
                                                            @php
                                                                $gaji_blu = $riwayat->dosen->gaji_blu_jabatan_dt_aktif;
                                                            @endphp
                                                        @endif
                                                    @elseif (!$riwayat->dosen->nama_jabatan_fungsional_aktif && $riwayat->dosen->nama_jabatan_dt_aktif)
                                                        {{ $riwayat->dosen->gaji_blu_jabatan_dt_aktif }}
                                                        @php
                                                            $gaji_blu = $riwayat->dosen->gaji_blu_jabatan_dt_aktif;
                                                        @endphp
                                                    @elseif ($riwayat->dosen->nama_jabatan_fungsional_aktif && !$riwayat->dosen->nama_jabatan_dt_aktif)
                                                        {{ $riwayat->dosen->gaji_blu_jabatan_fungsional_aktif }}
                                                        @php
                                                            $gaji_blu = $riwayat->dosen->gaji_blu_jabatan_fungsional_aktif;
                                                        @endphp
                                                    @else
                                                        -
                                                    @endif
                                                    @php
                                                        $harga_point = $riwayat->dosen->harga_point_jabatan_fungsional_aktif;
                                                        
                                                    @endphp
                                                    @if ($riwayat->dosen->nama_pangkat_golongan_aktif == "IIIA" || $riwayat->dosen->nama_pangkat_golongan_aktif == "IIIB" || $riwayat->dosen->nama_pangkat_golongan_aktif == "IIIC" || $riwayat->dosen->nama_pangkat_golongan_aktif == "IIID")
                                                        @php
                                                            $pajak = 5;
                                                        @endphp
                                                    @elseif ($riwayat->dosen->nama_pangkat_golongan_aktif == "IVA" || $riwayat->dosen->nama_pangkat_golongan_aktif == "IVB" || $riwayat->dosen->nama_pangkat_golongan_aktif == "IVC" || $riwayat->dosen->nama_pangkat_golongan_aktif == "IVD")
                                                        @php
                                                            $pajak = 15;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $pajak = 100;
                                                        @endphp
                                                    @endif
                                                    @php
                                                        $totalRemun = ($gaji_blu + ($riwayat->total_point * $harga_point));
                                                        $pajak = ($pajak/100)*$totalRemun;
                                                        $remunDiterima = $totalRemun - $pajak;
                                                    @endphp
                                                    Rp. {{ number_format($remunDiterima) }},-
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection