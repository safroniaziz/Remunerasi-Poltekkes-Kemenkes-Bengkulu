<li class="{{ set_active('dashboard') }}">
    <a href="{{ route('dashboard') }}">
        <i class="fa fa-home"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="header" style="font-weight:bold">DATA MASTER</li>
<li class="{{ set_active('dosen') }}">
    <a href="{{ route('dosen') }}">
        <i class="fa fa-users"></i>
        <span>Data Dosen</span>
    </a>
</li>

<li class="treeview {{ set_active([
        'jabatan_dt','jabatan_dt.create','jabatan_dt.edit',
        'jabatan_ds','jabatan_ds.create','jabatan_ds.edit',
        'jabatan_fungsional','jabatan_ds.create','jabatan_ds.edit'
    ]) }}">
    <a href="#">
        <i class="fa fa-file-text-o"></i> <span>Grade & Harga Jabatan</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu " style="padding-left:25px;">
        <li class="{{ set_active(['jabatan_dt','jabatan_dt.create','jabatan_dt.edit']) }}"><a href="{{ route('jabatan_dt') }}"><i class="fa fa-circle-o"></i>Tugas Tambahan</a></li>
        <li class="{{ set_active(['jabatan_ds','jabatan_ds.create','jabatan_ds.edit']) }}"><a href="{{ route('jabatan_ds') }}"><i class="fa fa-circle-o"></i>Jabatan DS</a></li>
        <li class="{{ set_active(['jabatan_fungsional','jabatan_fungsional.create','jabatan_fungsional.edit']) }}"><a href="{{ route('jabatan_fungsional') }}"><i class="fa fa-circle-o"></i>Jabatan Fungsional</a></li>
    </ul>
</li>

<li class="{{ set_active('pangkat_golongan') }}">
    <a href="{{ route('pangkat_golongan') }}">
        <i class="fa fa-gg"></i>
        <span>Data Pangkat Golongan</span>
    </a>
</li>

<li class="{{ set_active('kelompok_rubrik') }}">
    <a href="{{ route('kelompok_rubrik') }}">
        <i class="fa fa-file-powerpoint-o"></i>
        <span>Data Kelompok Rubrik</span>
    </a>
</li>
<li class="{{ set_active('nilai_ewmp') }}">
    <a href="{{ route('nilai_ewmp') }}">
        <i class="fa fa-check-square-o"></i>
        <span>Data Nilai Ewmp</span>
    </a>
</li>
<li class="{{ set_active('presensi') }}">
    <a href="{{ route('presensi') }}">
        <i class="fa fa-info-circle"></i>
        <span>Data presensi</span>
    </a>
</li>
<li class="{{ set_active('pengumuman') }}">
    <a href="{{ route('pengumuman') }}">
        <i class="fa fa-info-circle"></i>
        <span>Data Pengumuman</span>
    </a>
</li>
<li class="{{ set_active('riwayat_jabatan_dt') }}">
    <a href="{{ route('riwayat_jabatan_dt') }}">
        <i class="fa fa-info-circle"></i>
        <span>Data Riwayat Jabatan DT</span>
    </a>
</li>
<li class="{{ set_active('riwayat_point') }}">
    <a href="{{ route('riwayat_point') }}">
        <i class="fa fa-info-circle"></i>
        <span>Data Riwayat Point</span>
    </a>
</li>

<li class="header" style="font-weight:bold">PENGATURAN</li>
<li class="{{ set_active('periode_penilaian') }}">
    <a href="{{ route('periode_penilaian') }}">
        <i class="fa fa-clock-o"></i>
        <span>Periode Penilaian</span>
    </a>
</li>

