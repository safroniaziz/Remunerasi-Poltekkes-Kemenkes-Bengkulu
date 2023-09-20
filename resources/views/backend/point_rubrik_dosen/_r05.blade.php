<thead>
    <tr>
        <th>No</th>
        <th>Jumlah SKS</th>
        <th>Jumlah Mahasiswa</th>
        <th>Jumlah Tatap Muka</th>
        <th>Point</th>
    </tr>
</thead>
<tbody>
    @foreach ($borangs as $index => $borang)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $borang->jumlah_sks }}</td>
            <td>{{ $borang->jumlah_mahasiswa }}</td>
            <td>{{ $borang->jumlah_tatap_muka }}</td>
            <td>{{ $borang->point }}</td>
        </tr>
    @endforeach
</tbody>
