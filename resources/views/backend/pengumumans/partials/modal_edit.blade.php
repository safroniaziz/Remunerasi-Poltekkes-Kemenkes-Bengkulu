<div class="modal fade" id="modalEditPengumuman">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pengumuman.update') }}" method="POST" class="form">
                {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Edit Pengumuman</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="pengumuman_id_edit" id="pengumuman_id_edit">
                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Judul Pengumuman</label>
                            <input type="text" class="form-control" id="judul_pengumuman_edit" name="judul_pengumuman_edit" >
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nama" class="col-form-label">Isi Pengumuman</label>
                            <textarea name="isi_pengumuman_edit" id="isi_pengumuman_edit" class="form-control" cols="30" rows="10"></textarea>
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


