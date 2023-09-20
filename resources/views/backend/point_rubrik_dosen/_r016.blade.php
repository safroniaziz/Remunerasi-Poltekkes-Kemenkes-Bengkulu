<thead>
    <tr>
        <th>No</th>
        <th>Judul Buku </th>
        <th>Kode ISBN</th>
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
