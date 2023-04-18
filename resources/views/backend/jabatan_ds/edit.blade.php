@extends('layouts.app')
@section('subTitle','Data Jabatan Ds')
@section('page','Data Jabatan Ds')
@section('subPage','Edit Data Jabatan Ds')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-widsh: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-edit"></i>&nbsp;Form Edit Data Jabatan Ds
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <form action="{{ route('jabatan_ds.update',[$jabatands->slug]) }}" method="POST" id="form-edit">
                            {{ csrf_field() }} {{ method_field('PATCH') }}
                            <div class="form-group col-md-6" >
                                <label for="nama" class="col-form-label">Nama Jabatan Ds</label>
                                <input type="text" class="form-control" value="{{ $jabatands->nama_jabatan_ds }}" id="nama_jabatan_ds" name="nama_jabatan_ds" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Grade</label>
                                <input type="text" class="form-control" value="{{ $jabatands->grade }}" id="grade" name="grade" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Harga Point Ds</label>
                                <input type="text" class="form-control" value="{{ $jabatands->harga_point_ds }}" id="harga_point_ds" name="harga_point_ds" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Job Value</label>
                                <input type="text" class="form-control" value="{{ $jabatands->job_value }}" id="job_value" name="job_value" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">PIR</label>
                                <input type="text" class="form-control" value="{{ $jabatands->pir }}" id="pir" name="pir" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Harga Jabatan Ds</label>
                                <input type="text" class="form-control" value="{{ $jabatands->harga_jabatan }}" id="harga_jabatan" name="harga_jabatan" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Gaji BLU</label>
                                <input type="text" class="form-control" value="{{ $jabatands->gaji_blu }}" id="gaji_blu" name="gaji_blu" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Insentif Maksimum</label>
                                <input type="text" class="form-control" value="{{ $jabatands->insentif_maximum }}" id="insentif_maximum" name="insentif_maximum" >
                            </div>

                            <div class="col-md-12" style="margin-bottom:10px !important; text-align:center">
                                <a href="{{ route('jabatan_ds') }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                                <button type="submit" id="btnSubmit" class="btn btn-primary btn-sm btn-flat mb-2"><i class="fa fa-check-circle"></i>&nbsp;Simpan Data</button>
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
        $(document).on('submit','#form-edit',function (event){
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
