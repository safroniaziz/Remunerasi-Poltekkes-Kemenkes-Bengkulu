@extends('layouts.app')
@section('subTitle','Dashboard')
@section('page','Dashboard')
@push('styles')
    <link href="{{ asset('assets/select2/dist/css/select2.css') }}" rel="stylesheet"
    type="text/css" />
    @include('backend/generate_point_rubrik._loader')
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-home"></i>&nbsp;Generate Point Rubrik
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="callout callout-warning" style="margin-bottom: 15px !important;">
                                <h4>Generate Point Rubrik</h4>
                                <p>Generate Point Rubrik digunakan untuk melakukan proses rekapitulasi point di setiap rubrik, selain itu proses ini digunakan untuk melakukan rekapitulasi jumlah point per dosen serta per jurusan di periode aktif</p>
                            </div>
                        </div>
                        <div class="col-md-12" id="sync" style="display: none">
                            <div class="alert alert-warning">
                                <!-- Loading Spinner Wrapper-->
                                <div class="loader text-center">
                                    <div class="loader-inner">
    
                                        <!-- Animated Spinner -->
                                        <div class="lds-roller mb-3">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        
                                        <!-- Spinner Description Text [For Demo Purpose]-->
                                        <h4 class="font-weight-bold">Proses Generate Point Sedang Berjalan</h4>
                                        <p class="font-italic text-white">Harap untuk menunggu hingga proses selesai</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            @if (!count($dataRubriks)>0)
                                <a onclick="generatePointRubrik()" href="{{ route('generate_point_rubrik.generate') }}" class="btn btn-primary btn-sm btn-flat" id="btnGenerate"><i class="fa fa-refresh fa-spin"></i>&nbsp; Generate Point Rubrik</a>
                            @else
                                <div class="row">
                                    <form action="{{ route('generate_point_massal') }}" method="POST">
                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                        <div class="col-md-12" id="btnPerbaruiMassal" style="margin-bottom: 3px !important;">
                                            <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-refresh fa-spin"></i>&nbsp; Perbarui Massal</button>
                                        </div>

                                        <div class="col-md-12">
                                            <table class="table table-hover table-bordered table-striped" style="width: 100%" id="table">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th style="text-align:center; vertical-align:middle" >
                                                            <input type="checkbox" class="selectbox selectall">
                                                        </th>
                                                        <th style="vertical-align:middle">No</th>
                                                        <th style="vertical-align:middle">Nama Rubrik</th>
                                                        <th style="vertical-align:middle">Periode</th>
                                                        <th style="vertical-align:middle" class="text-center">Total Point</th>
                                                        <th style="vertical-align:middle">Status Rubrik</th>
                                                        <th style="vertical-align:middle" class="text-center">Perbarui Point</th>
                                                        <th style="vertical-align:middle" class="text-center">Detail Isian Rubrik</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($dataRubriks as $index=> $dataRubrik)
                                                        @php
                                                            $statusRubrik = DB::table($dataRubrik->kode_rubrik)->select(DB::raw('IFNULL(sum(point),0) as total_point'))
                                                                        ->where('periode_id',$periode->id)
                                                                        ->where('is_bkd',0)
                                                                        ->where('is_verified',1)
                                                                        ->first();
                                                        @endphp
                                                        <tr  @if (number_format($statusRubrik->total_point,2) != number_format($dataRubrik->total_point,2))
                                                            style="background:#f2dede"
                                                        @endif>
                                                            
                                                            @if (number_format($statusRubrik->total_point,2) == number_format($dataRubrik->total_point,2))
                                                                <td style="text-align:center;">
                                                                    <input type="checkbox" disabled>
                                                                </td>
                                                            @else
                                                                <td style="text-align:center;">
                                                                    <input type="checkbox" name="kode_rubriks[]" class="selectbox" value="{{ $dataRubrik->kode_rubrik }}">
                                                                </td>
                                                            @endif
                                                            <td>{{ $index+1 }}</td>
                                                            <td style="width: 40% !important; ">{{ $dataRubrik->nama_rubrik }}</td>
                                                            <td>{{ $dataRubrik->periode->nama_periode }}</td>
                                                            <td class="text-center" style="font-weight: bold;">{{ $dataRubrik->total_point }}</td>
                                                            <td style="width:15% !important; text-align:center">
                                                                @if (number_format($statusRubrik->total_point,2) != number_format($dataRubrik->total_point,2))
                                                                    <a class="text-danger">
                                                                        <i class="fa fa-times-circle-o "></i>&nbsp; Belum Diperbarui
                                                                    </a>
                                                                @else
                                                                    <a class="text-success">
                                                                        <i class="fa fa-check-circle"></i>&nbsp; Sudah Diperbarui                                                        
                                                                    </a>
                                                                @endif
                                                            </td>
                                                            <td style="text-align: center"> 
                                                                @if (number_format($statusRubrik->total_point,2) != number_format($dataRubrik->total_point,2))
                                                                    <a href="{{ route('generate_point_per_rubrik',[$dataRubrik->kode_rubrik]) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-refresh fa-spin"></i>&nbsp; Perbarui</a>
                                                                @else
                                                                    <a class="btn btn-primary btn-sm btn-flat" disabled style="cursor: not-allowed"><i class="fa fa-refresh"></i>&nbsp; Perbarui</a>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if (number_format($statusRubrik->total_point,2) != number_format($dataRubrik->total_point,2))
                                                                    <a class="btn btn-info btn-flat btn-sm" disabled ><i class="fa fa-info-circle"></i>&nbsp; Detail</a>
                                                                @else
                                                                    <a href="{{ route('detail_isian_rubrik',[$dataRubrik->kode_rubrik]) }}" class="btn btn-info btn-flat btn-sm"><i class="fa fa-info-circle"></i>&nbsp; Detail</a>
                                                                @endif
                                                                
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            @endif
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
                ordering : false,
            });
        } );

        function generatePointRubrik(){
            $('#sync').show(300);
            $('.loader').show(300);
            $('#btnGenerate').attr('disabled','disabled');
        }

        // FOR DEMO PURPOSE
        $(window).on('load', function () {
            var loadingCounter = setInterval(function () {
                var count = parseInt($('.countdown').html());
                if (count !== 0) {
                    $('.countdown').html(count - 1);
                } else {
                    clearInterval();
                }
            }, 1000);
        });
        $('#reload').on('click', function (e) {
            e.preventDefault();
            location.reload();
        });

        $('.selectall').click(function(){
            $('.selectbox').prop('checked', $(this).prop('checked'));
        });
    </script>
@endpush