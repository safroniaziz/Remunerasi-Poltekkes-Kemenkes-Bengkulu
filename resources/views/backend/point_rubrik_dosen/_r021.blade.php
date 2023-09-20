<thead>
    <tr>
        <th>No</th>
        <th>Judul Protokol Penelitian</th>
        <th>Point</th>
    </tr>
</thead>
<tbody>
    @foreach ($borangs as $index => $borang)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $borang->judul_protokol_penelitian }}</td>
            <td>{{ $borang->point }}</td>
        </tr>
    @endforeach
</tbody>
