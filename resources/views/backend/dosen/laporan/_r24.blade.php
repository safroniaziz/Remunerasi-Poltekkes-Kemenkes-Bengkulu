<table style="width: 100%" class="striped bordered">
    <thead>
        <tr>
            <td colspan="3" style="text-transform: uppercase; font-weight:bold;">{{$index+1 .' '. $riwayatPoint->nama_rubrik }}</td>
        </tr>
        <tr>
            <td colspan="3" style="text-transform: uppercase; font-weight:bold;">Total Point {{ $riwayatPoint->point }}</td>
        </tr>
        <tr>
            <th>No</th>
            <th>Judul Kegiatan </th>
            <th>Point</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($borangs as $index => $borang)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $borang->judul_kegiatan }}</td>
                <td>{{ $borang->point }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
