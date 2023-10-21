@extends('layouts.app')
@section('subTitle','Data Jabatan DT')
@section('page','Data Jabatan DT')
@section('subPage','Edit Data Jabatan DT')
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
                    <i class="fa fa-edit"></i>&nbsp;Form Edit Data Jabatan DT
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <form action="{{ route('jabatan_dt.update',[$jabatandt->slug]) }}" method="POST" class="form">
                            {{ csrf_field() }} {{ method_field('PATCH') }}
                            <div class="form-group col-md-6" >
                                <label for="nama" class="col-form-label">Nama Jabatan DT</label>
                                <input type="text" class="form-control" value="{{ $jabatandt->nama_jabatan_dt }}" id="nama_jabatan_dt" name="nama_jabatan_dt" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Grade</label>
                                <input type="text" class="form-control" value="{{ $jabatandt->grade }}" id="grade" name="grade" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Harga Point DT</label>
                                <input type="text" class="form-control" value="{{ $jabatandt->harga_point_dt }}" id="harga_point_dt" name="harga_point_dt" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Gaji BLU</label>
                                <input type="text" class="form-control" value="{{ $jabatandt->gaji_blu }}" id="gaji_blu" name="gaji_blu" >
                            </div>

                            <div class="col-md-12" style="margin-bottom:10px !important; text-align:center">
                                <a href="{{ route('jabatan_dt') }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
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

        $(document).on('submit','.form',function (event){
            event.preventDefault();
            $(".btnSubmit"). attr("disabled", true);
            $('.btnSubmit').html('<i class="fa fa-check-circle"></i>&nbsp; Menyimpan');  // Mengembalikan teks tombol
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                typeData: "JSON",
                data: new FormData(this),
                processData:false,
                contentType:false,
                success : function(res) {
                    $(".btnSubmit"). attr("disabled", true);
                    toastr.success(res.text, 'Yeay, Berhasil');
                    setTimeout(function () {
                        window.location.href=res.url;
                    } , 500);
                },
                error:function(xhr){
                    toastr.error(xhr.responseJSON.text, 'Ooopps, Ada Kesalahan');
                    setTimeout(function() {
                        $(".btnSubmit").prop('disabled', false);  // Mengaktifkan tombol kembali
                        $(".btnSubmit").html('<i class="fa fa-check-circle"></i>&nbsp; Simpan Data');  // Mengembalikan teks tombol
                    }, 500); // Waktu dalam milidetik (2000 ms = 2 detik)
                }
            })
        });
    </script>
@endpush
