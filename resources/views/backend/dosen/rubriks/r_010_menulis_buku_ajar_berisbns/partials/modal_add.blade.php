<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dosen.r_010_menulis_buku_ajar_berisbn.store') }}" method="POST" id="form-tambah-r-010">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Tambah Rubrik 10 Menulis Buku Ajar Berisbn</p>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-md-12" >
                            <label for="periode_id" class="col-form-label">Periode Aktif</label>
                            <input type="text" class="form-control" value="{{ $periode->nama_periode }}" disabled>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Status Penulis</label>
                            <select name="penulis_ke" class="form-control" id="penulis_ke">
                                <option disabled selected>-- pilih Status Penulis --</option>
                                <option value="penulis_utama">Penulis Utama</option>
                                <option value="penulis_anggota">Penulis Anggota</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Jumlah Penulis</label>
                            <input type="text" class="form-control" id="jumlah_penulis" name="jumlah_penulis">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Bukti Validasi Data</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                            <small class="text-danger">(Nomor SK / Tempat Terbit / Bukti Valid Lainnya Sesuai Aturan yang berlaku)</small>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Status Rubrik</label>
                            <select name="is_bkd" class="form-control" id="is_bkd">
                                <option disabled selected>-- pilih --</option>
                                <option value="0">Non BKD</option>
                                <option value="1">BKD</option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm btn-flat " id="btnCancel" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                <button type="submit" class="btn btn-primary btn-sm btn-flat" id="btnSubmit"><i class="fa fa-check-circle"></i>&nbsp;Simpan Data</button>
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
        $(document).on('submit','#form-tambah-r-010',function (event){
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
