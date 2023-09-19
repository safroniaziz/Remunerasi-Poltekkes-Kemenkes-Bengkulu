@extends('layouts.app')
@section('subTitle','Data Dosen Program Studi')
@section('page','Data Dosen Program Studi')
@section('subPage','Semua Data')
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
        <div class="col-md-5">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-clipboard"></i>&nbsp; Data Dosen Program Studi
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover table-striped" style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <a href="{{ route('prodi') }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Id Prodi</td>
                                        <td>
                                            {{ $prodi->id_prodi }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kode Jenjang</td>
                                        <td>
                                            {{ $prodi->kdjen }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kode Prodi</td>
                                        <td>
                                            {{ $prodi->kdpst }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama Jenjang</td>
                                        <td>
                                            {{ $prodi->nama_jenjang }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama Prodi</td>
                                        <td>
                                            {{ $prodi->nama_prodi }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama Lengkap Prodi</td>
                                        <td>
                                            {{ $prodi->nama_lengkap_prodi }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kode Fakultas</td>
                                        <td>
                                            {{ $prodi->kodefak }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama Fakultas</td>
                                        <td>
                                            {{ $prodi->nmfak }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-7">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-clipboard"></i>&nbsp; Data Dosen Program Studi
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered" id="table" style="width:100%;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Dosen</th>
                                        <th>Program Studi</th>
                                        <th>Fakultas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dosens as $index => $dosen)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $dosen->nama }}</td>
                                            <td>{{ $dosen->prodi->nama_prodi }}</td>
                                            <td>{{ $dosen->prodi->nmfak }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <a class="text-danger">Data Kosong</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection