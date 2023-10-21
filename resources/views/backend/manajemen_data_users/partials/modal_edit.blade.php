<div class="modal fade" id="modalEdituser">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('manajemen_data_user.update') }}" method="POST" class="form">
                {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Edit user</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="user_id_edit" id="user_id_edit">
                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_user_edit" name="nama_user" >
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Jurusan</label>
                            <select name="level_jurusan" class="form-control" id="level_jurusan_edit">
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
                            <input type="text" class="form-control" name="email" id="email_edit">
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Password</label>
                            <input type="text" class="form-control" name="password" id="password_edit">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm btn-flat "  data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                <button type="submit" class="btn btn-primary btn-sm btn-flat btnSubmit"><i class="fa fa-check-circle"></i>&nbsp;Simpan Data</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


