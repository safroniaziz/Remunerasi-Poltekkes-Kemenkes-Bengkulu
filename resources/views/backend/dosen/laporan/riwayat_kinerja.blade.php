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
                            {{ Session::get('error') }}
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>	
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12" style="margin-bottom: 10px !important;">
                            <div class="row">
                                <form action="{{ route('dosen.riwayatKinerjaCetak') }}" method="POST">
                                    {{ csrf_field() }} {{ method_field('POST') }}
                                    <div class="form-group col-md-12">
                                        <label for="">Pilih Periode Remunerasi</label>
                                        <select name="periode_id" id="periode_id" class="form-control">
                                            <option disabled selected>-- pilih periode --</option> 
                                            @foreach ($periodes as $periode)
                                                <option value="{{ $periode->id }}">{{ $periode->nama_periode }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-check-circle"></i>&nbsp; Cetak Riwayat Remunerasi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection