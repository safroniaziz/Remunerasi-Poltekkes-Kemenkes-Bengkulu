@extends('layouts.app')
@section('subTitle','Data Periode Penilaian')
@section('page','Data Periode Penilaian')
@section('subPage','Semua Data')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-users"></i>&nbsp; Manajemen Data Periode Penilaian
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <div class="col-md-12">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Berhasil :</strong>{{ $message }}
                                </div>
                                @elseif ($message = Session::get('error'))
                                    <div class="alert alert-danger alert-block">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>Gagal :</strong>{{ $message }}
                                    </div>
                                    @else
                            @endif
                        </div>
                        <div class="col-md-12 table-responsive">
                            <div class="pull-left" style="margin-bottom: 3px !important;">
                                <button type="button" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-default">
                                    <i class="fa fa-plus"></i>&nbsp; Tambah Periode Penilaian
                                </button>
                            </div>
                            <table class="table table-striped table-bordered" id="table" style="width:100%; margin-bottom: 5px !important;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style=" vertical-align:middle">Nama Periode</th>
                                        <th style="text-align:center; vertical-align:middle">Periode Siakad</th>
                                        <th style=" vertical-align:middle">Tahun Ajaran</th>
                                        <th style="text-align:center; vertical-align:middle">Semester</th>
                                        <th style="text-align:center; vertical-align:middle">Bulan</th>
                                        <th style="text-align:center; vertical-align:middle">Bulan Pembayaran</th>
                                        <th style="text-align:center; vertical-align:middle">Aktif</th>
                                        <th style="text-align:center; vertical-align:middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($periodes as $index => $periode)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $periode->nama_periode }}</td>
                                            <td>{{ $periode->periode_siakad_id }}</td>
                                            <td>{{ $periode->tahun_ajaran }}</td>
                                            <td>{{ $periode->semester }}</td>
                                            <td>{{ $periode->bulan }}</td>
                                            <td>{{ $periode->bulan_pembayaran }}</td>
                                            <td>
                                                @if ($periode->is_active == 1)
                                                    <form action="{{ route('periode_penilaian.set_nonactive',[$periode->nip]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-thumbs-up"></i></button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('periode_penilaian.set_active',[$periode->nip]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-thumbs-down"></i></button>
                                                    </form>
                                                @endif
                                           </td>
                                           <td>
                                                <a href="{{ route('periode_penilaian.edit',[$periode->slug]) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                           </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @include('backend/periode_penilaians.partials.modal_add')
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection