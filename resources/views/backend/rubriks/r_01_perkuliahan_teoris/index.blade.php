@extends('layouts.app')
@section('subTitle','Rubrik 01 Perkuliahan Teori')
@section('page','Rubrik 01 Perkuliahan Teori')
@section('subPage','Semua Rubrik 01 Perkuliahan Teori')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-wifungsionalh: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-briefcase"></i>&nbsp;Manajemen Rubrik 01 Perkuliahan Teori
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <div class="col-md-12">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Berhasil :</strong>{{ $message }}
                                </div>
                                @elseif ($message = Session::get('error'))
                                    <div class="alert alert-danger alert-block">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>Gagal :</strong>{{ $message }}
                                    </div>
                                    @else
                            @endif
                        </div>

                            <div class="col-md-12">
                                <div style="margin-bottom: 10px !important;">
                                    <button type="button" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-default">
                                        <i class="fa fa-plus"></i>&nbsp; Tambah Periode Penilaian
                                    </button>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered" id="table" style="wifungsionalh:100%; margin-bottom: 5px !important;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style=" vertical-align:middle">Nama Periode</th>
                                        <th style=" vertical-align:middle">NIP</th>
                                        <th style=" vertical-align:middle">Jumlah SKS</th>
                                        <th style=" vertical-align:middle">Jumlah Mahasiswa</th>
                                        <th style=" vertical-align:middle">Jumlah Tatap Muka</th>
                                        <th style=" vertical-align:middle">BKD</th>
                                        <th style=" vertical-align:middle">Verifikasi</th>
                                        <th style=" vertical-align:middle">Point</th>
                                        <th style="text-align:center; vertical-align:middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($r01perkuliahanteoris as $index => $r01perkuliahanteori)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                              <td style="text-align: center;">{{ $r01perkuliahanteori->periode_id }}</td>
                                              <td style="text-align: center;">{{ $r01perkuliahanteori->nip }}</td>
                                              <td style="text-align: center;">{{ $r01perkuliahanteori->jumlah_sks }}</td>
                                              <td style="text-align: center;">{{ $r01perkuliahanteori->jumlah_mahasiswa }}</td>
                                              <td style="text-align: center;">{{ $r01perkuliahanteori->jumlah_tatap_muka }}</td>
                                              <td class="text-center">
                                                @if ($r01perkuliahanteori->is_bkd == 1)
                                                    <form action="{{ route('r_01_perkuliahan_teori.set_nonactive',[$r01perkuliahanteori->id]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-thumbs-up"></i></button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('r_01_perkuliahan_teori.set_active',[$r01perkuliahanteori->id]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-thumbs-down"></i></button>
                                                    </form>
                                                @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($r01perkuliahanteori->is_verified == 1)
                                                        <form action="{{ route('r_01_perkuliahan_teori.set_nonactive',[$r01perkuliahanteori->id]) }}" method="POST">
                                                            {{ csrf_field() }} {{ method_field('PATCH') }}
                                                            <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-thumbs-up"></i></button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('r_01_perkuliahan_teori.set_active',[$r01perkuliahanteori->id]) }}" method="POST">
                                                            {{ csrf_field() }} {{ method_field('PATCH') }}
                                                            <button type="submit" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-thumbs-down"></i></button>
                                                        </form>
                                                    @endif
                                               </td>
                                              <td style="text-align: center;">{{ $r01perkuliahanteori->point }}</td>
                                           <td>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('r_01_perkuliahan_teori.edit',[$r01perkuliahanteori->id]) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                   </td>
                                                    <td>
                                                        <form action="{{ route('r_01_perkuliahan_teori.delete',[$r01perkuliahanteori->id]) }}" method="POST">
                                                            {{ csrf_field() }} {{ method_field('DELETE') }}
                                                            <button type="submit" class="btn btn-danger btn-sm btn-flat show_confirm"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            </table>

                                           </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @include('backend/rubriks/r_01_perkuliahan_teoris.partials.modal_add')
                    </div>
                    @include('backend/rubriks/r_01_perkuliahan_teoris.partials.modal_edit')
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );

        function editPeriode(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            url = "{{ url('r_01_perkuliahan_teori').'/' }}"+id+'/edit';
            $.ajax({
                url : url,
                type : 'GET',
                success : function(data){
                    $('#modalEdit').modal('show');
                    $('#periode_id_edit').val(data.id);
                    $('#nip_edit').val(data.nip);
                    $('#jumlah_sks_edit').val(data.jumlah_sks);
                    $('#jumlah_tatap_muka_edit').val(data.jumlah_tatap_muka);
                    $('#jumlah_mahasiswa_edit').val(data.jumlah_mahasiswa);
                    $('#point_edit').val(data.point);
                },
                error:function(){
                    $('#gagal').show(100);
                }
            });
            return false;
        }

        $('.show_confirm').click(function(event) {
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: `Apakah Anda Yakin?`,
                text: "Harap untuk memeriksa kembali sebelum menghapus data.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                form.submit();
                }
            });
        });
    </script>
@endpush
