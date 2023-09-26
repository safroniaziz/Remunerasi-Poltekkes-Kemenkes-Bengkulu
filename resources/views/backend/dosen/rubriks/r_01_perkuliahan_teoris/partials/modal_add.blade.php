<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dosen.r_01_perkuliahan_teori.store') }}" method="POST" id="form-tambah-r-01">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Tambah Rubrik 01 Perkuliahan Teori</p>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-md-12" >
                            <label for="periode_id" class="col-form-label">Periode Aktif</label>
                            <input type="text" class="form-control" value="{{ $periode->nama_periode }}" disabled>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Nama Matkul</label>
                            <input type="text" class="form-control" id="nama_matkul" name="nama_matkul">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Kode Kelas</label>
                            <input type="text" class="form-control" id="kode_kelas" name="kode_kelas">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Jumlah SKS</label>
                            <input type="text" class="form-control" id="jumlah_sks" name="jumlah_sks">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Jumlah Mahasiswa</label>
                            <input type="text" class="form-control" id="jumlah_mahasiswa" name="jumlah_mahasiswa">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Jumlah Tatap Muka</label>
                            <input type="text" class="form-control" id="jumlah_tatap_muka" name="jumlah_tatap_muka">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Program Studi Mengajar</label>
                            <select name="id_prodi" id="id_prodi" class="form-control">
                                <option disabled selected>-- pilih program studi --</option>
                                @foreach ($dataProdis as $prodi)
                                    <option value="{{ $prodi->kdjen.$prodi->kdpst }}">{{ $prodi->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Bukti Validasi Data</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                            <small class="text-danger">(Nomor SK / Tempat Terbit / Bukti Valid Lainnya Sesuai Aturan yang berlaku)</small>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Status Rubrik</label>
                            <select name="is_bkd" class="form-control" id="is_bkd">
                                <option disabled selected>-- pilih status rubrik--</option>
                                <option value="0">Non BKD</option>
                                <option value="1">BKD</option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm btn-flat" id="btnCancel" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                <button type="submit" class="btn btn-primary btn-sm btn-flat" id="btnSubmit" ><i class="fa fa-check-circle"></i>&nbsp;Simpan Data</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@push('scripts')
    <script>
        $(document).on('submit','#form-tambah-r-01',function (event){
            event.preventDefault();
            $("#btnSubmit"). attr("disabled", true);
            $("#btnCancel"). attr("disabled", true);
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

        $('#tmt_jabatan_fungsional').datepicker({
            format: 'yyyy/mm/dd', autoclose: true
        })
    </script>
@endpush
