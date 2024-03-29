@extends('layouts.app')
@section('subTitle','Data Periode Penilaian')
@section('page','Data Periode Penilaian')
@section('subPage','Semua Data')
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
                    <i class="fa fa-users"></i>&nbsp; Manajemen Data Periode Penilaian
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
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered" id="table" style="width:100%;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style=" vertical-align:middle">Nama Periode</th>
                                        <th style=" vertical-align:middle">Tahun Ajaran</th>
                                        <th style="text-align:center; vertical-align:middle">Semester</th>
                                        <th style="text-align:center; vertical-align:middle">Tahun Semester</th>
                                        <th style="text-align:center; vertical-align:middle">Bulan Pembayaran</th>
                                        <th style="vertical-align:middle">Tanggal Awal</th>
                                        <th style="vertical-align:middle">Tanggal Akhir</th>
                                        <th style="text-align:center; vertical-align:middle">Aktif</th>
                                        <th style="text-align:center; vertical-align:middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($periodes as $index => $periode)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $periode->nama_periode }}</td>
                                            <td class="text-center">{{ $periode->tahun_ajaran }}</td>
                                            <td class="text-center">{{ $periode->semester }}</td>
                                            <td class="text-center">{{ $periode->tahun_semester }}</td>
                                            <td class="text-center">
                                                @if ($periode->bulan_pembayaran == "1")
                                                    Januari
                                                @elseif ($periode->bulan_pembayaran == "2")
                                                    Februari
                                                @elseif ($periode->bulan_pembayaran == "3")
                                                    Maret
                                                @elseif ($periode->bulan_pembayaran == "4")
                                                    April
                                                @elseif ($periode->bulan_pembayaran == "5")
                                                    Mei
                                                @elseif ($periode->bulan_pembayaran == "6")
                                                    Juni
                                                @elseif ($periode->bulan_pembayaran == "7")
                                                    Juli
                                                @elseif ($periode->bulan_pembayaran == "8")
                                                    Agustus
                                                @elseif ($periode->bulan_pembayaran == "9")
                                                    September
                                                @elseif ($periode->bulan_pembayaran == "10")
                                                    Oktober
                                                @elseif ($periode->bulan_pembayaran == "11")
                                                    November
                                                @elseif ($periode->bulan_pembayaran == "12")
                                                    Desember
                                                @endif
                                            </td>
                                            <td>{{ $periode->tanggal_awal->isoFormat('DD MMMM YYYY'); }}</td>
                                            <td>{{ $periode->tanggal_akhir->isoFormat('DD MMMM YYYY'); }}</td>
                                            <td>
                                                @if ($periode->is_active == 1)
                                                    <form action="{{ route('periode_penilaian.set_nonactive',[$periode->id]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-thumbs-up"></i></button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('periode_penilaian.set_active',[$periode->id]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-thumbs-down"></i></button>
                                                    </form>
                                                @endif
                                           </td>
                                           <td>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <a onclick="editPeriode({{ $periode->id }})" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('periode_penilaian.delete',[$periode->id]) }}" method="POST">
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
                        @include('backend/periode_penilaians.partials.modal_add')
                    </div>
                    @include('backend/periode_penilaians.partials.modal_edit')
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
            url = "{{ url('manajemen_data_periode').'/' }}"+id+'/edit';
            $.ajax({
                url : url,
                type : 'GET',
                success : function(data){
                    $('#modalEdit').modal('show');
                    $('#periode_id_edit').val(data.id);
                    $('#nama_periode_edit').val(data.nama_periode);
                    $('#semester_edit').val(data.semester);
                    $('#tahun_ajaran_edit').val(data.tahun_ajaran);
                    $('#bulan_edit').val(data.bulan);
                    $('#bulan_pembayaran_edit').val(data.bulan_pembayaran);
                    $('#tanggal_akhir_edit').val(data.tanggal_akhir);
                    $('#tanggal_awal_edit').val(data.tanggal_awal);
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

@push('scripts')
    <script>
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
    </script>
@endpush