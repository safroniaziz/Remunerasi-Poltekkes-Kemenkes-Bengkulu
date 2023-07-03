<li class="{{ set_active('dosen.dashboard') }}">
    <a href="{{ route('dosen.dashboard') }}">
        <i class="fa fa-home"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="treeview {{ set_active([
        'dosen.r_01_perkuliahan_teori',
        'dosen.r_02_perkuliahan_praktikum',
        'dosen.r_03_membimbing_pencapaian_kompetensi',
        'dosen.r_04_membimbing_pendampingan_ukom',
        'dosen.r_05_membimbing_praktik_pkk_pbl_klinik',
        'dosen.r_06_menguji_ujian_osca',
        'dosen.r_07_membimbing_skripsi_lta_la_profesi',
        'dosen.r_08_menguji_seminar_proposal_kti_lta_skripsi',
        'dosen.r_09_menguji_seminar_hasil_kti_lta_skripsi',
        'dosen.r_010_menulis_buku_ajar_berisbn',
        'dosen.r_011_mengembangkan_modul_berisbn',
        'dosen.r_012_membimbing_pkm',
    ]) }}">
    <a href="#" class="parent-sidebar-menu">
        <i class="fa fa-file-text-o"></i> <span>Pendidikan Reguler</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu child-sidebar-menu">
        <li class="{{ set_active(['dosen.r_01_perkuliahan_teori']) }}"><a href="{{ route('dosen.r_01_perkuliahan_teori') }}"><i class="fa fa-circle-o"></i>Perkuliahan Teori</a></li>
        <li class="{{ set_active(['dosen.r_02_perkuliahan_praktikum']) }}"><a href="{{ route('dosen.r_02_perkuliahan_praktikum') }}"><i class="fa fa-circle-o"></i>Perkuliahan Praktikum</a></li>
        <li class="{{ set_active(['dosen.r_03_membimbing_pencapaian_kompetensi']) }}"><a href="{{ route('dosen.r_03_membimbing_pencapaian_kompetensi') }}"><i class="fa fa-circle-o"></i>Memb. Capaian Kompetensi</a></li>
        <li class="{{ set_active(['dosen.r_04_membimbing_pendampingan_ukom']) }}"><a href="{{ route('dosen.r_04_membimbing_pendampingan_ukom') }}"><i class="fa fa-circle-o"></i>Memb. Pendamping UKOM</a></li>
        <li class="{{ set_active(['dosen.r_05_membimbing_praktik_pkk_pbl_klinik']) }}"><a href="{{ route('dosen.r_05_membimbing_praktik_pkk_pbl_klinik') }}"><i class="fa fa-circle-o"></i>Memb. Praktik PKK/PBL Klinik</a></li>
        <li class="{{ set_active(['dosen.r_06_menguji_ujian_osca']) }}"><a href="{{ route('dosen.r_06_menguji_ujian_osca') }}"><i class="fa fa-circle-o"></i>Menguji Ujian OSCA</a></li>
        <li class="{{ set_active(['dosen.r_07_membimbing_skripsi_lta_la_profesi']) }}"><a href="{{ route('dosen.r_07_membimbing_skripsi_lta_la_profesi') }}"><i class="fa fa-circle-o"></i>Memb. Skripsi/LTA/LA Profesi</a></li>
        <li class="{{ set_active(['dosen.r_08_menguji_seminar_proposal_kti_lta_skripsi']) }}"><a href="{{ route('dosen.r_08_menguji_seminar_proposal_kti_lta_skripsi') }}"><i class="fa fa-circle-o"></i>Meng. Sempro. LTA/LA/Skripsi</a></li>
        <li class="{{ set_active(['dosen.r_09_menguji_seminar_hasil_kti_lta_skripsi']) }}"><a href="{{ route('dosen.r_09_menguji_seminar_hasil_kti_lta_skripsi') }}"><i class="fa fa-circle-o"></i>Meng. Semhas. LTA/LA/Skripsi</a></li>
        <li class="{{ set_active(['dosen.r_010_menulis_buku_ajar_berisbn']) }}"><a href="{{ route('dosen.r_010_menulis_buku_ajar_berisbn') }}"><i class="fa fa-circle-o"></i>Menulis Buku Ajar Ber-ISBN</a></li>
        <li class="{{ set_active(['dosen.r_011_mengembangkan_modul_berisbn']) }}"><a href="{{ route('dosen.r_011_mengembangkan_modul_berisbn') }}"><i class="fa fa-circle-o"></i>Mengemb. Modul Ber-ISBN</a></li>
        <li class="{{ set_active(['dosen.r_012_membimbing_pkm']) }}"><a href="{{ route('dosen.r_012_membimbing_pkm') }}"><i class="fa fa-circle-o"></i>Membimbing PKM</a></li>
    </ul>
</li>

<li class="treeview {{ set_active([
    'dosen.r_013_orasi_ilmiah_narasumber_bidang_ilmu',
    'dosen.r_014_karya_inovasi',
]) }}">
<a href="#" class="parent-sidebar-menu">
    <i class="fa fa-file-text-o"></i> <span>Pendidikan Insidental</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
</a>
<ul class="treeview-menu child-sidebar-menu">
    <li class="{{ set_active(['dosen.r_013_orasi_ilmiah_narasumber_bidang_ilmu']) }}"><a href="{{ route('dosen.r_013_orasi_ilmiah_narasumber_bidang_ilmu') }}"><i class="fa fa-circle-o"></i>Orasi Ilmiah Narasumber</a></li>
    <li class="{{ set_active(['dosen.r_014_karya_inovasi']) }}"><a href="{{ route('dosen.r_014_karya_inovasi') }}"><i class="fa fa-circle-o"></i>Karya Inovasi</a></li>
</ul>
</li>

<li class="treeview {{ set_active([
    'dosen.r_015_menulis_karya_ilmiah_dipublikasikan',
    'dosen.r_016_naskah_buku_bahasa_terbit_edar_inter',
    'dosen.r_017_naskah_buku_bahasa_terbit_edar_nas',
]) }}">
<a href="#" class="parent-sidebar-menu">
    <i class="fa fa-file-text-o"></i> <span>Pelaksanaan Penelitian</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
</a>
<ul class="treeview-menu child-sidebar-menu">
    <li class="{{ set_active(['dosen.r_015_menulis_karya_ilmiah_dipublikasikan']) }}"><a href="{{ route('dosen.r_015_menulis_karya_ilmiah_dipublikasikan') }}"><i class="fa fa-circle-o"></i>Karya Ilmiah Diplublikasikan</a></li>
    <li class="{{ set_active(['dosen.r_016_naskah_buku_bahasa_terbit_edar_inter']) }}"><a href="{{ route('dosen.r_016_naskah_buku_bahasa_terbit_edar_inter') }}"><i class="fa fa-circle-o"></i>Naskah Buku Internasional</a></li>
    <li class="{{ set_active(['dosen.r_017_naskah_buku_bahasa_terbit_edar_nas']) }}"><a href="{{ route('dosen.r_017_naskah_buku_bahasa_terbit_edar_nas') }}"><i class="fa fa-circle-o"></i>Naskah Buku Nasional</a></li>
</ul>
</li>

<li class="treeview {{ set_active([
    'dosen.r_018_mendapat_hibah_pkm',
    'dosen.r_019_latih_nyuluh_natar_ceramah_warga',
]) }}">
<a href="#" class="parent-sidebar-menu">
    <i class="fa fa-file-text-o"></i> <span>Pelaksanaan Pengabdian</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
</a>
<ul class="treeview-menu child-sidebar-menu">
    <li class="{{ set_active(['dosen.r_018_mendapat_hibah_pkm']) }}"><a href="{{ route('dosen.r_018_mendapat_hibah_pkm') }}"><i class="fa fa-circle-o"></i>Mendapatkan Hibah PKM</a></li>
    <li class="{{ set_active(['dosen.r_019_latih_nyuluh_natar_ceramah_warga']) }}"><a href="{{ route('dosen.r_019_latih_nyuluh_natar_ceramah_warga') }}"><i class="fa fa-circle-o"></i>Latihan Pada Masyarakat</a></li>
</ul>
</li>

<li class="treeview {{ set_active([
    'dosen.r_020_assessor_bkd_lkd',
    'dosen.r_021_reviewer_eclere_penelitian_dosen',
    'dosen.r_022_reviewer_eclere_penelitian_mhs',
    'dosen.r_023_auditor_mutu_assessor_akred_internal',
    'dosen.r_024_tim_akred_prodi_dan_direktorat',
    'dosen.r_025_kepanitiaan_kegiatan_institusi',
    'dosen.r_026_pengelola_jurnal_buletin',
    'dosen.r_027_keanggotaan_senat',
    'dosen.r_028_melaksanakan_pengembangan_diri',
    'dosen.r_029_memperoleh_penghargaan',
    'dosen.r_030_pengelola_kepk',
]) }}">
<a href="#" class="parent-sidebar-menu">
    <i class="fa fa-file-text-o"></i> <span>Penunjang Akademik Dosen</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
</a>
<ul class="treeview-menu child-sidebar-menu">
    <li class="{{ set_active(['dosen.r_020_assessor_bkd_lkd']) }}"><a href="{{ route('dosen.r_020_assessor_bkd_lkd') }}"><i class="fa fa-circle-o"></i>Assesor BKD/LKD</a></li>
    <li class="{{ set_active(['dosen.r_021_reviewer_eclere_penelitian_dosen']) }}"><a href="{{ route('dosen.r_021_reviewer_eclere_penelitian_dosen') }}"><i class="fa fa-circle-o"></i>Rev. Ethical Clearance Dosen</a></li>
    <li class="{{ set_active(['dosen.r_022_reviewer_eclere_penelitian_mhs']) }}"><a href="{{ route('dosen.r_022_reviewer_eclere_penelitian_mhs') }}"><i class="fa fa-circle-o"></i>Rev. Ethical Clearance Mhs</a></li>
    <li class="{{ set_active(['dosen.r_023_auditor_mutu_assessor_akred_internal']) }}"><a href="{{ route('dosen.r_023_auditor_mutu_assessor_akred_internal') }}"><i class="fa fa-circle-o"></i>Auditor Mutu/Akred. Internal</a></li>
    <li class="{{ set_active(['dosen.r_024_tim_akred_prodi_dan_direktorat']) }}"><a href="{{ route('dosen.r_024_tim_akred_prodi_dan_direktorat') }}"><i class="fa fa-circle-o"></i>Tim Akred. Prodi & Rektorat</a></li>
    <li class="{{ set_active(['dosen.r_025_kepanitiaan_kegiatan_institusi']) }}"><a href="{{ route('dosen.r_025_kepanitiaan_kegiatan_institusi') }}"><i class="fa fa-circle-o"></i>Panitia Kegiatan Institusi</a></li>
    <li class="{{ set_active(['dosen.r_026_pengelola_jurnal_buletin']) }}"><a href="{{ route('dosen.r_026_pengelola_jurnal_buletin') }}"><i class="fa fa-circle-o"></i>Pengelola Jurnal/Buletin</a></li>
    <li class="{{ set_active(['dosen.r_027_keanggotaan_senat']) }}"><a href="{{ route('dosen.r_027_keanggotaan_senat') }}"><i class="fa fa-circle-o"></i>Keanggotaan Senat</a></li>
    <li class="{{ set_active(['dosen.r_028_melaksanakan_pengembangan_diri']) }}"><a href="{{ route('dosen.r_028_melaksanakan_pengembangan_diri') }}"><i class="fa fa-circle-o"></i>Melaks. Pengembangan Diri</a></li>
    <li class="{{ set_active(['dosen.r_029_memperoleh_penghargaan']) }}"><a href="{{ route('dosen.r_029_memperoleh_penghargaan') }}"><i class="fa fa-circle-o"></i>Memperoleh Penghargaan</a></li>
    <li class="{{ set_active(['dosen.r_030_pengelola_kepk']) }}"><a href="{{ route('dosen.r_030_pengelola_kepk') }}"><i class="fa fa-circle-o"></i>Pengelola KEPK</a></li>

</ul>
</li>

<li style="padding-left:2px;">
@if (isset($_SESSION['data']['namatitle']))
    <a href="{{ route('logoutDosen') }}">
        <i class="fa fa-power-off text-danger"></i>&nbsp; {{ __('Logout') }}
    </a>
@else
    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        <i class="fa fa-power-off text-danger"></i>{{__('Logout') }}
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endif

</li>
