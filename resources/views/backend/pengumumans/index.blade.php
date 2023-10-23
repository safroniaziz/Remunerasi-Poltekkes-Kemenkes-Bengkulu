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
                                        <th style=" vertical-align:middle">Judul Pengumuman</th>
                                        <th style=" vertical-align:middle">Isi Pengumuman</th>
                                        <th style=" vertical-align:middle">Tanggal Pengumuman</th>
                                        <th style=" vertical-align:middle">File Pengumuman</th>
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
                                                {{ $pengumuman->judul_pengumuman }}
                                            </td>
                                            <td>
                                                {!! $pengumuman->short_isi_pengumuman !!} <a href="{{ route('pengumuman.detail',[$pengumuman->id]) }}">Selengkapnya</a>
                                            </td>
                                            <td>{{ $pengumuman->tanggal_pengumuman->isoFormat('dddd, DD MMMM YYYY') }}</td>
                                            <td>
                                                @if ($pengumuman->file_pengumuman != null || $pengumuman->file_pengumuman != "")
                                                    <a href="{{ route('pengumuman.download',[$pengumuman->id]) }}" ><i class="fa fa-download"></i>&nbsp; Download File</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('pengumuman.detail',[$pengumuman->id]) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-search"></i>&nbsp; Detail</a>
                                                        </td>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="{{ asset('assets/ckeditor/build/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/ckeditor/script.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );

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

        $(document).on('submit','.form',function (event){
            event.preventDefault();
            $(".btnSubmit"). attr("disabled", true);
            $('.btnSubmit').html('<i class="fa fa-check-circle"></i>&nbsp; Menyimpan');  // Mengembalikan teks tombol
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                typeData: "JSON",
                data: new FormData(this),
                processData:false,
                contentType:false,
                success : function(res) {
                    $(".btnSubmit"). attr("disabled", true);
                    toastr.success(res.text, 'Yeay, Berhasil');
                    setTimeout(function () {
                        window.location.href=res.url;
                    } , 500);
                },
                error:function(xhr){
                    toastr.error(xhr.responseJSON.text, 'Ooopps, Ada Kesalahan');
                    setTimeout(function() {
                        $(".btnSubmit").prop('disabled', false);  // Mengaktifkan tombol kembali
                        $(".btnSubmit").html('<i class="fa fa-check-circle"></i>&nbsp; Simpan Data');  // Mengembalikan teks tombol
                    }, 500); // Waktu dalam milidetik (2000 ms = 2 detik)
                }
            })
        });

        $('#modalEditPengumuman').on('hidden.bs.modal', function () {
            // Me-reload (refresh) halaman saat modal ditutup
            location.reload();
        });

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
                    $('#isi_pengumuman_edit').text(data.isi_pengumuman);
                    $('#tanggal_pengumuman_edit').val(data.tanggal_pengumuman);
                    ClassicEditor
                    .create(document.querySelector('#isi_pengumuman_edit'))
                    .catch(error => {
                        console.error(error);
                    });
                },
                error:function(){
                    $('#gagal').show(100);
                }
            });
            return false;
        }
    </script>
@endpush
