@extends('layouts.app')
@section('subTitle','Data Pengumuman')
@section('page','Data Pengumuman')
@section('subPage','Semua Data Pengumuman')
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
                    <i class="fa fa-briefcase"></i>&nbsp;Manajemen Data Pengumuman
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
                                    <i class="fa fa-plus"></i>&nbsp; Tambah Pengumuman
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped table-bordered" id="table" style="width:100%; margin-bottom: 5px !important;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style=" vertical-align:middle">Nama Pengumuman</th>
                                        <th style=" vertical-align:middle">Tanggal Pengumuman</th>
                                        <th style=" vertical-align:middle">Status</th>
                                        <th style="text-align:center; vertical-align:middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($pengumumans as $index => $pengumuman)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>
                                            <a href="" style="font-weight:600;">{{ $pengumuman->isi_pengumuman }}</a></td>
                                            <td style="text-align: center;">{{ $pengumuman->tanggal_pengumuman }}</td>
                                            <td>
                                                @if ($pengumuman->is_active == 1)
                                                    <form action="{{ route('pengumuman.set_nonactive',[$pengumuman->id]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-thumbs-up"></i></button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('pengumuman.set_active',[$pengumuman->id]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-thumbs-down"></i></button>
                                                    </form>
                                                @endif
                                           </td>
                                           <td>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a onclick="editPengumuman({{ $pengumuman->id }})" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                   </td>
                                                    <td>
                                                        <form action="{{ route('pengumuman.delete',[$pengumuman->id]) }}" method="POST">
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
                        @include('backend/pengumumans.partials.modal_add')
                    </div>
                    @include('backend/pengumumans.partials.modal_edit')
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );

        CKEDITOR.replace( 'isi_pengumuman_edit' );

        function editPengumuman(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            url = "{{ url('manajemen_pengumuman').'/' }}"+id+'/edit';
            $.ajax({
                url : url,
                type : 'GET',
                success : function(data){
                    $('#modalEditPengumuman').modal('show');
                    $('#pengumuman_id_edit').val(data.id);
                    $('#judul_pengumuman_edit').val(data.judul_pengumuman);
                    CKEDITOR.instances['isi_pengumuman_edit'].setData(data.isi_pengumuman);
                },
                error:function(){
                    $('#gagal').show(100);
                }
            });
            return false;
        }
    </script>
@endpush
