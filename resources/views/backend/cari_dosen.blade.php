@extends('layouts.app')
@section('subTitle','Dashboard')
@section('page','Dashboard')
@push('styles')
    <link href="{{ asset('assets/select2/dist/css/select2.css') }}" rel="stylesheet"
    type="text/css" />
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-home"></i>&nbsp;Silahkan Ketik Nama/Nip Dosen
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <form action="{{ route('cari_dosen.post') }}" method="POST" id="form-cari-dosen">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="row" style="margin-right:-15px; margin-left:-15px;">
                            <div class="col-md-12 form-group">
                                <label for="">Ketik Nama/Nip Dosen</label>
                                <input type="hidden" name="dosen" id="dosen">
                                <select name="dosen_nip" class="form-control selectDosen" id="dosen_nip" style="width: 100%">
                                </select>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-search"></i>&nbsp; Pilih Dosen</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            @if (!empty($dosen))
                <section class="panel">
                    <header class="panel-heading" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                        <i class="fa fa-bar-chart"></i>&nbsp;Informasi Dosen Yang Dipilih
                    </header>
                    <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover table-striped" style="width: 100%">
                                    <tr>
                                        <th>Nama Dosen</th>
                                        <th> : </th>
                                        <td>{{ $dosen->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIP</th>
                                        <th> : </th>
                                        <td>{{ $dosen->nip }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <th> : </th>
                                        <td>{{ $dosen->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <th> : </th>
                                        <td>
                                            @if ($dosen->jenis_kelamin == "L")
                                                <small class="label label-primary"><i class="fa fa-male"></i>&nbsp; Laki-Laki</small>
                                            @else
                                                <small class="label label-primary"><i class="fa fa-female"></i>&nbsp; Perempuan</small>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status Dosen</th>
                                        <th> : </th>
                                        <td>
                                            @if ($dosen->is_active == 1)
                                                <small class="label label-success"><i class="fa fa-check-circle"></i>&nbsp; Aktif</small>
                                            @else
                                                <small class="label label-success"><i class="fa fa-check-circle"></i>&nbsp; Tidak Aktif</small>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan DT</th>
                                        <th> : </th>
                                        <td>
                                            @if ($dosen->jabatan_dt_id != null)
                                                {{ $dosen->jabatanDt->nama_jabatan_dt }}
                                            @else
                                                <a class="text-danger">tidak ada jabatan dt</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>NIDN</th>
                                        <th> : </th>
                                        <td>{{ $dosen->nidn }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/select2/dist/js/select2.full.js') }}" type="text/javascript"></script>
    <script>
        $(".selectDosen").select2({
            minimumInputLength: 3,
            allowClear: true,
            placeholder: 'Masukan Nama/Nip Dosen',
            ajax: {
                type: 'get',
                dataType: 'json',
                url: '{{ route("cari_dosen.get_data_dosen") }}',
                data: function(params) {
                    return {
                        keyword: params.term
                    }
                },
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.nama,
                                id: item.nip
                            }
                        })
                    };
                },
            },
        });

        $('#dosen_nip').on('select2:select', function (e) { 
            console.log(e.params.data.text);
            $("#dosen").val(e.params.data.text);
        });
    </script>
@endpush