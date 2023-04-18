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
<li class="{{ set_active('jabatan_dt') }}">
    <a href="{{ route('jabatan_dt') }}">
        <i class="fa fa-briefcase"></i>
        <span>Data Jabatan DT</span>
    </a>
</li>
<li class="{{ set_active('jabatan_ds') }}">
    <a href="{{ route('jabatan_ds') }}">
        <i class="fa fa-address-book"></i>
        <span>Data Jabatan DS</span>
    </a>
</li>
<li class="{{ set_active('jabatan_fungsional') }}">
    <a href="{{ route('jabatan_fungsional') }}">
        <i class="fa fa-address-book"></i>
        <span>Data Jabatan Fungsional</span>
    </a>
</li>
<li class="{{ set_active('kelompok_rubrik') }}">
    <a href="{{ route('kelompok_rubrik') }}">
        <i class="fa fa-address-book"></i>
        <span>Data Kelompok Rubrik</span>
    </a>
</li>
<li class="{{ set_active('nilai_ewmp') }}">
    <a href="{{ route('nilai_ewmp') }}">
        <i class="fa fa-address-book"></i>
        <span>Data Nilai Ewmp</span>
    </a>
</li>
<li class="{{ set_active('pengumuman') }}">
    <a href="{{ route('pengumuman') }}">
        <i class="fa fa-address-book"></i>
        <span>Data Pengumuman</span>
    </a>
</li>
<li class="header" style="font-weight:bold">PENGATURAN</li>
<li class="{{ set_active('periode_penilaian') }}">
    <a href="{{ route('periode_penilaian') }}">
        <i class="fa fa-clock-o"></i>
        <span>Periode Penilaian</span>
    </a>
</li>
