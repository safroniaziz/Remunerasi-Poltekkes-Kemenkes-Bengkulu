<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dosen.r_025_kepanitiaan_kegiatan_institusi.update') }}" method="POST" class="form">
                {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Edit Rubrik 25 Kepanitiaan Kegiatan Institusi</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="r25panitiakegiataninstitusi_id_edit" id="r25panitiakegiataninstitusi_id_edit">

                        <div class="form-group col-md-12" >
                            <label for="periode_id" class="col-form-label">Periode Aktif</label>
                            <input type="text" class="form-control" value="{{ $periode->nama_periode }}" disabled>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Judul Kegiatan</label>
                            <input type="text" class="form-control" id="judul_kegiatan_edit" name="judul_kegiatan">
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Jabatan</label>
                            <select name="jabatan" class="form-control" id="jabatan_edit">
                                <option disabled selected>-- pilih Jabatan --</option>
                                <option value="ketua">Ketua</option>
                                <option value="wakil">Wakil Ketua</option>
                                <option value="sekretaris">Sekretaris</option>
                                <option value="anggota">Anggota</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Bukti Validasi Data</label>
                            <input type="text" class="form-control" id="keterangan_edit" name="keterangan">
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
                <button type="button" class="btn btn-danger btn-sm btn-flat " data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                <button type="submit" class="btn btn-primary btn-sm btn-flat btnSubmit"><i class="fa fa-check-circle"></i>&nbsp;Simpan Data</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


