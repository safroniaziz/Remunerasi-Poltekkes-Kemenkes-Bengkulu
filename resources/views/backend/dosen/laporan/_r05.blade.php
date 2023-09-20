<table style="width: 100%" class="striped bordered">
    <thead>
        <tr>
            <td colspan="5" style="text-transform: uppercase">{{$index+1 .' '. $riwayatPoint->nama_rubrik }}</td>
        </tr>
        <tr>
            <td colspan="5" style="text-transform: uppercase">Total Point {{ $riwayatPoint->point }}</td>
        </tr>
        <tr>
            <th>No</th>
            <th>Jumlah SKS </th>
            <th>Jumlah Mahasiswa </th>
            <th>Jumlah Tatap Muka </th>
            <th>Point</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($borangs as $index => $borang)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $borang->jumlah_sks }}</td>
                <td>{{ $borang->jumlah_mahasiswa }}</td>
                <td>{{ $borang->jumlah_tatap_muka }}</td>
                <td>{{ $borang->point }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
