<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('r_07_membimbing_skripsi_lta_la_profesi.update') }}" method="POST" id="form-edit-R07">
                {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Edit Rubrik 07 Membimbing Skripsi LTA LA Profesi</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="r07membimbingskripsiltalaprofesi_id_edit" id="r07membimbingskripsiltalaprofesi_id_edit">

                        <div class="form-group col-md-12" >
                            <label for="periode_id" class="col-form-label">Periode Aktif</label>
                            <input type="text" class="form-control" value="{{ $periode->nama_periode }}" disabled>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Jumlah Mahasiswa</label>
                            <input type="text" class="form-control" id="jumlah_mahasiswa_edit" name="jumlah_mahasiswa">
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Pembimbing Ke</label>
                            <select name="pembimbing_ke" class="form-control" id="pembimbing_ke_edit">
                                <option disabled selected>-- pilih Pembimbing Ke --</option>
                                <option value="pembimbing_utama">Pembimbing Utama</option>
                                <option value="pembimbing_pendamping">Pembimbing Pendamping</option>
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
        $(document).on('submit','#form-edit-R07',function (event){
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
