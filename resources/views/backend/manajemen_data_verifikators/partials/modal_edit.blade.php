<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('manajemen_data_verifikator.update') }}" method="POST" id="form-edit">
                {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Edit Verifikator</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="verifikator_id" id="verifikator_id_edit">
                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_user_edit" name="nama_user" >
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Jurusan</label>
                            <select name="kodefak" class="form-control" id="kodefak_edit">
                                <option disabled selected>-- pilih Jurusan --</option>
                                @foreach ($fakultases as $fakultas)
                                    <option value="{{ $fakultas->kodefak }}">{{ $fakultas->nmfak }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="email_edit">
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Status Verifikator</label>
                            <select name="is_active" class="form-control" id="is_active_edit">
                                <option disabled selected>-- pilih status --</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
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
        $(document).on('submit','#form-edit',function (event){
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
