<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dosen.riwayat_jabatan_dt.store',[$pegawai->slug]) }}" method="POST" class="form">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Tambah Riwayat Jabatan DT</p>
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
                            <label for="nama_jabatan_dt" class="col-form-label">Nama Jabatan DT</label>
                            <select name="nama_jabatan_dt" id="nama_jabatan_dt" class="form-control @error('nama_jabatan_dt') is-invalid @enderror">
                                <option disabled selected>-- Pilih Jabatan --</option>
                                @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan_dt }}</option>
                                @endforeach
                            </select>
                            <div>
                                @if ($errors->has('nip'))
                                    <small class="form-text text-danger">{{ $errors->first('nip') }}</small>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label>TMT Jabatan DT</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" value="{{ old('tmt_jabatan_dt') }}" name="tmt_jabatan_dt" id="tmt_jabatan_dt" class="form-control pull-right">
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

@push('scripts')
    <script>
        $('#tmt_jabatan_dt').datepicker({
            format: 'yyyy/mm/dd', autoclose: true
        })
    </script>
@endpush
