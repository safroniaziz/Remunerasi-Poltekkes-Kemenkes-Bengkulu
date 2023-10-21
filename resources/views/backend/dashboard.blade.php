@extends('layouts.app')
@section('subTitle','Dashboard')
@section('page','Dashboard')
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
                    <i class="fa fa-home"></i>&nbsp;Dashboard 
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <div class="col-md-12">Selamat datang 
                            <strong style="text-transform: capitalize">
                                @if (isset($_SESSION['data']['namatitle']))
                                    {{ $_SESSION['data']['namatitle'] }}
                                @endif    
                            </strong> 
                            di halaman Dashboard Administrator <b> Sistem Informasi Remunerasi, Politeknik Kesehatan, Kementerian Kesehatan Bengkulu</b></div>
                    </div>
                </div>
            </section>

            <section class="panel">
                <header class="panel-heading" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-bar-chart"></i>&nbsp;Informasi Aplikasi
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row">
                        <div class="col-md-12">
                            @if (empty($periodeAktif))
                                <div class="callout callout-danger">
                                    <h4 style="text-transform: uppercase">Mohon Perhatian</h4>
                                    <p>
                                        Saat ini tidak ada periode remunerasi yang aktif, semua rubrik dosen dinonaktifkan dan dosen tidak dapat menginputkan rubrik kinerja ke aplikasi !
                                        <br>
                                        Untuk mengaktifkan periode remunerasi, silahkan <a href="" style="font-weight: bold; font-style:italic;">klik disini</a>
                                    </p>
                                </div>
                            @else
                                <div class="callout callout-success">
                                    <h4 style="text-transform: uppercase">{{ $periodeAktif->nama_periode }}</h4>
                                    <p>Saat Ini Adalah {{ $periodeAktif->nama_periode }}, jika anda ingin merubah periode aktif saat ini, silahkan <a href="" style="font-weight: bold; font-style:italic;">klik disini</a></p>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                            <!-- small box -->
                            <div class="small-box bg-aqua" style="margin-bottom:0px;">
                                <div class="inner">
                                <h3> {{ $jumlahDosen }} </h3>

                                <p>Jumlah Dosen Aktif</p>
                                </div>
                                <div class="icon">
                                <i class="fa fa-file-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                            <!-- small box -->
                            <div class="small-box bg-red" style="margin-bottom:0px;">
                                <div class="inner">
                                <h3>{{ $jumlahRubrik }}</h3>

                                <p>Jumlah Rubrik Kinerja</p>
                                </div>
                                <div class="icon">
                                <i class="fa fa-file-pdf-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                            <!-- small box -->
                            <div class="small-box bg-yellow" style="margin-bottom:0px;">
                                <div class="inner">
                                <h3>{{ $jumlahJurusan }}</h3>

                                <p>Jumlah Jurusan</p>
                                </div>
                                <div class="icon">
                                <i class="fa fa-wpforms"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                            <!-- small box -->
                            <div class="small-box bg-green" style="margin-bottom:0px;">
                                <div class="inner">
                                <h3>{{ $jumlahJabatanDt }}</h3>

                                <p>Jumlah Jabatan DT</p>
                                </div>
                                <div class="icon">
                                <i class="fa fa-file-excel-o"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                            <!-- small box -->
                            <div class="small-box bg-aqua" style="margin-bottom:0px;">
                                <div class="inner">
                                <h3> {{ $jumlahJabatanDs }} </h3>

                                <p>Jumlah Jabatan DS</p>
                                </div>
                                <div class="icon">
                                <i class="fa fa-file-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                            <!-- small box -->
                            <div class="small-box bg-red" style="margin-bottom:0px;">
                                <div class="inner">
                                <h3>{{ $jumlahPesanBelumDibaca }}</h3>

                                <p>Jumlah Pesan Belum Dibaca</p>
                                </div>
                                <div class="icon">
                                <i class="fa fa-file-pdf-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                            <!-- small box -->
                            <div class="small-box bg-yellow" style="margin-bottom:0px;">
                                <div class="inner">
                                <h3>{{ $jumlahVerifikator }}</h3>

                                <p>Jumlah Verifikator</p>
                                </div>
                                <div class="icon">
                                <i class="fa fa-wpforms"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                            <!-- small box -->
                            <div class="small-box bg-green" style="margin-bottom:0px;">
                                <div class="inner">
                                <h3>{{ $jumlahUserRole }}</h3>

                                <p>Jumlah User Role</p>
                                </div>
                                <div class="icon">
                                <i class="fa fa-file-excel-o"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection