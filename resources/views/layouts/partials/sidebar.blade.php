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
<li class="{{ set_active('jabatandt') }}">
    <a href="{{ route('jabatandt') }}">
        <i class="fa fa-briefcase"></i>
        <span>Data Jabatan DT</span>
    </a>
</li>
<li class="{{ set_active('jabatands') }}">
    <a href="{{ route('jabatands') }}">
        <i class="fa fa-address-book"></i>
        <span>Data Jabatan DS</span>
    </a>
</li>

<li class="header" style="font-weight:bold">PENGATURAN</li>
<li class="{{ set_active('periode_penilaian') }}">
    <a href="{{ route('periode_penilaian') }}">
        <i class="fa fa-clock-o"></i>
        <span>Periode Penilaian</span>
    </a>
</li>