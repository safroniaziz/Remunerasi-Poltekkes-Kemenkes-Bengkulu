<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pengumuman.store') }}" method="POST" class="form" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Tambah Pengumuman</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12" >
                            <label for="nama" class="col-form-label">Judul Pengumuman</label>
                            <input type="text" class="form-control" id="judul_pengumuman" name="judul_pengumuman" >
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nama" class="col-form-label">Isi Pengumuman</label>
                            <textarea name="isi_pengumuman" class="form-control editor"></textarea>
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Tanggal Pengumuman</label>
                            <input type="date" class="form-control" id="tanggal_pengumuman" name="tanggal_pengumuman" >
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="file" class="col-form-label">Tanggal Pengumuman</label>
                            <input type="file" class="form-control" id="file_pengumuman" name="file_pengumuman" >
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
