<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dosen.r_029_memperoleh_penghargaan.store') }}" method="POST" id="form-tambah-r-29">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Tambah Rubrik 29 Memperoleh Penghargaan</p>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-md-12" >
                            <label for="periode_id" class="col-form-label">Periode Aktif</label>
                            <input type="text" class="form-control" value="{{ $periode->nama_periode }}" disabled>
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Judul Penghargaan</label>
                            <select name="judul_penghargaan" class="form-control" id="judul_penghargaan">
                                <option disabled selected>-- pilih Judul Penghargaan --</option>
                                <option value="dosen_berprestasi_nasional">Dosen Berprestasi Nasional</option>
                                <option value="reviewer_internasional_berscopus">Reviewer Internasional Berscopus</option>
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


