<thead>
    <tr>
        <th>No</th>
        <th>Judul Hibah PKM </th>
        <th>Point</th>
    </tr>
</thead>
<tbody>
    @foreach ($borangs as $index => $borang)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $borang->judul_hibah_pkm }}</td>
            <td>{{ $borang->point }}</td>
        </tr>
    @endforeach
</tbody>
