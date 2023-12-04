@extends('layouts.app')
@section('subTitle','Rekap Laporan Nominatif')
@section('page','Rekap Laporan Nominatif')
@section('subPage','Semua Rekap Laporan Nominatif')
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
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-file-excel-o"></i>&nbsp;Rekap Laporan Nominatif
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <form method="GET" id="pencarian">
                            <div class="form-group col-md-12" style="margin-bottom: 5px !important;">
                                <label for="nama" class="col-form-label">Cari Nama/Nomor Dosen</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama atau Nomor Dosen..." value="{{$nama}}">
                            </div>
                            <div class="col-md-12" style="margin-bottom:10px !important;">
                                <button type="submit" class="btn btn-success btn-sm btn-flat mb-2"><i class="fa fa-search"></i>&nbsp;Cari Data</button>
                            </div>
                        </form>
                        <div class="col-md-12" style="margin-bottom: 5px !important;">
                            <a href="{{ route('laporan_keuangan.exportData') }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-file-excel-o"></i>&nbsp;Export Data</a>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped table-bordered" id="table" style="width:100%; margin-bottom: 5px !important;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style=" vertical-align:middle">Nama Dosen
                                        <th style=" vertical-align:middle; text-align:center;">Jabatan Fungsional</th>
                                        <th style=" vertical-align:middle; text-align:center;">Jabatan DT</th>
                                        <th style=" vertical-align:middle; text-align:center;">Grade Jabatan</th>
                                        <th style=" vertical-align:middle; text-align:center;">Gaji BLU</th>
                                        <th style=" vertical-align:middle; text-align:center;">Harga Point</th>
                                        <th style=" vertical-align:middle; text-align:center;">Total Point</th>
                                        <th style=" vertical-align:middle; text-align:center;">Golongan</th>
                                        <th style=" vertical-align:middle; text-align:center;">Pajak</th>
                                        <th style="text-align:center; vertical-align:middle">Remun Diterima</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $harga_point = 0; // Inisialisasi harga_point
                                        $gaji_blu = 0; // Inisialisasi harga_point
                                    @endphp     
                                    @foreach ($nominatifs as $key => $nominatif)
                                        <tr>
                                            <td>{{ $nominatifs->firstItem() + $key }}</td>
                                            <td>{{ $nominatif->dosen->nama }}</td>
                                            <td class="text-center">{{ $nominatif->dosen->nama_jabatan_fungsional_aktif ? $nominatif->dosen->nama_jabatan_fungsional_aktif : '-' }}</td>
                                            <td class="text-center">{{ $nominatif->dosen->nama_jabatan_dt_aktif ? $nominatif->dosen->nama_jabatan_dt_aktif : '-' }}</td>
                                            <td class="text-center">
                                                @if ($nominatif->dosen->nama_jabatan_fungsional_aktif && $nominatif->dosen->nama_jabatan_dt_aktif)
                                                    @if ($nominatif->dosen->grade_jabatan_fungsional_aktif > $nominatif->dosen->grade_jabatan_dt_aktif) 
                                                        {{ $nominatif->dosen->grade_jabatan_fungsional_aktif }}
                                                        @php
                                                            $grade = $nominatif->dosen->grade_jabatan_fungsional_akti;
                                                        @endphp
                                                    @elseif ($nominatif->dosen->grade_jabatan_fungsional_aktif < $nominatif->dosen->grade_jabatan_dt_aktif) 
                                                        {{ $nominatif->dosen->grade_jabatan_dt_aktif }}
                                                        @php
                                                            $grade = $nominatif->dosen->grade_jabatan_dt_aktif;
                                                        @endphp
                                                    @endif
                                                @elseif (!$nominatif->dosen->nama_jabatan_fungsional_aktif && $nominatif->dosen->nama_jabatan_dt_aktif)
                                                    {{ $nominatif->dosen->grade_jabatan_dt_aktif }}
                                                    @php
                                                        $grade = $nominatif->dosen->grade_jabatan_dt_aktif;
                                                    @endphp
                                                @elseif ($nominatif->dosen->nama_jabatan_fungsional_aktif && !$nominatif->dosen->nama_jabatan_dt_aktif)
                                                    {{ $nominatif->dosen->grade_jabatan_fungsional_aktif }}
                                                    @php
                                                        $grade = $nominatif->dosen->grade_jabatan_fungsional_aktif;
                                                    @endphp
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($nominatif->dosen->nama_jabatan_fungsional_aktif && $nominatif->dosen->nama_jabatan_dt_aktif)
                                                    @if ($nominatif->dosen->grade_jabatan_fungsional_aktif > $nominatif->dosen->grade_jabatan_dt_aktif) 
                                                        {{ $nominatif->dosen->gaji_blu_jabatan_fungsional_aktif }}
                                                        @php
                                                            $gaji_blu = $nominatif->dosen->gaji_blu_jabatan_fungsional_aktif;
                                                        @endphp
                                                    @elseif ($nominatif->dosen->grade_jabatan_fungsional_aktif < $nominatif->dosen->grade_jabatan_dt_aktif) 
                                                        {{ $nominatif->dosen->gaji_blu_jabatan_dt_aktif }}
                                                        @php
                                                            $gaji_blu = $nominatif->dosen->gaji_blu_jabatan_dt_aktif;
                                                        @endphp
                                                    @endif
                                                @elseif (!$nominatif->dosen->nama_jabatan_fungsional_aktif && $nominatif->dosen->nama_jabatan_dt_aktif)
                                                    {{ $nominatif->dosen->gaji_blu_jabatan_dt_aktif }}
                                                    @php
                                                        $gaji_blu = $nominatif->dosen->gaji_blu_jabatan_dt_aktif;
                                                    @endphp
                                                @elseif ($nominatif->dosen->nama_jabatan_fungsional_aktif && !$nominatif->dosen->nama_jabatan_dt_aktif)
                                                    {{ $nominatif->dosen->gaji_blu_jabatan_fungsional_aktif }}
                                                    @php
                                                        $gaji_blu = $nominatif->dosen->gaji_blu_jabatan_fungsional_aktif;
                                                    @endphp
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                @if ($nominatif->dosen->nama_jabatan_fungsional_aktif && $nominatif->dosen->nama_jabatan_dt_aktif)
                                                    @if ($nominatif->dosen->grade_jabatan_fungsional_aktif > $nominatif->dosen->grade_jabatan_dt_aktif) 
                                                        {{ $nominatif->dosen->harga_point_jabatan_fungsional_aktif }}
                                                        @php
                                                            $harga_point = $nominatif->dosen->harga_point_jabatan_fungsional_aktif;
                                                        @endphp
                                                    @elseif ($nominatif->dosen->grade_jabatan_fungsional_aktif < $nominatif->dosen->grade_jabatan_dt_aktif) 
                                                        {{ $nominatif->dosen->harga_point_jabatan_dt_aktif }}
                                                        @php
                                                            $harga_point = $nominatif->dosen->harga_point_jabatan_dt_aktif;
                                                        @endphp
                                                    @endif
                                                @elseif (!$nominatif->dosen->nama_jabatan_fungsional_aktif && $nominatif->dosen->nama_jabatan_dt_aktif)
                                                    {{ $nominatif->dosen->harga_point_jabatan_dt_aktif }}
                                                    @php
                                                        $harga_point = $nominatif->dosen->harga_point_jabatan_dt_aktif
                                                    @endphp
                                                @elseif ($nominatif->dosen->nama_jabatan_fungsional_aktif && !$nominatif->dosen->nama_jabatan_dt_aktif)
                                                    {{ $nominatif->dosen->harga_point_jabatan_fungsional_aktif }}
                                                    @php
                                                        $harga_point = $nominatif->dosen->harga_point_jabatan_fungsional_aktif;
                                                    @endphp
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $nominatif->total_point }}
                                            </td>
                                            <td class="text-center">
                                                {{ $nominatif->dosen->nama_pangkat_golongan_aktif }}
                                            </td>
                                            <td class="text-center">
                                                @if ($nominatif->dosen->nama_pangkat_golongan_aktif == "IIIA" || $nominatif->dosen->nama_pangkat_golongan_aktif == "IIIB" || $nominatif->dosen->nama_pangkat_golongan_aktif == "IIIC" || $nominatif->dosen->nama_pangkat_golongan_aktif == "IIID")
                                                    5%
                                                    @php
                                                        $pajak = 5;
                                                    @endphp
                                                @elseif ($nominatif->dosen->nama_pangkat_golongan_aktif == "IVA" || $nominatif->dosen->nama_pangkat_golongan_aktif == "IVB" || $nominatif->dosen->nama_pangkat_golongan_aktif == "IVC" || $nominatif->dosen->nama_pangkat_golongan_aktif == "IVD")
                                                    15%
                                                    @php
                                                        $pajak = 15;
                                                    @endphp
                                                @else
                                                    100%
                                                    @php
                                                        $pajak = 100;
                                                    @endphp
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $totalRemun = ($gaji_blu + ($nominatif->total_point * $harga_point));
                                                    $pajak = ($pajak/100)*$totalRemun;
                                                    $remunDiterima = $totalRemun - $pajak;
                                                @endphp
                                                Rp. {{ number_format($remunDiterima) }},-
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $nominatifs->appends(request()->has('nama') ? ['nama' => $nama] : [])->links("pagination::bootstrap-4") }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection