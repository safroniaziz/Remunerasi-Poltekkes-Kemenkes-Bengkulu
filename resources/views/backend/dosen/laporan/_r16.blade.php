<table style="width: 100%" class="striped bordered">
    <thead>
        <tr>
            <td colspan="4" style="text-transform: uppercase; font-weight:bold;">{{$index+1 .' '. $riwayatPoint->nama_rubrik }}</td>
        </tr>
        <tr>
            <td colspan="4" style="text-transform: uppercase; font-weight:bold;">Total Point {{ $riwayatPoint->point }}</td>
        </tr>
        <tr>
            <th>No</th>
            <th>Judul Buku </th>
            <th>ISBN </th>
            <th>Point</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($borangs as $index => $borang)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $borang->judul_buku }}</td>
                <td>{{ $borang->isbn }}</td>
                <td>{{ $borang->point }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
