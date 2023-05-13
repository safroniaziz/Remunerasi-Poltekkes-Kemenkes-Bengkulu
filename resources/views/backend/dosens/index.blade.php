@extends('layouts.app')
@section('subTitle','Data Dosen')
@section('page','Data Dosen')
@section('subPage','Semua Data Dosen')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-users"></i>&nbsp;Manajemen Data Dosen
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
                                <label for="nama" class="col-form-label">Cari Nama Dosen</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Judul/Skema/Nama Ketua..." value="{{$nama}}">
                            </div>
                            <div class="col-md-12" style="margin-bottom:10px !important;">
                                <button type="submit" class="btn btn-success btn-sm btn-flat mb-2"><i class="fa fa-search"></i>&nbsp;Cari Data</button>
                            </div>
                        </form>
                        <div class="col-md-12 table-responsive">
                            <div class="pull-left" style="margin-bottom: 3px !important;">
                                <a href="{{ route('dosen.create') }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>&nbsp; Tambah Dosen</a>
                            </div>
                            <table class="table table-striped table-bordered" id="table" style="width:100%; margin-bottom: 5px !important;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style=" vertical-align:middle">Nama Lengkap</th>
                                        <th style="text-align:center; vertical-align:middle">Jenis Kelamin</th>
                                        <th style="text-align:center; vertical-align:middle">Serdos</th>
                                        <th style="text-align:center; vertical-align:middle">Nomor Sertifikat Serdos</th>
                                        <th style="text-align:center; vertical-align:middle">Aktif</th>
                                        <th style="text-align:center; vertical-align:middle">Riwayat Jabatan</th>
                                        <th style="text-align:center; vertical-align:middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($dosens as $index => $dosen)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>
                                                <a href="" style="font-weight:600;">{{ $dosen->nama }}</a>
                                                <br>
                                                <hr style="margin-bottom:5px !important; margin-top:5px !important; border-color:#8c8c8c !important">
                                                <small style="font-size:10px !important;  text-transform:capitalize;" class="label label-success">{{ $dosen->nip ?? '-' }}</small>
                                                <small style="font-size:10px !important;  text-transform:capitalize;" class="label label-info">{{ $dosen->email ?? '-' }}</small>
                                                <small style="font-size:10px !important;  text-transform:capitalize;" class="label label-primary">{{ $dosen->jurusan ?? '-' }}</small>
                                            </td>
                                            <td style="text-align: center">
                                                @if ($dosen->jenis_kelamin == "L")
                                                    <small class="label label-primary"><i class="fa fa-male"></i>&nbsp; Laki-Laki</small>
                                                @else
                                                    <small class="label label-warning"><i class="fa fa-female"></i>&nbsp; Perempuan</small>
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if ($dosen->is_serdos == 1)
                                                    <small class="label label-success"><i class="fa fa-check-circle"></i>&nbsp; Ya</small>
                                                @else
                                                    <small class="label label-danger"><i class="fa fa-minus"></i>&nbsp; Tidak</small>
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if ($dosen->is_serdos == 1)
                                                    {{ $dosen->no_sertifikat_serdos }}
                                                @else
                                                    <small class="text-danger"><i class="fa fa-minus"></i></small>
                                                @endif
                                            </td>
                                           <td>
                                                @if ($dosen->is_active == 1)
                                                    <form action="{{ route('dosen.set_nonactive',[$dosen->nip]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-thumbs-up"></i></button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('dosen.set_active',[$dosen->nip]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-thumbs-down"></i></button>
                                                    </form>
                                                @endif
                                           </td>
                                           <td class="text-center">
                                                <a href="{{ route('dosen.riwayat_jabatan_fungsional',[$dosen->slug]) }}" class="btn btn-success btn-sm btn-flat">{{ $dosen->jabatanFungsionals()->count() }}</a>
                                           </td>
                                           <td>
                                                <a href="{{ route('dosen.edit',[$dosen->slug]) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
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