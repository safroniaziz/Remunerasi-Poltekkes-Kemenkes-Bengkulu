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
            <th>Judul </th>
            <th>ISBN </th>
            <th>Penulis Ke </th>
            <th>Jumlah Penulis </th>
            <th>Point</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($borangs as $index => $borang)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $borang->judul }}</td>
                <td>{{ $borang->isbn }}</td>
                <td>{{ $borang->penulis_ke }}</td>
                <td>{{ $borang->jumlah_penulis }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
