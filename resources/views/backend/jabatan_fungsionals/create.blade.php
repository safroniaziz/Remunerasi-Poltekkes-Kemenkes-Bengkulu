@extends('layouts.app')
@section('subTitle','Data Jabatan Fungsional')
@section('page','Data Jabatan Fungsional')
@section('subPage','Semua Data Jabatan Fungsional')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-plus"></i>&nbsp;Form Tambah Data Jabatan Fungsional
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <form action="{{ route('jabatan_fungsional.store') }}" method="POST" id="form-tambah">
                            {{ csrf_field() }} {{ method_field('POST') }}
                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nama_jabatan_fungsional" class="col-form-label">Nama Jabatan Fungsional</label>
                                <input type="text" class="form-control" id="nama_jabatan_fungsional" name="nama_jabatan_fungsional" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="tmt_jabatan_fungsional" class="col-form-label">TMT Jabatan Fungsional</label>
                                <input type="text" class="form-control" id="tmt_jabatan_fungsional" name="tmt_jabatan_fungsional" >
                            </div>

                            <div class="col-md-12" style="margin-bottom:10px !important; text-align:center">
                                <a href="{{ route('jabatan_fungsional') }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
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
