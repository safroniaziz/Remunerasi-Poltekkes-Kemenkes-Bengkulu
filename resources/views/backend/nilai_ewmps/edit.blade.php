@extends('layouts.app')
@section('subTitle','Data Nilai Ewmp')
@section('page','Data Nilai Ewmp')
@section('subPage','Edit Data Nilai Ewmp')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-edit"></i>&nbsp;Form Edit Data Nilai Ewmp
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <form action="{{ route('nilai_ewmp.update',[$nilaiewmp->id]) }}" method="POST" id="form-edit">
                            {{ csrf_field() }} {{ method_field('PATCH') }}

                            <div class="form-group col-md-6" >
                                <label for="exampleInputEmail1">Pilih kelompok rubrik Terlebih Dahulu</label>
                                <select name="kelompok_rubrik_id" id="kelompok_rubrik_id"  class="form-control @error('kelompok_rubrik_id') is-invalid @enderror">
                                    <option  selected>-- pilih kelompok rubrik --</option>
                                    @foreach ($kelompokrubriks as $kelompokrubrik)
                                        <option
                                            @if ($nilaiewmp->kelompok_rubrik_id == $kelompokrubrik->id)
                                                selected
                                            @endif
                                        value="{{ $kelompokrubrik->id }}">{{ $kelompokrubrik->nama_kelompok_rubrik }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    @if ($errors->has('kelompok_rubrik_id'))
                                        <small class="form-text text-danger">{{ $errors->first('kelompok_rubrik_id') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nama" class="col-form-label">Nama Rubrik</label>
                                <input type="text" class="form-control" value="{{ $nilaiewmp->nama_rubrik }}" id="nama_rubrik" name="nama_rubrik" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nama" class="col-form-label">Nama Tabel Rubrik</label>
                                <input type="text" class="form-control" value="{{ $nilaiewmp->nama_tabel_rubrik }}" id="nama_tabel_rubrik" name="nama_tabel_rubrik" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="nip" class="col-form-label">Ewmp</label>
                                <input type="text" class="form-control" value="{{ $nilaiewmp->ewmp }}" id="ewmp" name="ewmp" >
                            </div>

                            <div class="col-md-12" style="margin-bottom:10px !important; text-align:center">
                                <a href="{{ route('nilai_ewmp') }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
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
