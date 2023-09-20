<thead>
    <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Status Penulis</th>
        <th>Jenis Karya</th>
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
