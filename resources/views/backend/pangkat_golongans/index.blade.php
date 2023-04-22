@extends('layouts.app')
@section('subTitle','Data Pangkat Golongan')
@section('page','Data Pangkat Golongan')
@section('subPage','Semua Data Pangkat Golongan')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-wifungsionalh: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-briefcase"></i>&nbsp;Manajemen Data Pangkat Golongan
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
                        <form method="GET">
                            <div class="form-group col-md-12" style="margin-bottom: 5px !important;">
                                <label for="nama_pangkat" class="col-form-label">Cari Nama Pangkat Golongan</label>
                                <input type="text" class="form-control" id="nama_pangkat" name="nama_pangkat" placeholder="Masukan Nama Pangkat Golongan..." value="{{$nama_pangkat}}">
                            </div>
                            <div class="col-md-12" style="margin-bottom:10px !important;">
                                <button type="submit" class="btn btn-success btn-sm btn-flat mb-2"><i class="fa fa-search"></i>&nbsp;Cari Data</button>
                            </div>
                        </form>
                        <div class="col-md-12 table-responsive">
                            <div class="pull-left" style="margin-bottom: 3px !important;">
                                <a href="{{ route('pangkat_golongan.create') }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>&nbsp; Tambah Pangkat Golongan</a>
                            </div>
                            <table class="table table-striped table-bordered" id="table" style="wifungsionalh:100%; margin-bottom: 5px !important;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style=" vertical-align:middle">NIP</th>
                                        <th style=" vertical-align:middle">Nama Pangkat</th>
                                        <th style=" vertical-align:middle">Golongan</th>
                                        <th style=" vertical-align:middle">TMT Pangkat Golongan</th>
                                        <th style=" vertical-align:middle">Status</th>
                                        <th style="text-align:center; vertical-align:middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($pangkatgolongans as $index => $pangkatgolongans)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>
                                            <a href="" style="font-weight:600;">{{ $pangkatgolongans->nip }}</a></td>
                                            <a href="" style="font-weight:600;">{{ $pangkatgolongans->nama_pangkat }}</a></td>
                                            <a href="" style="font-weight:600;">{{ $pangkatgolongans->golongan }}</a></td>
                                            <td style="text-align: center;">{{ $pangkatgolongans->tmt_pangkat_golongan }}</td>
                                            <td>
                                                @if ($pangkatgolongans->is_active == 1)
                                                    <form action="{{ route('pangkat_golongan.set_nonactive',[$pangkatgolongans->nip]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-thumbs-up"></i></button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('pangkat_golongan.set_active',[$pangkatgolongans->nip]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-thumbs-down"></i></button>
                                                    </form>
                                                @endif
                                           </td>
                                           <td>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('pangkat_golongan.edit',[$pangkatgolongans->slug]) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                   </td>
                                                    <td>
                                                        <form action="{{ route('pangkat_golongan.delete',[$pangkatgolongans->id]) }}" method="POST">
                                                            {{ csrf_field() }} {{ method_field('DELETE') }}
                                                            <button type="submit" class="btn btn-danger btn-sm btn-flat show_confirm"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            </table>
                                           </td>
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
