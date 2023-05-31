@extends('layouts.app')
@section('subTitle','Dashboard')
@section('page','Dashboard')
@push('styles')
    <link href="{{ asset('assets/select2/dist/css/select2.css') }}" rel="stylesheet"
    type="text/css" />
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-home"></i>&nbsp;Generate Point Rubrik
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="callout callout-info">
                                <h4>Generate Point Rubrik</h4>
                                <p>Generate Point Rubrik digunakan untuk melakukan proses rekapitulasi point di setiap rubrik, selain itu proses ini digunakan untuk melakukan rekapitulasi jumlah point per dosen serta per jurusan di periode aktif</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a href="{{ route('generate_point_rubrik.generate') }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-refresh fa-spin"></i>&nbsp; Generate Point Rubrik</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection