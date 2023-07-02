@extends('layouts.app')
@section('subTitle','Data Dosen')
@section('page','Data Dosen')
@section('subPage','Edit Data Dosen')
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
                        <form action="{{ route('dosen.update',[$pegawai->slug]) }}" method="POST" id="form-edit">
                            {{ csrf_field() }} {{ method_field('PATCH') }}
                            <div class="form-group col-md-6" >
                                <label for="nama" class="col-form-label">Nama Lengkap Dosen</label>
                                <input type="text" class="form-control" value="{{ $pegawai->nama }}" id="nama" name="nama" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">NIP</label>
                                <input type="text" class="form-control" value="{{ $pegawai->nip }}" id="nip" name="nip" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">NIDN</label>
                                <input type="text" class="form-control" value="{{ $pegawai->nidn }}" id="nidn" name="nidn" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control" id="jenis_kelamin">
                                    <option disabled selected>-- pilih jenis kelamin --</option>
                                    <option value="L" {{ $pegawai->jenis_kelamin == "L" ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="P" {{ $pegawai->jenis_kelamin == "P" ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">E-mail</label>
                                <input type="text" class="form-control" value="{{ $pegawai->email }}" id="email" name="email" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Jurusan</label>
                                <select name="jurusan" class="form-control" id="jurusan">
                                    <option disabled selected>-- pilih jurusan --</option>
                                    <option value="gizi" {{ $pegawai->jurusan == "gizi" ? 'selected' : '' }}>Gizi</option>
                                    <option value="kebidanan" {{ $pegawai->jurusan == "kebidanan" ? 'selected' : '' }}>Kebidanan</option>
                                    <option value="keperawatan" {{ $pegawai->jurusan == "keperawatan" ? 'selected' : '' }}>Keperawatan</option>
                                    <option value="analis_kesehatan" {{ $pegawai->jurusan == "analis_kesehatan" ? 'selected' : '' }}>Analis Kesehatan</option>
                                    <option value="promosi_kesehatan" {{ $pegawai->jurusan == "promosi_kesehatan" ? 'selected' : '' }}>Promosi Kesehatan</option>
                                    <option value="kesehatan_lingkungan" {{ $pegawai->jurusan == "kesehatan_lingkungan" ? 'selected' : '' }}>Kesehatan Lingkungan</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Nomor Rekening</label>
                                <input type="text" class="form-control" value="{{ $pegawai->nomor_rekening }}" id="nomor_rekening" name="nomor_rekening" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">NPWP</label>
                                <input type="text" class="form-control" value="{{ $pegawai->npwp }}" id="npwp" name="npwp" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Nomor WhatsApp</label>
                                <input type="text" class="form-control" value="{{ $pegawai->no_whatsapp }}" id="no_whatsapp" name="no_whatsapp" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Jabatan DT</label>
                                <select name="jabatan_dt_id" id="jabatan_dt_id" class="form-control">
                                    <option disabled selected>-- pilih jabatan DT --</option>
                                    @foreach ($jabatanDts as $jabatanDt)
                                        <option @if ($jabatanDt->id == $pegawai->jabatan_dt_id)
                                            selected
                                        @endif value="{{ $jabatanDt->id }}">{{ $jabatanDt->nama_jabatan_dt }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Dosen Tersertifikasi?</label>
                                <select name="is_serdos" class="form-control" id="is_serdos">
                                    <option disabled selected>-- pilih satu --</option>
                                    <option value="ya" {{ $pegawai->is_serdos == 1 ? 'selected' : '' }}>Ya</option>
                                    <option value="tidak" {{ $pegawai->is_serdos == 0 ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="no_sertifikat_serdos">
                                <label for="nip" class="col-form-label">Nomor Sertifikat Serdos</label>
                                <input type="text" class="form-control" value="{{ $pegawai->no_sertifikat_serdos }}" name="no_sertifikat_serdos">
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
