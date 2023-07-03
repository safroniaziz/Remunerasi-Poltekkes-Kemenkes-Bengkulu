@extends('layouts.app')
@section('subTitle','Data Rubrik 01 Perkuliahan Teori')
@section('page','Data Rubrik 01 Perkuliahan Teori')
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
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-users"></i>&nbsp; Point Rubrik Dosen
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered" id="table" style="width:100%;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style="text-align:center; vertical-align:middle">NIP</th>
                                        <th style="text-align:center; vertical-align:middle">Nama Dosen</th>
                                        <th style="text-align:center; vertical-align:middle">Total Point</th>
                                        <th style="text-align:center; vertical-align:middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($dosens as $index =>  $dosen)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $dosen->nip }}</td>
                                            <td>{{ $dosen->nama }}</td>
                                            <td>{{ $dosen->total_point }}</td>
                                            <td>
                                                <a href="{{ route('point_rubrik_dosen.detail',[$dosen->nip]) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-info-circle"></i>&nbsp; Detail</a>
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
