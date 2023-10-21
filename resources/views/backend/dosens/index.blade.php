@extends('layouts.app')
@section('subTitle','Data Dosen')
@section('page','Data Dosen')
@section('subPage','Semua Data Dosen')
@section('login_as')
    Selamat Datang,
@endsection
@section('user-login2')
    {{ Auth::user()->nama_user }}
@endsection
@section('sidebar')
    @include('layouts.partials.sidebar')
@endsection
@push('styles')
    @include('backend/prodis._loader')
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-users"></i>&nbsp;Manajemen Data Dosen
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
                        <form method="GET" id="pencarian">
                            <div class="form-group col-md-12" style="margin-bottom: 5px !important;">
                                <label for="nama" class="col-form-label">Cari Nama/Nomor Dosen</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama atau Nomor Dosen..." value="{{$nama}}">
                            </div>
                            <div class="col-md-12" style="margin-bottom:10px !important;">
                                <button type="submit" class="btn btn-success btn-sm btn-flat mb-2"><i class="fa fa-search"></i>&nbsp;Cari Data</button>
                            </div>
                        </form>
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
                                        <h4 class="font-weight-bold">Proses Sinkronisasi Ke SIAKAD sedang berjalan</h4>
                                        <p class="font-italic text-white">Harap untuk menunggu hingga proses selesai</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <div class="pull-left" style="margin-bottom: 3px !important;">
                                <a href="{{ route('dosen.create') }}" class="btn btn-success btn-sm btn-flat" id="create"><i class="fa fa-plus"></i>&nbsp; Tambah Data</a>
                                <a onclick="generateDosen()" href="{{ route('dosen.generateSiakad') }}" class="btn btn-primary btn-sm btn-flat" id="generate"><i class="fa fa-refresh fa-spin"></i>&nbsp; Sinkronisasi Data Siakad</a>
                            </div>

                            <table class="table table-striped table-bordered" id="table" style="width:100%; margin-bottom: 5px !important;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th rowspan="2" style=" vertical-align:middle">No</th>
                                        <th rowspan="2" style=" vertical-align:middle">Nama Lengkap</th>
                                        <th rowspan="2" style="text-align:center; vertical-align:middle">Jenis Kelamin</th>
                                        <th rowspan="2" style="text-align:center; vertical-align:middle">Aktif</th>
                                        <th style="text-align:center; vertical-align:middle" colspan="3">Riwayat</th>
                                        <th rowspan="2" style="text-align:center; vertical-align:middle">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align:center; vertical-align:middle">Jabatan Fungsional</th>
                                        <th style="text-align:center; vertical-align:middle">Jabatan DT</th>
                                        <th style="text-align:center; vertical-align:middle">Pangkat & Golongan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($dosens as $key => $dosen)
                                        <tr
                                            @if ($dosen->jurusan == null || $dosen->jurusan == "")
                                                style="background:#f2dede"
                                            @endif
                                        >
                                            <td>{{ $dosens->firstItem() + $key }}</td>
                                            <td>
                                               {{ $dosen->nama }}
                                                <br>
                                                <hr style="margin-bottom:5px !important; margin-top:5px !important;border-top: 1px solid #ccc; !important">
                                                <small style="font-size:10px !important;  text-transform:capitalize;" class="label label-success">Nip: {{ $dosen->nip ?? '-' }}</small>
                                                <small style="font-size:10px !important;  text-transform:capitalize;" class="label label-primary">Jurusan: {{ $dosen->jurusan ?? '-' }}</small>
                                                <small style="font-size:10px !important;  text-transform:capitalize;" class="label label-primary">Homebase: {{ $dosen->prodi->nama_prodi ?? '-' }}</small>
                                            </td>
                                            <td style="text-align: center">
                                                @if ($dosen->jenis_kelamin == "L")
                                                    <small class="text-primary"><i class="fa fa-male"></i>&nbsp; Laki-Laki</small>
                                                @elseif($dosen->jenis_kelamin == "P")
                                                    <small class="text-warning"><i class="fa fa-female"></i>&nbsp; Perempuan</small>
                                                @else
                                                    <small class="text-danger">-</small>
                                                @endif
                                            </td>
                                           <td>
                                                @if ($dosen->is_active == 1)
                                                    <form action="{{ route('dosen.set_nonactive',[$dosen->nip]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-thumbs-up"></i></button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('dosen.set_active',[$dosen->nip]) }}" method="POST">
                                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-thumbs-down"></i></button>
                                                    </form>
                                                @endif
                                           </td>
                                           <td class="text-center">
                                                <a href="{{ route('dosen.riwayat_jabatan_fungsional',[$dosen->slug]) }}"
                                                    @if ($dosen->total_jabatan_fungsional_aktif < 1 || $dosen->total_jabatan_fungsional_aktif > 1)
                                                        text-danger
                                                    @else
                                                        text-success
                                                    @endif
                                                    >
                                                    @if ($dosen->total_jabatan_fungsional_aktif > 0)
                                                        {{ $dosen->nama_jabatan_fungsional_aktif }}
                                                    @else
                                                        -
                                                    @endif
                                                </a>
                                           </td>
                                            <td class="text-center">
                                                <a href="{{ route('dosen.riwayat_jabatan_dt',[$dosen->slug]) }}"
                                                    @if ($dosen->total_jabatan_dt_aktif < 1 || $dosen->total_jabatan_dt_aktif > 1)
                                                        text-danger
                                                    @else
                                                        text-success
                                                    @endif
                                                    >
                                                    @if ($dosen->total_jabatan_dt_aktif > 0)
                                                        {{ $dosen->nama_jabatan_dt_aktif }}
                                                    @else
                                                        -
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('dosen.riwayat_pangkat_golongan',[$dosen->slug]) }}"
                                                    @if ($dosen->total_pangkat_golongan_aktif < 1 || $dosen->total_pangkat_golongan_aktif > 1)
                                                        text-danger
                                                    @else
                                                        text-success
                                                    @endif
                                                    >
                                                    @if ($dosen->total_pangkat_golongan_aktif > 0)
                                                        {{ $dosen->nama_pangkat_golongan_aktif }}
                                                    @else
                                                        -
                                                    @endif
                                                </a>
                                            </td>
                                           <td>
                                                <a href="{{ route('dosen.edit',[$dosen->slug]) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                           </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $dosens->appends(request()->has('nama') ? ['nama' => $nama] : [])->links("pagination::bootstrap-4") }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function generateDosen(){
            $('#pencarian').hide();
            $('#create').hide();
            $('#generate').hide();
            $('#sync').show(300);
            $('.loader').show(300);
        }
    </script>
@endpush