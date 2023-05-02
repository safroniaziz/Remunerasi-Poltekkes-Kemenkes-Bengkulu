@extends('layouts.app')
@section('subTitle','Data Nilai EWMP')
@section('page','Data Nilai EWMP')
@section('subPage','Semua Data Nilai EWMP')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-wifungsionalh: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-briefcase"></i>&nbsp;Manajemen Data Nilai EWMP
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
                                <label for="nama_rubrik" class="col-form-label">Cari Nilai EWMP</label>
                                <input type="text" class="form-control" id="nama_rubrik" name="nama_rubrik" placeholder="Masukan Nama Rubrik ..." value="{{$nama_rubrik}}">
                            </div>
                            <div class="col-md-12" style="margin-bottom:10px !important;">
                                <button type="submit" class="btn btn-success btn-sm btn-flat mb-2"><i class="fa fa-search"></i>&nbsp;Cari Data</button>
                            </div>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <div class="pull-left" style="margin-bottom: 3px !important;">
                                <a href="{{ route('nilai_ewmp.create') }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>&nbsp; Tambah Nilai EWMP</a>
                            </div>
                            <table class="table table-striped table-bordered" id="table" style="wifungsionalh:100%; margin-bottom: 5px !important;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style=" vertical-align:middle">nama kelompok rubrik</th>
                                        <th style=" vertical-align:middle">Nama rubrik</th>
                                        <th style=" vertical-align:middle">Nama tabel rubrik</th>
                                        <th style=" vertical-align:middle">EWMP</th>
                                        <th style=" vertical-align:middle">Status</th>
                                        <th style="text-align:center; vertical-align:middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($nilaiewmp as $index => $nilaiewmp)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td style="text-align: center;">{{ $nilaiewmp->kelompok_rubrik_id }}</a></td>
                                            <td style="text-align: center;">{{ $nilaiewmp->nama_rubrik }}</a></td>
                                            <td style="text-align: center;">{{ $nilaiewmp->nama_tabel_rubrik }}</td>
                                            <td style="text-align: center;">{{ $nilaiewmp->ewmp }}</td>
                                            <td>
                                                @if ($nilaiewmp->is_active == 1)
                                                    <form action="{{ route('nilai_ewmp.set_nonactive',[$nilaiewmp->id]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-thumbs-up"></i></button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('nilai_ewmp.set_active',[$nilaiewmp->id]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-thumbs-down"></i></button>
                                                    </form>
                                                @endif
                                           </td>
                                           <td>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('nilai_ewmp.edit',[$nilaiewmp->slug]) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                   </td>
                                                    <td>
                                                        <form action="{{ route('nilai_ewmp.delete',[$nilaiewmp->id]) }}" method="POST">
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );
    </script>
@endpush