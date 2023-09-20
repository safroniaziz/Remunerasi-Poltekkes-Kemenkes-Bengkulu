<thead>
    <tr>
        <th>No</th>
        <th>Jenis Kegiatan</th>
        <th>Point</th>
    </tr>
</thead>
<tbody>
    @foreach ($borangs as $index => $borang)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $borang->jenis_kegiatan }}</td>
            <td>{{ $borang->point }}</td>
        </tr>
    @endforeach
</tbody>
