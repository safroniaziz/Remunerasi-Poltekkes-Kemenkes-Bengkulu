<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('r_017_naskah_buku_bahasa_terbit_edar_nas.store') }}" method="POST" id="form-tambah-r-017">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Tambah Rubrik 17 Naskah Buku Bahasa Terbit Edar Nasional</p>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-md-12" >
                            <label for="periode_id" class="col-form-label">Periode Aktif</label>
                            <input type="text" class="form-control" value="{{ $periode->nama_periode }}" disabled>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Judul Buku</label>
                            <input type="text" class="form-control" id="judul_buku" name="judul_buku">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Status Rubrik</label>
                            <select name="is_bkd" class="form-control" id="is_bkd">
                                <option disabled selected>-- pilih --</option>
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm btn-flat " data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-check-circle"></i>&nbsp;Simpan Data</button>
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
        $(document).on('submit','#form-tambah-r-017',function (event){
            event.preventDefault();
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
