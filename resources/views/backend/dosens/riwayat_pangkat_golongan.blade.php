@extends('layouts.app')
@section('subTitle','Data Jabatan fungsional')
@section('page','Data Jabatan fungsional')
@section('subPage','Semua Data Jabatan fungsional')
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
                                <a href="{{ route('dosen') }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                                <button type="button" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-default">
                                    <i class="fa fa-plus"></i>&nbsp; Tambah Riwayat Pangkat & Golongan
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped table-bordered" id="table" style="width:100%; margin-bottom: 5px !important;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style=" vertical-align:middle">Nama Dosen</th>
                                        <th style=" vertical-align:middle">Pangkat</th>
                                        <th style=" vertical-align:middle">Golongan</th>
                                        <th style=" vertical-align:middle">TMT Pangkat & Golongan</th>
                                        <th style=" vertical-align:middle; text-align:center">Status</th>
                                        <th style=" vertical-align:middle; text-align:center">Ubah Status</th>
                                        <th style=" vertical-align:middle; text-align:center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($pegawai->pangkatGolongans()->orderBy('created_at','desc')->get() as $index => $pangkatGolongan)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td >{{ $pegawai->nama }}</a></td>
                                            <td >{{ $pangkatGolongan->nama_pangkat }}</a></td>
                                            <td >{{ $pangkatGolongan->golongan }}</a></td>
                                            <td >{{ $pangkatGolongan->tmt_pangkat_golongan->isoFormat('dddd, D MMMM Y') }}</td>
                                            <td>
                                                @if ($pangkatGolongan->is_active == 1)
                                                    <label for="" class="label label-success"><i class="fa fa-check-circle"></i>&nbsp; Aktif</label>
                                                @else
                                                    <label for="" class="label label-danger"><i class="fa fa-minus"></i>&nbsp; Tidak Aktif</label>
                                                @endif
                                           </td>
                                           <td class="text-center">
                                                @if ($pangkatGolongan->is_active == 1)
                                                    <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-thumbs-up"></i></button>
                                                @else
                                                    <form action="{{ route('dosen.riwayat_pangkat_golongan.set_active',[$pegawai->slug, $pangkatGolongan->id]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-thumbs-down"></i></button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('dosen.riwayat_pangkat_golongan.delete',[$pegawai->slug, $pangkatGolongan->id]) }}" method="POST">
                                                    {{ csrf_field() }} {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-danger btn-sm btn-flat show_confirm"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @include('backend/dosens.partials.modal_add_riwayat_pangkat_golongan')
                    </div>
                    @include('backend/dosens.partials.modal_edit_riwayat_pangkat_golongan')
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );

        $('.show_confirm').click(function(event) {
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: `Apakah Anda Yakin?`,
                text: "Harap untuk memeriksa kembali sebelum menghapus data.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                form.submit();
                }
            });
        });
    </script>
@endpush
