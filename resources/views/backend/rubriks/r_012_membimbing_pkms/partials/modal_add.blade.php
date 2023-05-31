<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('r_012_membimbing_pkm.store') }}" method="POST" id="form-tambah-r-012">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Tambah Rubrik 12 Membimbing PKM</p>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-md-12" >
                            <label for="periode_id" class="col-form-label">Periode Aktif</label>
                            <input type="text" class="form-control" value="{{ $periode->nama_periode }}" disabled>
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">NIP</label>
                            <select name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror">
                                <option disabled selected>-- Pilih NIP --</option>
                                @foreach ($pegawais as $pegawai)
                                    <option value="{{ $pegawai->nip }}">{{ $pegawai->nip }} -> {{ $pegawai->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Tingkat PKM </label>
                            <select name="tingkat_pkm" class="form-control" id="tingkat_pkm">
                                <option disabled selected>-- pilih Tingkat PKM --</option>
                                <option value="internasional">internasional</option>
                                <option value="nasional">nasional</option>
                                <option value="regional">regional</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Juara </label>
                            <select name="juara_ke" class="form-control" id="juara_ke">
                                <option disabled selected>-- pilih Juara --</option>
                                <option value="1">Juara 1 Internasional</option>
                                <option value="2">Juara 2 Internasional</option>
                                <option value="3">Juara 3 Internasional</option>
                                <option value="4">Internasional Tidak Juara</option>
                                <option value="5">Juara 1 nasional</option>
                                <option value="6">Juara 2 nasional</option>
                                <option value="7">Juara 3 nasional</option>
                                <option value="8">Nasional Tidak Juara</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Jumlah pembimbing</label>
                            <input type="text" class="form-control" id="jumlah_pembimbing" name="jumlah_pembimbing">
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
        $(document).on('submit','#form-tambah-r-012',function (event){
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

        $('#tmt_jabatan_fungsional').datepicker({
            format: 'yyyy/mm/dd', autoclose: true
        })
    </script>
@endpush