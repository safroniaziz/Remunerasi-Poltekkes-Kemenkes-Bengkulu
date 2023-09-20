<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('periode_penilaian.update') }}" method="POST" id="form-edit-periode-penilaian">
                {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Edit Periode Penilaian</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="periode_id_edit" id="periode_id_edit">
                        <div class="form-group col-md-12" >
                            <label for="nama" class="col-form-label">Nama Periode Penilaian</label>
                            <input type="text" class="form-control" id="nama_periode_edit" name="nama_periode_edit" >
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Semester</label>
                            <select name="semester_edit" class="form-control" id="semester_edit">
                                <option disabled selected>-- pilih semester --</option>
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Tahun Ajaran</label>
                            <input type="text" class="form-control" id="tahun_ajaran_edit" name="tahun_ajaran_edit" >
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Bulan Pembayaran</label>
                            <select name="bulan_pembayaran_edit" class="form-control" id="bulan_pembayaran_edit">
                                <option disabled selected>-- pilih bulan pembayaran--</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
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
        $(document).on('submit','#form-edit-periode-penilaian',function (event){
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