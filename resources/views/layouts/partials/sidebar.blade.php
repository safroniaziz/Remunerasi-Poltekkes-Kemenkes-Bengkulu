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

<li class="treeview {{ set_active(
    ['r_01_perkuliahan_teori','r_02_perkuliahan_praktikum','r_03_membimbing_pencapaian_kompetensi',
    'r_04_membimbing_pendampingan_ukom','r_05_membimbing_praktik_pkk_pbl_klinik',
    'r_06_menguji_ujian_osca','r_07_membimbing_skripsi_lta_la_profesi',
    'r_08_menguji_seminar_proposal_kti_lta_skripsi','r_09_menguji_seminar_hasil_kti_lta_skripsi',
    'r_010_menulis_buku_ajar_berisbn','r_011_mengembangkan_modul_berisbn','r_012_membimbing_pkm']) }}">
    <a href="#">
        <i class="fa fa-graduation-cap"></i> <span>Rubrik Pendidikan</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu " style="padding-left:25px;">
        <li class="{{ set_active('r_01_perkuliahan_teori') }}"><a href="{{ route('r_01_perkuliahan_teori') }}"><i class="fa fa-graduation-cap"></i>Rubrik 01 Perkuliahan Teori</a></li>
        <li class="{{ set_active('r_02_perkuliahan_praktikum') }}"><a href="{{ route('r_02_perkuliahan_praktikum') }}"><i class="fa fa-graduation-cap"></i>Rubrik 02 Perkuliahan Praktikum</a></li>
        <li class="{{ set_active('r_03_membimbing_pencapaian_kompetensi') }}"><a href="{{ route('r_03_membimbing_pencapaian_kompetensi') }}"><i class="fa fa-graduation-cap"></i>Rubrik 03 Membimbing Tutorial Pencapaian Kompetensi</a></li>
        <li class="{{ set_active('r_04_membimbing_pendampingan_ukom') }}"><a href="{{ route('r_04_membimbing_pendampingan_ukom') }}"><i class="fa fa-graduation-cap"></i>Rubrik 04 Membimbing Pendampingan UKOM</a></li>
        <li class="{{ set_active('r_05_membimbing_praktik_pkk_pbl_klinik') }}"><a href="{{ route('r_05_membimbing_praktik_pkk_pbl_klinik') }}"><i class="fa fa-graduation-cap"></i>Rubrik 05 Membimbing Praktik PKK PBL Klinik</a></li>
        <li class="{{ set_active('r_06_menguji_ujian_osca') }}"><a href="{{ route('r_06_menguji_ujian_osca') }}"><i class="fa fa-graduation-cap"></i>Rubrik 06 Menguji Ujian Osca</a></li>
        <li class="{{ set_active('r_07_membimbing_skripsi_lta_la_profesi') }}"><a href="{{ route('r_07_membimbing_skripsi_lta_la_profesi') }}"><i class="fa fa-graduation-cap"></i>Rubrik 07 Membimbing Skripsi LRA LA Profesi</a></li>
        <li class="{{ set_active('r_08_menguji_seminar_proposal_kti_lta_skripsi') }}"><a href="{{ route('r_08_menguji_seminar_proposal_kti_lta_skripsi') }}"><i class="fa fa-graduation-cap"></i>Rubrik 08 Menguji Seminar Proposal KTI LTA Skripsi</a></li>
        <li class="{{ set_active('r_09_menguji_seminar_hasil_kti_lta_skripsi') }}"><a href="{{ route('r_09_menguji_seminar_hasil_kti_lta_skripsi') }}"><i class="fa fa-graduation-cap"></i>Rubrik 09 Menguji Seminar Hasil KTI LTA Skripsi</a></li>
        <li class="{{ set_active('r_010_menulis_buku_ajar_berisbn') }}"><a href="{{ route('r_010_menulis_buku_ajar_berisbn') }}"><i class="fa fa-graduation-cap"></i>Rubrik 10 Menulis Buku Ajar Berisbn</a></li>
        <li class="{{ set_active('r_011_mengembangkan_modul_berisbn') }}"><a href="{{ route('r_011_mengembangkan_modul_berisbn') }}"><i class="fa fa-graduation-cap"></i>Rubrik 11 Mengembangkan Modul Berisbn</a></li>
        <li class="{{ set_active('r_012_membimbing_pkm') }}"><a href="{{ route('r_012_membimbing_pkm') }}"><i class="fa fa-graduation-cap"></i>Rubrik 12 Membimbing PKM</a></li>

    </ul>
</li>

