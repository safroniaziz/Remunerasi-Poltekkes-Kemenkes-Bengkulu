<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('r_015_menulis_karya_ilmiah_dipublikasikan.update') }}" method="POST" id="form-edit-R015">
                {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Edit Rubrik 14 Karya Inovasi</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="r015karyailmiahpublikasi_id_edit" id="r015karyailmiahpublikasi_id_edit">
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
                            <label for="exampleInputEmail1">Judul</label>
                            <input type="text" class="form-control" id="judul_edit" name="judul">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Penulis Ke</label>
                            <input type="text" class="form-control" id="penulis_ke_edit" name="penulis_ke">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Jumlah Penulis</label>
                            <input type="text" class="form-control" id="jumlah_penulis_edit" name="jumlah_penulis">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Jenis</label>
                            <select name="jenis" class="form-control" id="jenis_edit">
                                <option disabled selected>-- pilih Jenis --</option>
                                <option value="Q1">Internasional Q1</option>
                                <option value="Q2">Internasional Q2</option>
                                <option value="Q3">Internasional Q3</option>
                                <option value="Q4">Internasional Q4</option>
                                <option value="1">Nasional Sinta 1</option>
                                <option value="2">Nasional Sinta 2</option>
                                <option value="3">Nasional Sinta 3</option>
                                <option value="4">Nasional Sinta 4</option>
                                <option value="5">Nasional Sinta 5</option>
                                <option value="6">Nasional Sinta 6</option>
                                <option value="oral_presentation_inter">Seminar Oral Presentation Internasional</option>
                                <option value="oral_presentation_nasional">Seminar Oral Presentation Nasional</option>
                                <option value="poster_internasional">Seminar Poster Internasional</option>
                                <option value="poster_nasional">Seminar Poster Nasional</option>
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
        $(document).on('submit','#form-edit-R015',function (event){
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
