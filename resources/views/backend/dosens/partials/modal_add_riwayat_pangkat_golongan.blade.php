<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dosen.riwayat_pangkat_golongan.store',[$pegawai->slug]) }}" method="POST" class="form">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Tambah Riwayat Pangkat & Golongan</p>
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
                            <label for="golongan" class="col-form-label">Golongan</label>
                            <select name="golongan" id="golongan" class="form-control">
                                <option disabled selected>-- pilih golongan --</option>
                                <option value="I">Golongan I (Juru)</option>
                                <option value="II">Golongan II (Pengatur)</option>
                                <option value="III">Golongan III (Penata)</option>
                                <option value="IV">Golongan IV (Pembina)</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="">Pilih Pangkat :</label>
                            <select name="nama_pangkat" id="nama_pangkat" class="form-control" style="font-size:13px;">
                                <option value="" disabled selected>-- pilih pangkat --</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label>TMT Pangkat & Golongan</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" value="{{ old('tmt_pangkat_golongan') }}" name="tmt_pangkat_golongan" id="tmt_pangkat_golongan" class="form-control pull-right">
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
        $(document).ready(function(){
            $(document).on('change','#golongan',function(){
                // alert('berhasil');
                var golongan = $(this).val();
                var div = $(this).parent().parent();
                var op=" ";
                op+='<option selected disabled>-- pilih pangkat --</option>';

                if (golongan == "I") {
                    op+='<option value="IA">'+"IA Juru Muda"+'</option>';
                    op+='<option value="IB">'+"IB Juru Muda Tingkat 1"+'</option>';
                    op+='<option value="IC">'+"IC Juru"+'</option>';
                    op+='<option value="ID">'+"ID Juru Tingkat 1"+'</option>';
                }else if(golongan == "II"){
                    op+='<option value="IIA">'+"IIA Pengatur Muda"+'</option>';
                    op+='<option value="IIB">'+"IIB Pengatur Muda Tingkat 1"+'</option>';
                    op+='<option value="IIC">'+"IIC Pengatur"+'</option>';
                    op+='<option value="IID">'+"IID Pengatur Tingkat 1"+'</option>';
                }else if(golongan == "III"){
                    op+='<option value="IIIA">'+"IIIA Penata Muda"+'</option>';
                    op+='<option value="IIIB">'+"IIIB Penata Muda Tingkat 1"+'</option>';
                    op+='<option value="IIIC">'+"IIIC Penata"+'</option>';
                    op+='<option value="IIID">'+"IIID Penata Tingkat 1"+'</option>';
                }else{
                    op+='<option value="IVA">'+"IVA Pembina"+'</option>';
                    op+='<option value="IVB">'+"IVB Pembina Tingkat 1"+'</option>';
                    op+='<option value="IVC">'+"IVC Pembina Utama Muda"+'</option>';
                    op+='<option value="IVD">'+"IVD Pembina Utama Madya"+'</option>';
                    op+='<option value="IVE">'+"IVE Pembina Utama"+'</option>';
                }
                div.find('#nama_pangkat').html(" ");
                div.find('#nama_pangkat').append(op);
            })
        });

        $('#tmt_pangkat_golongan').datepicker({
            format: 'yyyy/mm/dd', autoclose: true
        })
    </script>
@endpush