<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('r_019_latih_nyuluh_natar_ceramah_warga.store') }}" method="POST" id="form-tambah-r-019">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Tambah Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat</p>
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

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Judul Kegiatan</label>
                            <input type="text" class="form-control" id="judul_kegiatan" name="judul_kegiatan">
                        </div>

                        <div class="form-group col-md-12" >
                            <label for="nip" class="col-form-label">Jenis</label>
                            <select name="jenis" class="form-control" id="jenis">
                                <option disabled selected>-- pilih Jenis --</option>
                                <option value="insidentil">Insidentil</option>
                                <option value="non_isidentil">Latihan/ penyuluhan/ pantaran/ ceramah</option>
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
        $(document).on('submit','#form-tambah-r-019',function (event){
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
