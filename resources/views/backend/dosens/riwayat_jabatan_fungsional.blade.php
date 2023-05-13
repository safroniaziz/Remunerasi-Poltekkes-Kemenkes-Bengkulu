@extends('layouts.app')
@section('subTitle','Data Jabatan fungsional')
@section('page','Data Jabatan fungsional')
@section('subPage','Semua Data Jabatan fungsional')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-briefcase"></i>&nbsp;Manajemen Data Jabatan fungsional
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
                        <div class="col-md-12">
                            <div style="margin-bottom: 10px !important;">
                                <button type="button" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-default">
                                    <i class="fa fa-plus"></i>&nbsp; Tambah Periode Penilaian
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped table-bordered" id="table" style="width:100%; margin-bottom: 5px !important;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style=" vertical-align:middle">Nama Dosen</th>
                                        <th style=" vertical-align:middle">Jabatan fungsional</th>
                                        <th style=" vertical-align:middle">TMT Jabatan</th>
                                        <th style=" vertical-align:middle">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($pegawai->jabatanFungsionals()->get() as $index => $jabatanfungsional)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td >{{ $pegawai->nama }}</a></td>
                                            <td >{{ $jabatanfungsional->nama_jabatan_fungsional }}</a></td>
                                            <td >{{ $jabatanfungsional->tmt_jabatan_fungsional }}</td>
                                            <td>
                                                @if ($jabatanfungsional->is_active == 1)
                                                    <label for="" class="label label-success"><i class="fa fa-check-circle"></i>&nbsp; Aktif</label>
                                                @endif
                                           </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @include('backend/dosens.partials.modal_add')
                    </div>
                    @include('backend/dosens.partials.modal_edit')
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