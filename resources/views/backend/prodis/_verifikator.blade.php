<div class="col-md-12">
    <table class="table table-striped table-bordered" id="table" style="width:100%;">
        <tbody>
            <tr>
                <th colspan="3" style="text-transform: uppercase"><u>Data Verifikator</u></th>
            </tr>
            <tr>
                <th>Nama Verifikator</th>
                <td>:</td>
                <td>{{ $prodi->verifikator->nama }}</td>
            </tr>
            <tr>
                <th>NIP Verifikator</th>
                <td>:</td>
                <td>{{ $prodi->verifikator->nip }}</td>
            </tr>
            <tr>
                <th>Prodi Verifikator</th>
                <td>:</td>
                <td>{{ $prodi->verifikator->prodi ? $prodi->verifikator->prodi->nama_prodi : '-' }}</td>
            </tr>
            <tr>
                <th>Fakultas Verifikator</th>
                <td>:</td>
                <td>{{ $prodi->verifikator->prodi && $prodi->verifikator->prodi->nmfak != null ? $prodi->verifikator->prodi->nmfak : '-' }}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="col-md-12">
    <table class="table table-striped table-bordered" id="table" style="width:100%;">
        <tbody>
            <tr>
                <th colspan="3" style="text-transform: uppercase"><u>Data Penanggung Jawab</u></th>
            </tr>
            <tr>
                <th>Nama Verifikator</th>
                <td>:</td>
                <td>{{ $prodi->penanggungJawab->nama }}</td>
            </tr>
            <tr>
                <th>NIP Verifikator</th>
                <td>:</td>
                <td>{{ $prodi->penanggungJawab->nip }}</td>
            </tr>
            <tr>
                <th>Prodi Verifikator</th>
                <td>:</td>
                <td>{{ $prodi->penanggungJawab->prodi ? $prodi->penanggungJawab->prodi->nama_prodi : '-' }}</td>
            </tr>
            <tr>
                <th>Fakultas Verifikator</th>
                <td>:</td>
                <td>{{ $prodi->penanggungJawab->prodi && $prodi->penanggungJawab->prodi->nmfak != null ? $prodi->penanggungJawab->prodi->nmfak : '-' }}</td>
            </tr>
        </tbody>
    </table>
</div>