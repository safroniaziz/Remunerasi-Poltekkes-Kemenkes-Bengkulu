<!-- Modal Ubah Password-->
<div class="modal fade" id="modalubahpassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <p style="font-size:15px;" class="modal-title" id="exampleModalLabel"><i class="fa fa-user"></i>&nbsp;Form Ubah Password Administrator
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </p>
        </div>
        <form action=" {{ route('manajemen_data_verifikator.ubahPassword') }} " method="POST" enctype="multipart/form-data" id="form-ubah-password">
            {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="modal-body">
                    <input type="hidden" name="id" id="id_password">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password Login</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="********">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"  class="form-control" placeholder="********">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm btn-flat"  data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                    <button type="submit" class="btn btn-primary btn-sm btn-flat btnSubmit"><i class="fa fa-check-circle"></i>&nbsp;Simpan Perubahan Password</button>
                </div>
            </div>
        </form>
    </div>
</div>


