<table style="width: 100%" class="striped bordered">
    <thead>
            <tr>
                <td colspan="6" style="text-transform: uppercase; font-weight:bold;">{{$index+1 .' '. $riwayatPoint->nama_rubrik }}</td>
            </tr>
            <tr>
                <td colspan="6" style="text-transform: uppercase; font-weight:bold;">Total Point {{ $riwayatPoint->point }}</td>
            </tr>
        <tr>
            <th>No</th>
            <th>Nama Mata Kuliah </th>
            <th>Kode Kelas</th>
            <th>Jumlah Mahasiswa</th>
            <th>Jumlah Tatap Muka</th>
            <th>Point</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($borangs as $index => $borang)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $borang->nama_matkul }}</td>
                <td>{{ $borang->kode_kelas }}</td>
                <td>{{ $borang->jumlah_mahasiswa }}</td>
                <td>{{ $borang->jumlah_tatap_muka }}</td>
                <td>{{ $borang->point }}</td>
            </tr>
        @endforeach
    </table>
</tbody>