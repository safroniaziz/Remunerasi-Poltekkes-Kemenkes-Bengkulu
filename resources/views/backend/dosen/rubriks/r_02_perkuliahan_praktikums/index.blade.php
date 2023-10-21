@extends('layouts.app')
@section('subTitle','Data Rubrik 02 Perkuliahan Praktikum')
@section('page','Data Rubrik 02 Perkuliahan Praktikum')
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
                    <i class="fa fa-users"></i>&nbsp; Manajemen Data Rubrik Perkuliahan Praktikum
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
                        <div class="col-md-12" style="margin-bottom: 10px !important;">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="">Pilih Program Studi</label>
                                    <select name="kodeProdi" id="kodeProdi" class="form-control">
                                        <option disabled selected>-- pilih program studi --</option>
                                        @foreach ($dataProdis as $prodi)
                                            <option value="{{ $prodi->kdjen.$prodi->kdpst }}">{{ $prodi->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <button class="btn btn-success btn-sm btn-flat" id="cekDataSiakad">
                                        <i class="fa fa-refresh fa-spin"></i>&nbsp; Generate Dari Siakad
                                    </button>

                                    <button type="button" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-default">
                                        <i class="fa fa-plus"></i>&nbsp; Tambah Rubrik Manual
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered" id="table" style="width:100%;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style=" vertical-align:middle">No</th>
                                        <th style="vertical-align:middle">Nama Matkul</th>
                                        <th style="vertical-align:middle">Prodi</th>
                                        <th style="vertical-align:middle">Jumlah SKS</th>
                                        <th style="text-align:center; vertical-align:middle">Jumlah Mahasiswa</th>
                                        <th style="text-align:center; vertical-align:middle">Jumlah Tatap Muka</th>
                                        <th style="text-align:center; vertical-align:middle">Status Data</th>
                                        <th style="text-align:center; vertical-align:middle">Status Verifikasi</th>
                                        <th style="vertical-align:middle">Sumber Data</th>
                                        <th style="text-align:center; vertical-align:middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($r02perkuliahanpraktikums as $index => $r02perkuliahanpraktikum)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $r02perkuliahanpraktikum->nama_matkul }}</td>
                                            <td>{{ $r02perkuliahanpraktikum->prodiMatkul ? $r02perkuliahanpraktikum->prodiMatkul->nama_lengkap_prodi : ''}} </td>
                                            <td>{{ $r02perkuliahanpraktikum->jumlah_sks }} SKS</td>
                                            <td class="text-center">{{ $r02perkuliahanpraktikum->jumlah_mahasiswa }} Mahasiswa</td>
                                            <td class="text-center">
                                                @if ($r02perkuliahanpraktikum->jumlah_tatap_muka == null)
                                                    -
                                                @else
                                                    {{ $r02perkuliahanpraktikum->jumlah_tatap_muka }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($r02perkuliahanpraktikum->is_bkd == 1)
                                                    <small class="label label-danger">BKD</small>
                                                @else
                                                    <small class="label label-success">Non BKD</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($r02perkuliahanpraktikum->is_verified == 1)
                                                    <small class="label label-success">Terverifikasi</small>
                                                @else
                                                    <small class="label label-danger">Belum Verifikasi</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($r02perkuliahanpraktikum->sumber_data == "siakad")
                                                    Siakad
                                                @else
                                                    Manual
                                                @endif
                                            </td>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <a onclick="editR02perkuliahanpraktikum({{ $r02perkuliahanpraktikum->id }})" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('dosen.r_02_perkuliahan_praktikum.delete',[$r02perkuliahanpraktikum->id]) }}" method="POST" id="form-hapus">
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
                        @include('backend/dosen/rubriks/r_02_perkuliahan_praktikums.partials.modal_add')
                    </div>
                    @include('backend/dosen/rubriks/r_02_perkuliahan_praktikums.partials.modal_edit')
                </div>
            </section>
            @include('backend/dosen/rubriks/r_02_perkuliahan_praktikums.partials.modal_siakad')
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

        $(document).on('submit','#form-hapus',function (event){
            event.preventDefault();
            $("#btnSubmit"). attr("disabled", true);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: "JSON", // Perbaiki typo di "typeData" menjadi "dataType"
                data: new FormData(this),
                processData:false,
                contentType:false,
                success : function(res) {
                    toastr.success(res.text, 'Yeay, Berhasil');
                    setTimeout(function () {
                        window.location.href=res.url;
                    } , 500);
                },
                error:function(xhr){
                    toastr.error(xhr.responseJSON.text, 'Ooopps, Ada Kesalahan');
                },
            })
        });

        $("#cekDataSiakad").click(function() {
            let kodeProdi = $("#kodeProdi").val();
            let kodeJenjang = $("#kodeJenjang").val();
            if (kodeProdi) {
                $('#alertDanger').hide();
                $('#loader').addClass('loader');
                $('#modalDetail').modal('show');
                $('#table_siakad').empty();
                $.ajax({
                    type: "get",
                    url: "{{ route('dosen.r_02_perkuliahan_praktikum.siakad') }}",
                    data: {
                        "kodeProdi": kodeProdi,
                    },
                    success: function (response) {
                        $("#kodeProdiSiakad").val(response['kodeProdi']);
                        $("#kodeJenjangSiakad").val(response['kodeJenjang']);
                        setTimeout(function () {
                            let jenis_tabel =
                                '<thead>' +
                                '<tr>' +
                                '<td>#</td>' +
                                '<td>No</td>' +
                                '<td>Nama Matkul</td>' +
                                '<td>Jumlah Peserta</td>' +
                                '<td>Kode Prodi</td>' +
                                '<td>Kode Jenjang</td>' +
                                '<td>Semester</td>' +
                                '<td>SKS</td>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody id="result_datas">' + // Hapus tanda kutip setelah </thead>
                                '</tbody>';
                            $('#table_siakad').html(jenis_tabel);
                            $('#result_datas').html(response['res']);
                            $('#alertDanger').show();
                            $('#loader').removeClass('loader');
                        }, 2000);

                    },
                    error: function (response) {
                        console.log(response);
                    },
                });

            } else {
                swal({
                    title: 'Mohon Maaf',
                    text: 'Silahkan pilih prodi terlebih dahulu',
                    icon: 'warning',
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                });
            }
        });

        function editR02perkuliahanpraktikum(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            url = "{{ url('dosen/r_02_perkuliahan_praktikum').'/' }}"+id+'/edit';
            $.ajax({
                url : url,
                type : 'GET',
                success : function(data){
                    $('#modalEdit').modal('show');
                    $('#r02perkuliahanpraktikum_id_edit').val(data.id);
                    $('#periode_id_edit').val(data.periode_id);
                    $('#nama_matkul_edit').val(data.nama_matkul);
                    $('#kode_kelas_edit').val(data.kode_kelas);
                    $('#jumlah_sks_edit').val(data.jumlah_sks);
                    $('#jumlah_mahasiswa_edit').val(data.jumlah_mahasiswa);
                    $('#jumlah_tatap_muka_edit').val(data.jumlah_tatap_muka);
                    $('#id_prodi_edit').val(data.id_prodi);
                    $('#is_bkd_edit').val(data.is_bkd);
                    $('#keterangan_edit').val(data.keterangan);

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
