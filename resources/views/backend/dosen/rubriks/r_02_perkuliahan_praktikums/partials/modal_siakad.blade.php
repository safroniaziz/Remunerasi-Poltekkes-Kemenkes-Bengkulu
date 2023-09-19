@push('styles')
    <style>
        #loading {
            display: none;
            text-align: center;
        }

        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid #3498db;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
            margin-top: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endpush

<div class="modal fade" id="modalDetail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('dosen.r_02_perkuliahan_praktikum.siakad_post') }}" method="POST" id="form-siakad">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-refresh"></i>&nbsp;Sinkronisasi Data Siakad</p>
                </div>
                <div class="modal-body" id="loader">
                    <div class="text-center">
                        <div id="loading" style="">
                            <div class="spinner"></div>
                            Sedang menyimpan data...
                        </div>
                    </div>
                    <input type="hidden" name="kodeProdi" id="kodeProdiSiakad" class="form-control">
                    <input type="hidden" name="kodeJenjang" id="kodeJenjangSiakad" class="form-control">
                    <div id="data">
                        <div class="alert alert-danger" style="display: none" id="alertDanger">
                            <b>Perhatian : </b> Silahkan Hanya Memilih Mata Kuliah Non BKD Saja
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_siakad">
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm btn-flat " data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                <button type="submit" class="btn btn-primary btn-sm btn-flat" id="btnSubmit"><i class="fa fa-check-circle"></i>&nbsp;Proses Sinkronisasi Siakad</button>
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
        $(document).on('submit','#form-siakad',function (event){
            event.preventDefault();
            toastr.info('Harap menunggu hingga proses selesai...');
            $('#loading').show();
            $('#data').hide();
            $("#btnSubmit"). attr("disabled", true);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: "JSON", // Perbaiki typo di "typeData" menjadi "dataType"
                data: new FormData(this),
                processData:false,
                contentType:false,
                success : function(res) {
                    toastr.success(res.text, 'Yeay, Berhasil');
                    setTimeout(function () {
                        window.location.href=res.url;
                    } , 500);
                },
                error:function(xhr){
                    toastr.error(xhr.responseJSON.text, 'Ooopps, Ada Kesalahan');
                },
                complete: function() {
                    // Sembunyikan elemen loading dan tampilkan kembali tombol submit
                    $('#loading').hide();
                    $('#data').show();
                    $("#btnSubmit").attr("disabled", false);
                    $('modal').hide();
                    $('#modalDetail').hide();
                }
            })
        });
    </script>
@endpush