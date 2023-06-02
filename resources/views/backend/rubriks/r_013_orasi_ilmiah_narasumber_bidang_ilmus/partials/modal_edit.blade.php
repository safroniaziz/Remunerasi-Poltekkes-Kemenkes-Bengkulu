<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('r_013_orasi_ilmiah_narasumber_bidang_ilmu.update') }}" method="POST" id="form-edit-R013">
                {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Edit Rubrik 13 Orasi Ilmiah Narasumber Bidang Ilmu</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="r013Orasiilmiahnarasumber_id_edit" id="r013Orasiilmiahnarasumber_id_edit">
                        <div class="form-group col-md-12" >
                            <label for="periode_id" class="col-form-label">Periode Aktif</label>
                            <input type="text" class="form-control" value="{{ $periode->nama_periode }}" disabled>
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">NIP</label>
                            <select name="nip" id="nip_edit" class="form-control @error('nip') is-invalid @enderror">
                                <option disabled selected>-- Pilih NIP --</option>
                                @foreach ($pegawais as $pegawai)
                                    <option
                                  value="{{ $pegawai->nip }}">{{ $pegawai->nip }}
                                    @endforeach</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Judul Kegiatan</label>
                            <input type="text" class="form-control" id="judul_kegiatan_edit" name="judul_kegiatan">
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Tingkat </label>
                            <select name="tingkatan_ke" class="form-control" id="tingkatan_ke_edit">
                                <option disabled selected>-- pilih tingkatan --</option>
                                <option value="internasional">Internasional</option>
                                <option value="nasional">Nasional</option>
                                <option value="institusi">Wilayah / Daerah / Institusi</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Rubrik BKD?</label>
                            <select name="is_bkd" class="form-control" id="is_bkd_edit">
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
        $(document).on('submit','#form-edit-R013',function (event){
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
    </script>
@endpush
