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
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-plus"></i>&nbsp;Form Tambah Data Jabatan DS
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <form action="{{ route('jabatan_ds.store') }}" method="POST" id="form-tambah">
                            {{ csrf_field() }} {{ method_field('POST') }}
                            <div class="form-group col-md-6" >
                                <label for="nama_jabatan_ds" class="col-form-label">Nama Jabatan DS</label>
                                <input type="text" class="form-control" id="nama_jabatan_ds" name="nama_jabatan_ds" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="grade" class="col-form-label">Grade</label>
                                <input type="text" class="form-control" id="grade" name="grade" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="harga_point_ds" class="col-form-label">Harga Point DS</label>
                                <input type="text" class="form-control" id="harga_point_ds" name="harga_point_ds" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="gaji_blu" class="col-form-label">Gaji BLU</label>
                                <input type="text" class="form-control" id="gaji_blu" name="gaji_blu" >
                            </div>

                            <div class="col-md-12" style="margin-bottom:10px !important; text-align:center">
                                <a href="{{ route('jabatan_ds') }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                                <button type="submit" class="btn btn-primary btn-sm btn-flat mb-2"><i class="fa fa-check-circle"></i>&nbsp;Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $(document).on('change','#is_serdos',function(){
                var is_serdos = $(this).val();
                if (is_serdos == "ya") {
                    $('#no_sertifikat_serdos').show(300);
                }else{
                    $('#no_sertifikat_serdos').hide(300);
                }
            })
        });

        $(document).on('submit','#form-tambah',function (event){
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                typeData: "JSON",
                data: new FormData(this),
                processData:false,
                contentType:false,
                success : function(res) {
                    $("#btnSubmit"). attr("disabled", true);
                    toastr.success(res.text, 'Yeay, Berhasil');
                    setTimeout(function () {
                        window.location.href=res.url;
                    } , 500);
                },
                error:function(xhr){
                    toastr.error(xhr.responseJSON.text, 'Ooopps, Ada Kesalahan');
                }
            })
        });
    </script>
@endpush
