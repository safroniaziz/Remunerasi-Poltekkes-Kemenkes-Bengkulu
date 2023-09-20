<thead>
    <tr>
        <th>No</th>
        <th>Judul Kegiatan </th>
        <th>Skala Kegiatan</th>
        <th>Point</th>
    </tr>
</thead>
<tbody>
    @foreach ($borangs as $index => $borang)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $borang->judul_kegiatan }}</td>
            <td>{{ $borang->tingkatan_ke }}</td>
            <td>{{ $borang->point }}</td>
        </tr>
    @endforeach
</tbody>
