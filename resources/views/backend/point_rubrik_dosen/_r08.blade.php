<thead>
    <tr>
        <th>No</th>
        <th>Jumlah Mahasiswa</th>
        <th>Jenis Seminar</th>
        <th>Point</th>
    </tr>
</thead>
<tbody>
    @foreach ($borangs as $index => $borang)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $borang->jumlah_mahasiswa }}</td>
            <td>{{ $borang->jenis }}</td>
            <td>{{ $borang->point }}</td>
        </tr>
    @endforeach
</tbody>
