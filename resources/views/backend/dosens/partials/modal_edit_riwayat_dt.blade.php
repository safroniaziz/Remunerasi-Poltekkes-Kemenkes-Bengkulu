<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dosen.riwayat_jabatan_fungsional.update') }}" method="POST" id="form-edit-jabatan-fungsional">
                {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Edit Periode Penilaian</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="jabatan_fungsional_id" id="jabatan_fungsional_id">
                        <div class="form-group col-md-6" >
                            <label for="exampleInputEmail1">Pilih NIP Terlebih Dahulu</label>
                            <select name="nip" id="nip"  class="form-control @error('nip') is-invalid @enderror">
                                <option  selected>-- pilih NIP --</option>

                            </select>
                            <div>
                                @if ($errors->has('nip'))
                                    <small class="form-text text-danger">{{ $errors->first('nip') }}</small>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-md-6" >
                            <label for="nama" class="col-form-label">Nama Jabatan Fungsional</label>
                            <input type="text" class="form-control" id="nama_jabatan_fungsional" name="nama_jabatan_fungsional" >
                        </div>

                        <div class="form-group col-md-6" >
                            <label for="nip" class="col-form-label">TMT Jabatan Fungsional</label>
                            <input type="text" class="form-control" id="tmt_jabatan_fungsional" name="tmt_jabatan_fungsional" >
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