<li class="treeview {{ set_active(
    ['r_013_orasi_ilmiah_narasumber_bidang_ilmu','r_014_karya_inovasi']) }}">
    <a href="#">
        <i class="fa fa-graduation-cap"></i> <span>Rubrik Pendidikan Insidental</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu " style="padding-left:25px;">
        <li class="{{ set_active('r_013_orasi_ilmiah_narasumber_bidang_ilmu') }}"><a href="{{ route('r_013_orasi_ilmiah_narasumber_bidang_ilmu') }}"><i class="fa fa-graduation-cap"></i>Rubrik 13 Orasi Ilmiah Narasumber </a></li>
        <li class="{{ set_active('r_014_karya_inovasi') }}"><a href="{{ route('r_014_karya_inovasi') }}"><i class="fa fa-graduation-cap"></i>Rubrik 14 Karya Inovasi</a></li>
    </ul>
</li>

<li class="treeview {{ set_active(
    ['r_015_menulis_karya_ilmiah_dipublikasikan','r_016_naskah_buku_bahasa_terbit_edar_inter','r_017_naskah_buku_bahasa_terbit_edar_nas']) }}">
    <a href="#">
        <i class="fa fa-graduation-cap"></i> <span>Rubrik Penelitian</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu " style="padding-left:25px;">
        <li class="{{ set_active('r_015_menulis_karya_ilmiah_dipublikasikan') }}"><a href="{{ route('r_015_menulis_karya_ilmiah_dipublikasikan') }}"><i class="fa fa-graduation-cap"></i>Rubrik 15 Menulis Karya Ilmiah Dipublikasikan </a></li>
        <li class="{{ set_active('r_016_naskah_buku_bahasa_terbit_edar_inter') }}"><a href="{{ route('r_016_naskah_buku_bahasa_terbit_edar_inter') }}"><i class="fa fa-graduation-cap"></i>Rubrik 16 Menulis Naskah Buku Bahasa Terbit Edar Internasional</a></li>
        <li class="{{ set_active('r_017_naskah_buku_bahasa_terbit_edar_nas') }}"><a href="{{ route('r_017_naskah_buku_bahasa_terbit_edar_nas') }}"><i class="fa fa-graduation-cap"></i>Rubrik 17 Menulis Naskah Buku Bahasa Terbit Edar Nasional</a></li>
    </ul>
</li>

<li class="treeview {{ set_active(
    ['r_018_mendapat_hibah_pkm','r_019_latih_nyuluh_natar_ceramah_warga']) }}">
    <a href="#">
        <i class="fa fa-graduation-cap"></i> <span>Rubrik Pengabdian</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu " style="padding-left:25px;">
        <li class="{{ set_active('r_018_mendapat_hibah_pkm') }}"><a href="{{ route('r_018_mendapat_hibah_pkm') }}"><i class="fa fa-graduation-cap"></i>Rubrik 18 Mendapat Hibah PKM </a></li>
        <li class="{{ set_active('r_019_latih_nyuluh_natar_ceramah_warga') }}"><a href="{{ route('r_019_latih_nyuluh_natar_ceramah_warga') }}"><i class="fa fa-graduation-cap"></i>Rubrik 19 Memberi Pelatihan Penyuluhan Penataran Ceramah kepada masyarakat</a></li>
    </ul>
</li>

<li class="treeview {{ set_active(
    ['r_020_assessor_bkd_lkd','r_019_latih_nyuluh_natar_ceramah_warga','r_021_reviewer_eclere_penelitian_dosen',
    'r_022_reviewer_eclere_penelitian_mhs']) }}">
    <a href="#">
        <i class="fa fa-graduation-cap"></i> <span>Rubrik Penunjang Kegiatan Akademik Dosen</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu " style="padding-left:25px;">
        <li class="{{ set_active('r_020_assessor_bkd_lkd') }}"><a href="{{ route('r_020_assessor_bkd_lkd') }}"><i class="fa fa-graduation-cap"></i>Rubrik 20 Assessor BKD LKD </a></li>
        <li class="{{ set_active('r_021_reviewer_eclere_penelitian_dosen') }}"><a href="{{ route('r_021_reviewer_eclere_penelitian_dosen') }}"><i class="fa fa-graduation-cap"></i>Rubrik 21 Reviewer Eclereance Penelitian Dosen</a></li>
        <li class="{{ set_active('r_022_reviewer_eclere_penelitian_mhs') }}"><a href="{{ route('r_022_reviewer_eclere_penelitian_mhs') }}"><i class="fa fa-graduation-cap"></i>Rubrik 22 Reviewer Eclereance Penelitian Mahasiswa</a></li>

    </ul>
</li>


