@extends('layouts.app')
@section('subTitle','Data Riwayat Point')
@section('page','Data Riwayat Point')
@section('subPage','Semua Data Riwayat Point')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-plus"></i>&nbsp;Form Tambah Data Riwayat Point
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <form action="{{ route('riwayat_point.store') }}" method="POST" id="form-tambah">
                            {{ csrf_field() }} {{ method_field('POST') }}

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Pilih Rubrik terlebih dahulu</label>
                                <select name="rubrik_id" id="rubrik_id" class="form-control @error('rubrik_id') is-invalid @enderror">
                                    <option disabled selected>-- Pilih periode --</option>
                                    @foreach ($periodes as $periode)
                                        <option value="{{ $periode->id }}">{{ $periode->nama_periode }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    @if ($errors->has('periode_id'))
                                        <small class="form-text text-danger">{{ $errors->first('periode_id') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Pilih periode terlebih dahulu</label>
                                <select name="periode_id" id="periode_id" class="form-control @error('periode_id') is-invalid @enderror">
                                    <option disabled selected>-- Pilih periode --</option>
                                    @foreach ($periodes as $periode)
                                        <option value="{{ $periode->id }}">{{ $periode->nama_periode }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    @if ($errors->has('periode_id'))
                                        <small class="form-text text-danger">{{ $errors->first('periode_id') }}</small>
                                    @endif
                                </div>
                            </div>

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
                                <label for="point" class="col-form-label">Point</label>
                                <input type="text" class="form-control" id="point" name="point" >
                            </div>

                            <div class="col-md-12" style="margin-bottom:10px !important; text-align:center">
                                <a href="{{ route('riwayat_point') }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
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
