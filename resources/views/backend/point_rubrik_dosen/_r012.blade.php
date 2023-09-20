<thead>
    <tr>
        <th>No</th>
        <th>Status PKM</th>
        <th>Status Juara</th>
        <th>Jumlah Pembimbing</th>
        <th>Point</th>
    </tr>
</thead>
<tbody>
    @foreach ($borangs as $index => $borang)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $borang->tingkat_pkm }}</td>
            <td>{{ $borang->juara_ke }}</td>
            <td>{{ $borang->jumlah_pembimbung }}</td>
            <td>{{ $borang->point }}</td>
        </tr>
    @endforeach
</tbody>
