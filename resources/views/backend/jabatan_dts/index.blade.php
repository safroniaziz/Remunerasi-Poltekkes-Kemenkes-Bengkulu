@extends('layouts.app')
@section('subTitle','Data Jabatan DT')
@section('page','Data Jabatan DT')
@section('subPage','Semua Data Jabatan DT')
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
                    <i class="fa fa-briefcase"></i>&nbsp;Manajemen Data Jabatan DT
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
                            <div style="margin-bottom: 15px !important;">
                                <a href="{{ route('jabatan_dt.create') }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>&nbsp; Tambah Jabatan DT</a>
                            </div>
                        </div>

                        <div class="col-md-12" style="margin-bottom: 20px;">
                            <div class="callout callout-info" style="background: #eef7f9; border: 1px solid #bce8f1; border-left: 5px solid #00c0ef; padding: 15px 20px; border-radius: 4px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; margin-bottom: 0;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <i class="fa fa-info-circle text-info" style="font-size: 22px; color: #31708f;"></i>
                                    <div>
                                        <span style="font-weight: 700; display: block; color: #31708f; font-size: 14px;">Pengaturan PIR Masal</span>
                                        <span style="font-size: 12px; color: #31708f;">Nilai PIR saat ini berlaku untuk seluruh jabatan DT.</span>
                                    </div>
                                </div>
                                <form action="{{ route('jabatan_dt.update_all_pir') }}" method="POST" class="form-bulk-pir" style="margin-bottom: 0; display: flex; align-items: center; gap: 10px;">
                                    {{ csrf_field() }} {{ method_field('PATCH') }}
                                    <div class="input-group" style="width: 200px; margin-bottom: 0;">
                                        <span class="input-group-addon" style="background-color: #f4f4f4; border: 1px solid #ccc; color: #333; font-weight: bold;">Rp</span>
                                        <input type="text" class="form-control" id="bulk_pir" name="pir" value="{{ $jabatandts->first()->pir ?? 2500 }}" style="border-radius: 0; height: 34px; background-color: #fff; color: #333; border: 1px solid #ccc; font-weight: 600;">
                                    </div>
                                    <button type="submit" class="btn btn-success btn-flat btnSubmitBulk" style="height: 34px; line-height: 1.42857143; padding: 6px 12px; font-weight: bold;"><i class="fa fa-save"></i>&nbsp; Simpan PIR</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped table-bordered" id="table" style="width:100%; margin-bottom: 5px !important;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style=" vertical-align:middle">Nama Jabatan DT</th>
                                        <th style="text-align:center; vertical-align:middle">Grade</th>
                                        <th style=" vertical-align:middle; text-align:center">Harga Point DT</th>
                                        <th style="text-align:center; vertical-align:middle">Gaji BLU</th>
                                        <th style="text-align:center; vertical-align:middle">PIR</th>
                                        <th style="text-align:center; vertical-align:middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($jabatandts as $index => $jabatandt)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>
                                            {{ $jabatandt->nama_jabatan_dt }}</td>
                                            <td style="text-align: center;">{{ $jabatandt->grade ?? '-' }}</td>
                                            <td style="text-align: center;">Rp. {{ number_format(($jabatandt->harga_point_dt)) ?? '-' }},-</td>
                                            <td style="text-align: center;">Rp. {{ number_format($jabatandt->gaji_blu) }}</td>
                                            <td style="text-align: center;">Rp. {{ number_format($jabatandt->pir) ?? '-' }},-</td>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('jabatan_dt.edit',[$jabatandt->slug]) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                       </td>
                                                        <td>
                                                            <form action="{{ route('jabatan_dt.delete',[$jabatandt->id]) }}" method="POST">
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

        $(document).on('submit','.form-bulk-pir',function (event){
            event.preventDefault();
            var btn = $(this).find(".btnSubmitBulk");
            btn.attr("disabled", true);
            var originalHtml = btn.html();
            btn.html('<i class="fa fa-spinner fa-spin"></i>&nbsp; Menyimpan');
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                typeData: "JSON",
                data: new FormData(this),
                processData:false,
                contentType:false,
                success : function(res) {
                    toastr.success(res.text, 'Yeay, Berhasil');
                    setTimeout(function () {
                        window.location.href=res.url;
                    } , 500);
                },
                error:function(xhr){
                    toastr.error(xhr.responseJSON.text, 'Ooopps, Ada Kesalahan');
                    setTimeout(function() {
                        btn.prop('disabled', false);
                        btn.html(originalHtml);
                    }, 500);
                }
            })
        });
    </script>
@endpush

