@extends('layouts.app')
@section('subTitle','Dashboard')
@section('page','Dashboard')
@push('styles')
    <link href="{{ asset('assets/select2/dist/css/select2.css') }}" rel="stylesheet"
    type="text/css" />
    @include('backend/generate_point_rubrik._loader')
@endpush
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
        <div class="col-md-4 col-sm-12 col-xs-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-search"></i>&nbsp;Informasi Dosen
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 5px !important;">
                            <a href="{{ route('generate_point_rubrik') }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-hover table-striped" style="width: 100%">
                                <tr>
                                    <th>NIP</th>
                                    <th> : </th>
                                    <td>{{ $dosen->nip }}</td>
                                </tr>
                                <tr>
                                    <th>NIDN</th>
                                    <th> : </th>
                                    <td>{{ $dosen->nidn }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Dosen</th>
                                    <th> : </th>
                                    <td>{{ $dosen->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Prodi Homebase</th>
                                    <th> : </th>
                                    <td>{{ $dosen->prodi? $dosen->prodi->nama_prodi : '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Jurusan</th>
                                    <th> : </th>
                                    <td>{{ $dosen->jurusan ? $dosen->jurusan : '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Nomor Rekening</th>
                                    <th> : </th>
                                    <td>{{ $dosen->nomor_rekening ? $dosen->nomor_rekening : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor NPWP</th>
                                    <th> : </th>
                                    <td>{{ $dosen->npwp ? $dosen->npwp : '-' }}</td>
                                </tr>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-8 col-sm-12 col-xs-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-info-circle"></i>&nbsp;Total Point Per Dosen 
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success">
                                <i class="fa fa-info-circle"></i>&nbsp;<b>Perhatian</b> : Data yang dimunculkan hanya rubrik yang berisi point
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-hover table-striped table-bordered" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Rubrik</th>
                                        <th>Total Point</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dosen->riwayatPoints as $index => $riwayatPoint)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $riwayatPoint->nama_rubrik }}</td>
                                            <td>{{ $riwayatPoint->point }}</td>
                                            <td>
                                                <a href="{{ route('point_rubrik_dosen.detail_rubrik',[$dosen->nip, $riwayatPoint->id]) }}"><i class="fa fa-search"></i>&nbsp; Detail Point Per Rubrik</a>
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
