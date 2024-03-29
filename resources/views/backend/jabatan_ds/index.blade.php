@extends('layouts.app')
@section('subTitle','Data Jabatan DS')
@section('page','Data Jabatan DS')
@section('subPage','Semua Data Jabatan DS')
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
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-widsh: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-address-book"></i>&nbsp;Manejemen Data Jabatan DS
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
                                <a href="{{ route('jabatan_ds.create') }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>&nbsp; Tambah Jabatan DS</a>
                            </div>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped table-bordered" id="table" style="width:100%; margin-bottom: 5px !important;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style=" vertical-align:middle">Nama Jabatan DS</th>
                                        <th style="text-align:center; vertical-align:middle">Grade</th>
                                        <th style=" vertical-align:middle">Harga Point DS</th>
                                        <th style="text-align:center; vertical-align:middle">Gaji BLU</th>
                                        <th style="text-align:center; vertical-align:middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($jabatands as $index => $jabatands)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>
                                            {{ $jabatands->nama_jabatan_ds }}</td>
                                            <td style="text-align: center;">{{ $jabatands->grade ?? '-' }}</td>
                                            <td style="text-align: center;">Rp. {{ number_format(($jabatands->harga_point_ds)) ?? '-' }},-</td>
                                            <td style="text-align: center;">Rp. {{ number_format(($jabatands->gaji_blu )) ?? '-' }},-</td>
                                            <td>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('jabatan_ds.edit',[$jabatands->slug]) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                   </td>
                                                    <td>
                                                        <form action="{{ route('jabatan_ds.delete',[$jabatands->id]) }}" method="POST">
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
