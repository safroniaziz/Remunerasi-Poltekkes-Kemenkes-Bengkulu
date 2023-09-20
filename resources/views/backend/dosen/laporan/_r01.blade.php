<tr>
    <th>No</th>
    <th>Nama Mata Kuliah </th>
    <th>Kode Kelas</th>
    <th>Jumlah Mahasiswa</th>
    <th>Jumlah Tatap Muka</th>
    <th>Point</th>
</tr>
@foreach ($borangs as $index => $borang)
    <tr>
        <td>{{ $index+1 }}</td>
        <td>{{ $borang->nama_matkul }}</td>
        <td>{{ $borang->kode_kelas }}</td>
        <td>{{ $borang->jumlah_mahasiswa }}</td>
        <td>{{ $borang->jumlah_tatap_muka }}</td>
        <td>{{ $borang->point }}</td>
    </tr>
@endforeach