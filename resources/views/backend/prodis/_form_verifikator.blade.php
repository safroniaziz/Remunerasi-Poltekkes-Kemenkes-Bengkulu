<form action="{{ route('prodi.verifikator_store',[$prodi->id_prodi]) }}" method="POST" class="form">
    @csrf @method('PATCH')
    <div class="form-group col-md-12">
        <label for="">Pilih Verifikator</label>
        <select name="verifikator_nip" class="form-control select2" id="">
            <option disabled selected>-- pilih verifikator --</option>
            @foreach ($verifikators as $verifikator)
                <option value="{{ $verifikator->nip }}">{{ $verifikator->nama }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="">Pilih Penanggung Jawab</label>
        <select name="penanggung_jawab_nip" class="form-control select2" id="">
            <option disabled selected>-- pilih penanggung jawab --</option>
            @foreach ($verifikators as $verifikator)
                <option value="{{ $verifikator->nip }}">{{ $verifikator->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12">
        <button type="reset" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-refresh"></i>&nbsp; Reset</button>
        <button type="submit" class="btn btn-primary btn-sm btn-flat btnSubmit"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
    </div>
</form>

@push('scripts')
    <script>
        $(document).on('submit','.form',function (event){
            event.preventDefault();
            $(".btnSubmit"). attr("disabled", true);
            $('.btnSubmit').html('<i class="fa fa-check-circle"></i>&nbsp; Menyimpan');  // Mengembalikan teks tombol
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                typeData: "JSON",
                data: new FormData(this),
                processData:false,
                contentType:false,
                success : function(res) {
                    $(".btnSubmit"). attr("disabled", true);
                    toastr.success(res.text, 'Yeay, Berhasil');
                    setTimeout(function () {
                        window.location.href=res.url;
                    } , 500);
                },
                error:function(xhr){
                    toastr.error(xhr.responseJSON.text, 'Ooopps, Ada Kesalahan');
                    setTimeout(function() {
                        $(".btnSubmit").prop('disabled', false);  // Mengaktifkan tombol kembali
                        $(".btnSubmit").html('<i class="fa fa-check-circle"></i>&nbsp; Simpan Data');  // Mengembalikan teks tombol
                    }, 500); // Waktu dalam milidetik (2000 ms = 2 detik)
                }
            })
        });
    </script>
@endpush