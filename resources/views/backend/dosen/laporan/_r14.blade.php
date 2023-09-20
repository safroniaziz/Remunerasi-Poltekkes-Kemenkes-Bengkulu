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
            <th>Judul </th>
            <th>Penulis Ke </th>
            <th>Jenis</th>
            <th>Jumlah Penulis</th>
            <th>Point</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($borangs as $index => $borang)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $borang->judul }}</td>
                <td>{{ $borang->penulis_ke }}</td>
                <td>{{ $borang->jenis }}</td>
                <td>{{ $borang->jumlah_penulis }}</td>
                <td>{{ $borang->point }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
