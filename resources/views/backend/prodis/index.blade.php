@extends('layouts.app')
@section('subTitle','Data Program Studi')
@section('page','Data Program Studi')
@section('subPage','Semua Data')
@section('login_as')
    Selamat Datang,
@endsection
@section('user-login2')
    {{ Auth::user()->nama_user }}
@endsection
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection
@push('styles')
    @include('backend/prodis._loader')
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-clipboard"></i>&nbsp; Data Program Studi
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <div class="col-md-12" style="margin-bottom: 10px !important;">
                            <a onclick="generateProdi()" href="{{ route('prodi.generate') }}" class="btn btn-primary btn-sm btn-flat" id="generateProdi"><i class="fa fa-refresh fa-spin"></i>&nbsp; Sinkronisasi Data Siakad</a>
                        </div>
                        <div class="col-md-12" id="sync" style="display: none">
                            <div class="alert alert-warning">
                                <!-- Loading Spinner Wrapper-->
                                <div class="loader text-center">
                                    <div class="loader-inner">
    
                                        <!-- Animated Spinner -->
                                        <div class="lds-roller mb-3">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        
                                        <!-- Spinner Description Text [For Demo Purpose]-->
                                        <h4 class="font-weight-bold">Proses Sinkronisasi Ke SIAKAD sedang berjalan</h4>
                                        <p class="font-italic text-white">Harap untuk menunggu hingga proses selesai</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered" id="table" style="width:100%;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style="vertical-align:middle">Nama Prodi</th>
                                        <th style="vertical-align:middle">Nama Lengkap Prodi</th>
                                        <th style="vertical-align:middle">Nama Fakultas</th>
                                        <th style="vertical-align:middle; text-align:center">Verifikator</th>
                                        <th style="vertical-align:middle; text-align:center">Penanggung Jawab</th>
                                        <th style="text-align:center; vertical-align:middle">Informasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($prodis as $index =>  $prodi)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $prodi->nama_prodi }}</td>
                                            <td>{{ $prodi->nama_lengkap_prodi }}</td>
                                            <td>{{ $prodi->nmfak }}</td>
                                            <td style="text-align: center">{{ $prodi->verifikator ? $prodi->verifikator->nama : '-' }}</td>
                                            <td style="text-align: center">{{ $prodi->penanggungJawab ? $prodi->penanggungJawab->nama : '-' }}</td>
                                            <td class="text-center">
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('prodi.verifikator',[$prodi->id_prodi]) }}" class="btn btn-info btn-sm btn-flat">Verifikator</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('prodi.dosens',[$prodi->id_prodi]) }}" class="btn btn-success btn-sm btn-flat">Dosen</a>
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

        function generateProdi(){
            $('#generateProdi').hide();
            $('#sync').show(300);
            $('.loader').show(300);
        }
    </script>
@endpush
