@extends('layouts.app')
@section('subTitle','Data Rubrik 20 Assessor BKD LKD')
@section('page','Data Rubrik 20 Assessor BKD LKD')
@section('subPage','Semua Data')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-users"></i>&nbsp; Manajemen Data Rubrik 20 Assessor BKD LKD
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
                                    <i class="fa fa-plus"></i>&nbsp; Tambah Rubrik 20
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered" id="table" style="width:100%;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style="text-align:center; vertical-align:middle">NIP</th>
                                        <th style="text-align:center; vertical-align:middle">Nama Dosen</th>
                                        <th style="text-align:center; vertical-align:middle">Jumlah Dosen</th>
                                        <th style="text-align:center; vertical-align:middle">BKD</th>
                                        <th style="text-align:center; vertical-align:middle">Status Verifikasi</th>
<th style="text-align:center; vertical-align:middle">Verifikasi</th>
                                        <th style="text-align:center; vertical-align:middle">Point</th>
                                        <th style="text-align:center; vertical-align:middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($r020assessorbkdlkds as $index => $r020assessorbkdlkd)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td class="text-center">{{ $r020assessorbkdlkd->nip }}</td>
                                            <td class="text-center">{{ $r020assessorbkdlkd->pegawai->nama }}</td>
                                            <td class="text-center">{{ $r020assessorbkdlkd->jumlah_dosen }}</td>
                                            <td class="text-center">
                                                @if ($r020assessorbkdlkd->is_bkd == 1)
                                                    <small class="label label-danger"><i class="fa fa-check-circle"></i>&nbsp;Ya</small>
                                                @else
                                                    <small class="label label-success"><i class="fa fa-check-circle"></i>&nbsp;Tidak</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($r020assessorbkdlkd->is_verified == 1)
                                                    <small class="label label-success"><i class="fa fa-check-circle"></i></small>
                                                @else
                                                    <small class="label label-warning"><i class="fa fa-clock-o"></i></small>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $r020assessorbkdlkd->point }}</td>
                                           <td>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <a onclick="editr020assessorbkdlkd({{ $r020assessorbkdlkd->id }})" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('r_020_assessor_bkd_lkd.delete',[$r020assessorbkdlkd->id]) }}" method="POST">
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
                        @include('backend/rubriks/r_020_assessor_bkd_lkds.partials.modal_add')
                    </div>
                    @include('backend/rubriks/r_020_assessor_bkd_lkds.partials.modal_edit')
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

        function editr020assessorbkdlkd(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            url = "{{ url('r_020_assessor_bkd_lkd').'/' }}"+id+'/edit';
            $.ajax({
                url : url,
                type : 'GET',
                success : function(data){
                    $('#modalEdit').modal('show');
                    $('#r020assessorbkdlkd_id_edit').val(data.id);
                    $('#periode_id_edit').val(data.periode_id);
                    $('#jumlah_dosen_edit').val(data.jumlah_dosen);
                    $('#is_bkd_edit').val(data.is_bkd);
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
