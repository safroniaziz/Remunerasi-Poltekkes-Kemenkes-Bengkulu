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
                                @if (isset($_SESSION['data']['nametitle']))
                                    {{ $_SESSION['data']['nametitle'] }}
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
                        <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                            <!-- small box -->
                            <div class="small-box bg-aqua" style="margin-bottom:0px;">
                                <div class="inner">
                                <h3> 10 </h3>

                                <p>Proposal Penelitian</p>
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
                                <h3>20</h3>

                                <p>Proposal Penelitian Tahun Ini</p>
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
                                <h3>30</h3>

                                <p>Proposal Pengabdian</p>
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
                                <h3>40</h3>

                                <p>Proposal Pengabdian Tahun Ini</p>
                                </div>
                                <div class="icon">
                                <i class="fa fa-file-excel-o"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="fa fa-clock-o"></i></span>
                                
                                <div class="info-box-content">
                                    <span class="info-box-text">Periode Saat Ini</span>
                                    <span class="info-box-number">10</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-list"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Jenis Publikasi</span>
                                    <span class="info-box-number">10</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Skim Penelitian</span>
                                    <span class="info-box-number">10</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-check-circle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Skim Pengabdian</span>
                                    <span class="info-box-number">10</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection