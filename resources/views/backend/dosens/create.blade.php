@extends('layouts.app')
@section('subTitle','Data Dosen')
@section('page','Data Dosen')
@section('subPage','Tambah Data Dosen')
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
                    <i class="fa fa-plus"></i>&nbsp;Form Edit Data Dosen
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <form action="{{ route('dosen.store') }}" method="POST" class="form">
                            {{ csrf_field() }} {{ method_field('POST') }}
                            <div class="form-group col-md-6" >
                                <label for="nama" class="col-form-label">Nama Lengkap Dosen</label>
                                <input type="text" class="form-control" id="nama" name="nama" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">NIDN</label>
                                <input type="text" class="form-control" id="nidn" name="nidn" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Jurusan</label>
                                <select name="jurusan" class="form-control" id="jurusan">
                                    <option disabled selected>-- pilih jurusan --</option>
                                    <option value="gizi">Gizi</option>
                                    <option value="kebidanan">Kebidanan</option>
                                    <option value="keperawatan">Keperawatan</option>
                                    <option value="analis_kesehatan">Analis Kesehatan</option>
                                    <option value="promosi_kesehatan">Promosi Kesehatan</option>
                                    <option value="kesehatan_lingkungan">Kesehatan Lingkungan</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Prodi Homebase</label>
                                <select name="id_prodi_homebase" class="form-control" id="id_prodi_homebase">
                                    <option disabled selected>-- pilih prodi homebase --</option>
                                    @foreach ($prodis as $prodi)
                                        <option value="{{ $prodi->id_prodi }}" >{{ $prodi->nama_prodi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control" id="jenis_kelamin">
                                    <option disabled selected>-- pilih jenis kelamin --</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">E-mail</label>
                                <input type="text" class="form-control" id="email" name="email" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Nomor Rekening</label>
                                <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">NPWP</label>
                                <input type="text" class="form-control" id="npwp" name="npwp" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Nomor WhatsApp</label>
                                <input type="text" class="form-control" id="no_whatsapp" name="no_whatsapp" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Jabatan DT</label>
                                <select name="jabatan_dt_id" id="jabatan_dt_id" class="form-control">
                                    <option disabled selected>-- pilih jabatan DT --</option>
                                    @foreach ($jabatanDts as $jabatanDt)
                                        <option value="{{ $jabatanDt->id }}">{{ $jabatanDt->nama_jabatan_dt }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Dosen Tersertifikasi?</label>
                                <select name="is_serdos" class="form-control" id="is_serdos">
                                    <option disabled selected>-- pilih satu --</option>
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" style="display: none;" id="no_sertifikat_serdos">
                                <label for="nip" class="col-form-label">Nomor Sertifikat Serdos</label>
                                <input type="text" class="form-control"  name="no_sertifikat_serdos" >
                            </div>

                            <div class="col-md-12" style="margin-bottom:10px !important; text-align:center">
                                <a href="{{ route('dosen') }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
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
