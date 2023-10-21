<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dosen.riwayat_pangkat_golongan.store',[$pegawai->slug]) }}" method="POST" id="form-tambah-pangkat-golongan">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Tambah Riwayat Pangkat & Golongan</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Nip Dosen</label>
                            <input type="text" class="form-control" id="nip" name="nip" value="{{ $pegawai->nip }}" disabled>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Nama Dosen</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $pegawai->nama }}" disabled>
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="golongan" class="col-form-label">Golongan</label>
                            <select name="golongan" id="golongan" class="form-control">
                                <option disabled selected>-- pilih golongan --</option>
                                <option value="I">Golongan I (Juru)</option>
                                <option value="II">Golongan II (Pengatur)</option>
                                <option value="III">Golongan III (Penata)</option>
                                <option value="IV">Golongan IV (Pembina)</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="">Pilih Pangkat :</label>
                            <select name="nama_pangkat" id="nama_pangkat" class="form-control" style="font-size:13px;">
                                <option value="" disabled selected>-- pilih pangkat --</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label>TMT Pangkat & Golongan</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" value="{{ old('tmt_pangkat_golongan') }}" name="tmt_pangkat_golongan" id="tmt_jabatan_fungsional" class="form-control pull-right">
                            </div>
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


