<thead>
    <tr>
        <th>No</th>
        <th>Status Keanggotaan</th>
        <th>Point</th>
    </tr>
</thead>
<tbody>
    @foreach ($borangs as $index => $borang)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $borang->jabatan }}</td>
            <td>{{ $borang->point }}</td>
        </tr>
    @endforeach
</tbody>
