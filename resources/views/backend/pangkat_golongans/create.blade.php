@extends('layouts.app')
@section('subTitle','Data Pangkat Golongan')
@section('page','Data Pangkat Golongan')
@section('subPage','Semua Data Pangkat Golongan')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-plus"></i>&nbsp;Form Tambah Data Pangkat Golongan
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <form action="{{ route('pangkat_golongan.store') }}" method="POST" id="form-tambah">
                            {{ csrf_field() }} {{ method_field('POST') }}
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Pilih NIP terlebih dahulu</label>
                                <select name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror">
                                    <option disabled selected>-- Pilih NIP --</option>
                                    @foreach ($dosens as $dosen)
                                        <option value="{{ $dosen->nip }}">{{ $dosen->nama }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    @if ($errors->has('nip'))
                                        <small class="form-text text-danger">{{ $errors->first('nip') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-6" >
                                <label for="nama_pangkat" class="col-form-label">Nama Pangkat</label>
                                <input type="text" class="form-control" id="nama_pangkat" name="nama_pangkat" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="golongan" class="col-form-label">Golongan</label>
                                <input type="text" class="form-control" id="golongan" name="golongan" >
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="tmt_pangkat_golongan" class="col-form-label">TMT Pangkat Golongan</label>
                                <input type="text" class="form-control" id="tmt_pangkat_golongan" name="tmt_pangkat_golongan" >
                            </div>

                            <div class="col-md-12" style="margin-bottom:10px !important; text-align:center">
                                <a href="{{ route('pangkat_golongan') }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
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
