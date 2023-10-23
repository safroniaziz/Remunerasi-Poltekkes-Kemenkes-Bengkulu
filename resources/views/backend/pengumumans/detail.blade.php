@extends('layouts.app')
@section('subTitle','Data Verifikator Program Studi')
@section('page','Data Verifikator Program Studi')
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
    <link href="{{ asset('assets/select2/dist/css/select2.css') }}" rel="stylesheet"
    type="text/css" />
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-clipboard"></i>&nbsp; Detail Pengumuman
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover table-striped" style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <a href="{{ route('pengumuman') }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Judul Pengumuman</td>
                                        <td>
                                            {{ $pengumuman->judul_pengumuman }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Isi Pengumuman</td>
                                        <td>
                                            {!! $pengumuman->isi_pengumuman !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Pengumuman</td>
                                        <td>
                                            {{ $pengumuman->tanggal_pengumuman }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>File Pengumuman</td>
                                        <td>
                                            @if ($pengumuman->file_pengumuman != null || $pengumuman->file_pengumuman != "")
                                                <a href="{{ route('pengumuman.download',[$pengumuman->id]) }}" ><i class="fa fa-download"></i>&nbsp; Download File</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
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
    <script src="{{ asset('assets/select2/dist/js/select2.full.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush