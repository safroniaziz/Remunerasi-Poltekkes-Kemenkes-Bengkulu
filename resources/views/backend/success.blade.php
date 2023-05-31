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
            @if (!empty($dosen))
                <section class="panel">
                    <header class="panel-heading" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                        <i class="fa fa-bar-chart"></i>&nbsp;Informasi Dosen Yang Dipilih
                    </header>
                    <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover table-striped" style="width: 100%">
                                    <tr>
                                        <th>Nama Dosen</th>
                                        <th> : </th>
                                        <td>{{ $dosen->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIP</th>
                                        <th> : </th>
                                        <td>{{ $dosen->nip }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <th> : </th>
                                        <td>{{ $dosen->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <th> : </th>
                                        <td>
                                            @if ($dosen->jenis_kelamin == "L")
                                                <small class="label label-primary"><i class="fa fa-male"></i>&nbsp; Laki-Laki</small>
                                            @else
                                                <small class="label label-primary"><i class="fa fa-female"></i>&nbsp; Perempuan</small>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status Dosen</th>
                                        <th> : </th>
                                        <td>
                                            @if ($dosen->is_active == 1)
                                                <small class="label label-success"><i class="fa fa-check-circle"></i>&nbsp; Aktif</small>
                                            @else
                                                <small class="label label-success"><i class="fa fa-check-circle"></i>&nbsp; Tidak Aktif</small>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan DT</th>
                                        <th> : </th>
                                        <td>
                                            @if ($dosen->jabatan_dt_id != null)
                                                {{ $dosen->jabatanDt->nama_jabatan_dt }}
                                            @else
                                                <a class="text-danger">tidak ada jabatan dt</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>NIDN</th>
                                        <th> : </th>
                                        <td>{{ $dosen->nidn }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </div>
@endsection