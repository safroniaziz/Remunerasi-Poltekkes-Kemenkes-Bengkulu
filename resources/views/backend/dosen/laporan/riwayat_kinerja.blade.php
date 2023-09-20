@extends('layouts.app')
@section('subTitle','Data Rubrik 01 Perkuliahan Teori')
@section('page','Data Rubrik 01 Perkuliahan Teori')
@section('subPage','Semua Data')
@section('sidebar')
    @include('layouts.partials.sidebar_dosen')
@endsection
@section('login_as')
    Halaman Dosen
@endsection
@section('user-login2')
    @if (isset($_SESSION['data']['namatitle']))
        {{ $_SESSION['data']['nama'] }}
    @endif
@endsection
@push('styles')
    <style>
        .loader {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
            height: 15%;
            background: url('{{ asset('assets/img/preloader.gif') }}') center no-repeat #fff;
        }
    </style> 
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-users"></i>&nbsp; Riwayat Kinerja Remunerasi
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <div class="col-md-12" style="margin-bottom: 10px !important;">
                            <div class="row">
                                <form action="{{ route('dosen.riwayatKinerjaCetak') }}" method="POST" id="form">
                                    {{ csrf_field() }} {{ method_field('POST') }}
                                    <div class="form-group col-md-12">
                                        <label for="">Pilih Periode Remunerasi</label>
                                        <select name="periode_id" id="periode_id" class="form-control">
                                            <option disabled selected>-- pilih periode --</option> 
                                            @foreach ($periodes as $periode)
                                                <option value="{{ $periode->id }}">{{ $periode->nama_periode }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-check-circle"></i>&nbsp; Cetak Riwayat Remunerasi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );

        $(document).on('submit','#form',function (event){
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
