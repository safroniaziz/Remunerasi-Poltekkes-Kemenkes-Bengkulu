<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('manajemen_data_user.store') }}" method="POST" id="form-tambah-periode-penilaian">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Tambah User</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_user" name="nama_user" >
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Jurusan</label>
                            <select name="level_jurusan" class="form-control" id="level_jurusan">
                                <option disabled selected>-- pilih Jurusan --</option>
                                <option value="gizi">Gizi</option>
                                <option value="kebidanan">Kebidanan</option>
                                <option value="keperawatan">Keperawatan</option>
                                <option value="analis_kesehatan">Analis Kesehatan</option>
                                <option value="promosi_kesehatan">Promosi Kesehatan</option>
                                <option value="kesehatan_lingkungan">Kesehatan Lingkungan</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password">
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
        $(document).on('submit','#form-tambah-periode-penilaian',function (event){
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
    </script>
@endpush
