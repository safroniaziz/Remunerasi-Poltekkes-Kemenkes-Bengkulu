@can('dashboard')
    <li class="{{ set_active('dashboard') }}">
        <a href="{{ route('dashboard') }}">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
        </a>
    </li>
@endcan

@can('dashboard-verifikator')
    <li class="{{ set_active('cari_dosen') }}">
        <a href="{{ route('cari_dosen') }}">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
        </a>
    </li>
@endcan

@can('read-jabatan-ds')
<li class="header" style="font-weight:bold;">KOMPONEN REMUNERASI</li>
<li class="{{ set_active(['prodi','prodi.dosens']) }}">
    <a href="{{ route('prodi') }}">
        <i class="fa fa-clipboard "></i>
        <span>Data Program Studi</span>
    </a>
</li>
@endcan

@can('read-jabatan')
    <li class="{{ set_active(['jabatan','jabatan.create','jabatan.edit']) }}">
        <a href="{{ route('jabatan') }}">
            <i class="fa fa-briefcase"></i>
            <span>Manajemen Jabatan</span>
        </a>
    </li>
@endcan

@can('read-jabatan-dt')
<li class="{{ set_active(['jabatan_dt','jabatan_dt.create','jabatan_dt.edit']) }}">
    <a href="{{ route('jabatan_dt') }}">
        <i class="fa fa-briefcase"></i>
        <span>Data Jabatan Tambahan (DT)</span>
    </a>
</li>
@endcan

@can('read-jabatan-ds')
<li class="{{ set_active(['jabatan_ds','jabatan_ds.create','jabatan_ds.edit']) }}">
    <a href="{{ route('jabatan_ds') }}">
        <i class="fa fa-chart-line"></i>
        <span>Data Jabatan Fungsional</span>
    </a>
</li>
@endcan

@can('read-pegawai')
    <li class="{{ set_active([
            'dosen',
            'dosen.create',
            'dosen.edit',
            'dosen.riwayat_jabatan_fungsional',
            'dosen.riwayat_pangkat_golongan',
            'dosen.riwayat_jabatan_dt',
        ]) }}">
        <a href="{{ route('dosen') }}">
            <i class="fa fa-graduation-cap"></i>
            <span>Manajemen Data Dosen</span>
        </a>
    </li>
@endcan

@can('read-kelompok-rubrik')
    <li class="{{ set_active('kelompok_rubrik') }}">
        <a href="{{ route('kelompok_rubrik') }}">
            <i class="fa fa-folder"></i>
            <span>Data Kelompok Rubrik</span>
        </a>
    </li>
@endcan

@can('read-nilai-ewmp')
    <li class="{{ set_active(['nilai_ewmp','nilai_ewmp.create','nilai_ewmp.edit']) }}">
        <a href="{{ route('nilai_ewmp') }}">
            <i class="fa fa-calculator"></i>
            <span>Data Nilai Ewmp</span>
        </a>
    </li>
@endcan

@can('read-presensi')
    <li class="{{ set_active('presensi') }}">
        <a href="{{ route('presensi') }}">
            <i class="fa fa-user-check"></i>
            <span>Data presensi</span>
        </a>
    </li>
@endcan

@can('view-generate-point-rubrik')
    <li class="header" style="font-weight:bold">LAPORAN REMUNERASI</li>
    <li class="{{ set_active(['generate_point_rubrik','detail_isian_rubrik']) }}">
        <a href="{{ route('generate_point_rubrik') }}">
            <i class="fa fa-sync"></i>
            <span>Generate Point Rubrik</span>
        </a>
    </li>
@endcan

@can('view-point-rubrik-dosen')
    <li class="{{ set_active(['point_rubrik_dosen','point_rubrik_dosen.detail','point_rubrik_dosen.detail_rubrik']) }}">
        <a href="{{ route('point_rubrik_dosen') }}">
            <i class="fa fa-exchange-alt"></i>
            <span>Point Rubrik Dosen</span>
        </a>
    </li>
@endcan

@can('view-laporan-keuangan')
    <li class="{{ set_active(['laporan_keuangan']) }}">
        <a href="{{ route('laporan_keuangan') }}">
            <i class="fa fa-chart-bar"></i>
            <span>Laporan Daftar Nominatif</span>
        </a>
    </li>
@endcan

@can('read-periode')
    <li class="header" style="font-weight:bold">MANAJEMEN PENGATURAN</li>
    <li class="{{ set_active('periode_penilaian') }}">
        <a href="{{ route('periode_penilaian') }}">
            <i class="fa fa-calendar"></i>
            <span>Periode Remunerasi</span>
        </a>
    </li>
@endcan


@can('read-pengumumen')
    <li class="{{ set_active('pengumuman') }}">
        <a href="{{ route('pengumuman') }}">
            <i class="fa fa-bell"></i>
            <span>Manajemen Pengumuman</span>
        </a>
    </li>
@endcan

@can('read-user')
    <li class="treeview {{ set_active([
        'manajemen_permission',
        'manajemen_role',
        'manajemen_role.detail',
        'manajemen_data_verifikator',
        'manajemen_data_administrator',
    ]) }}">
        <a href="#" class="parent-sidebar-menu">
            <i class="fa fa-users"></i> <span>Manajemen Pengguna</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu child-sidebar-menu">
            <li class="{{ set_active(['manajemen_permission']) }}"><a href="{{ route('manajemen_permission') }}"><i class="fa fa-circle-o"></i>Permission</a></li>
            <li class="{{ set_active(['manajemen_role','manajemen_role.detail']) }}"><a href="{{ route('manajemen_role') }}"><i class="fa fa-circle-o"></i>Role</a></li>
            <li class="{{ set_active(['manajemen_data_verifikator']) }}"><a href="{{ route('manajemen_data_verifikator') }}"><i class="fa fa-circle-o"></i>Verifikator</a></li>
            <li class="{{ set_active(['manajemen_data_administrator']) }}"><a href="{{ route('manajemen_data_administrator') }}"><i class="fa fa-circle-o"></i>Administrator</a></li>
        </ul>
    </li>
@endcan

<li class="header" style="font-weight:bold">RUBRIK PENDIDIKAN REGULER</li>
<li class="treeview {{ set_active([
    'r_01_perkuliahan_teori',
    'r_02_perkuliahan_praktikum',
    'r_03_membimbing_pencapaian_kompetensi',
    'r_04_membimbing_pendampingan_ukom',
    'r_05_membimbing_praktik_pkk_pbl_klinik',
    'r_06_menguji_ujian_osca',
    'r_07_membimbing_skripsi_lta_la_profesi',
    'r_08_menguji_seminar_proposal_kti_lta_skripsi',
    'r_09_menguji_seminar_hasil_kti_lta_skripsi',
    'r_010_menulis_buku_ajar_berisbn',
    'r_011_mengembangkan_modul_berisbn',
    'r_012_membimbing_pkm',
]) }}">
<a href="#" class="parent-sidebar-menu">
    <i class="fa fa-chalkboard-teacher"></i> <span>Pendidikan Reguler</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
</a>
@can('read-r01-perkuliahan-teori')
<ul class="treeview-menu child-sidebar-menu">
    <li class="{{ set_active(['r_01_perkuliahan_teori']) }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_01_perkuliahan_teori') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-book"></i>
            <span>Perkuliahan Teori</span>
        </a>
    </li>
@endcan

@can('read-r02-perkuliahan-praktikum')
    <li class="{{ set_active('r_02_perkuliahan_praktikum') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_02_perkuliahan_praktikum') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-book-open-reader"></i>
            <span>Perkuliahan Praktikum</span>
        </a>
    </li>
@endcan

@can('read-r03-membimbing-capaian-kompetensi')
    <li class="{{ set_active('r_03_membimbing_pencapaian_kompetensi') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_03_membimbing_pencapaian_kompetensi') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-magnifying-glass-chart"></i>
            <span>Memb. Capaian Kompetensi</span>
        </a>
    </li>
@endcan

@can('read-r04-membimbing-pendampingan-ukom')
    <li class="{{ set_active('r_04_membimbing_pendampingan_ukom') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_04_membimbing_pendampingan_ukom') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-square-poll-vertical"></i>
            <span>Memb. Pendamping UKOM</span>
        </a>
    </li>
@endcan

@can('read-r05-membimbing-praktik-pkk-pbl-klinik')
    <li class="{{ set_active('r_05_membimbing_praktik_pkk_pbl_klinik') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_05_membimbing_praktik_pkk_pbl_klinik') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-house-medical"></i>
            <span>Memb. Praktik PKK/PBL Klinik</span>
        </a>
    </li>
@endcan

@can('read-r06-menguji-ujian-osca')
    <li class="{{ set_active('r_06_menguji_ujian_osca') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_06_menguji_ujian_osca') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-briefcase-medical"></i>
            <span>Menguji Ujian OSCA</span>
        </a>
    </li>
@endcan

@can('read-r07-membimbing-skripsi-lta-la-profesi')
    <li class="{{ set_active('r_07_membimbing_skripsi_lta_la_profesi') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_07_membimbing_skripsi_lta_la_profesi') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-solid fa-address-book"></i>
            <span>Memb. Skripsi/LTA/LA Profesi</span>
        </a>
    </li>
@endcan

@can('read-r08-menguji-seminar-proposal-kti-lta-skripsi')
    <li class="{{ set_active('r_08_menguji_seminar_proposal_kti_lta_skripsi') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_08_menguji_seminar_proposal_kti_lta_skripsi') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-book-open-reader"></i>
            <span>Meng. Sempro. LTA/LA/Skripsi</span>
        </a>
    </li>
@endcan

@can('read-r09-menguji-seminar-hasil-kti-lta-skripsi')
    <li class="{{ set_active('r_09_menguji_seminar_hasil_kti_lta_skripsi') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_09_menguji_seminar_hasil_kti_lta_skripsi') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-laptop-code"></i>
            <span>Meng. Semhas. LTA/LA/Skripsi</span>
        </a>
    </li>
@endcan

@can('read-r010-menulis-buku-ajar-berisbn')
    <li class="{{ set_active('r_010_menulis_buku_ajar_berisbn') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_010_menulis_buku_ajar_berisbn') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-book-bookmark"></i>
            <span>Menulis Buku Ajar Ber-ISBN</span>
        </a>
    </li>
@endcan

@can('read-r011-mengembangkan-modul-berisbn')
    <li class="{{ set_active('r_011_mengembangkan_modul_berisbn') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_011_mengembangkan_modul_berisbn') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-book"></i>
            <span>Mengemb. Modul Ber-ISBN</span>
        </a>
    </li>
@endcan

@can('read-r012-membimbing-pkm')
<li class="{{ set_active('r_012_membimbing_pkm') }}">
    @if(session()->has('nama_dosen'))
        <a href="{{ route('r_012_membimbing_pkm') }}">
    @else
        <a class="bg-danger" style="cursor:not-allowed">
    @endif
        <i class="fa fa-print"></i>
        <span>Membimbing PKM</span>
    </a>
</li>
@endcan

</ul>
</li>

<li class="treeview {{ set_active([
    'r_013_orasi_ilmiah_narasumber_bidang_ilmu',
    'r_014_karya_inovasi',
]) }}">
<a href="#" class="parent-sidebar-menu">
    <i class="fa fa-book-open"></i> <span>Pendidikan Insidental</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
</a>
<ul class="treeview-menu child-sidebar-menu">

@can('read-r013-orasi-ilmiah-narasumber-bidang-ilmu')
    <li class="{{ set_active('r_013_orasi_ilmiah_narasumber_bidang_ilmu') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_013_orasi_ilmiah_narasumber_bidang_ilmu') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-message"></i>
            <span>Orasi Ilmiah Narasumber</span>
        </a>
    </li>
@endcan

@can('read-r014-karya-inovasi')
    <li class="{{ set_active('r_014_karya_inovasi') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_014_karya_inovasi') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-envelope"></i>
            <span>Karya Inovasi</span>
        </a>
    </li>
@endcan

</ul>
</li>

<li class="treeview {{ set_active([
    'r_015_menulis_karya_ilmiah_dipublikasikan',
    'r_016_naskah_buku_bahasa_terbit_edar_inter',
    'r_017_naskah_buku_bahasa_terbit_edar_nas',
]) }}">
<a href="#" class="parent-sidebar-menu">
    <i class="fa fa-chart-line"></i> <span>Pelaksanaan Penelitian</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
</a>
<ul class="treeview-menu child-sidebar-menu">
@can('read-r015-menulis-karya-ilmiah-dipublikasikan')
    <li class="{{ set_active('r_015_menulis_karya_ilmiah_dipublikasikan') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_015_menulis_karya_ilmiah_dipublikasikan') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-solid fa-file-word"></i>
            <span>Karya Ilmiah Dipublikasikan</span>
        </a>
    </li>
@endcan

@can('read-r016-naskah-buku-bahasa-terbit-edar-inter')
    <li class="{{ set_active('r_016_naskah_buku_bahasa_terbit_edar_inter') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_016_naskah_buku_bahasa_terbit_edar_inter') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-folder-open"></i>
            <span>Naskah Buku Internasional</span>
        </a>
    </li>
@endcan

@can('read-r017-naskah-buku-bahasa-terbit-edar-nas')
    <li class="{{ set_active('r_017_naskah_buku_bahasa_terbit_edar_nas') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_017_naskah_buku_bahasa_terbit_edar_nas') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-file-pdf"></i>
            <span>Naskah Buku Nasional</span>
        </a>
    </li>
@endcan
</ul>
</li>

<li class="treeview {{ set_active([
    'r_018_mendapat_hibah_pkm',
    'r_019_latih_nyuluh_natar_ceramah_warga',
]) }}">
<a href="#" class="parent-sidebar-menu">
    <i class="fa fa-comments"></i> <span>Pelaksanaan Pengabdian</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
</a>
<ul class="treeview-menu child-sidebar-menu">
@can('read-r018-mendapat-hibah-pkm')
    <li class="{{ set_active('r_018_mendapat_hibah_pkm') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_018_mendapat_hibah_pkm') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-book-atlas"></i>
            <span>Mendapatkan Hibah PKM</span>
        </a>
    </li>
@endcan

@can('read-r019-latih-nyuluh-natar-ceramah-warga')
    <li class="{{ set_active('r_019_latih_nyuluh_natar_ceramah_warga') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_019_latih_nyuluh_natar_ceramah_warga') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-magnifying-glass"></i>
            <span>Latihan Pada Masyarakat</span>
        </a>
    </li>
@endcan
</ul>
</li>

<li class="treeview {{ set_active([
    'r_020_assessor_bkd_lkd',
    'r_021_reviewer_eclere_penelitian_dosen',
    'r_022_reviewer_eclere_penelitian_mhs',
    'r_023_auditor_mutu_assessor_akred_internal',
    'r_024_tim_akred_prodi_dan_direktorat',
    'r_025_kepanitiaan_kegiatan_institusi',
    'r_026_pengelola_jurnal_buletin',
    'r_027_keanggotaan_senat',
    'r_028_melaksanakan_pengembangan_diri',
    'r_029_memperoleh_penghargaan',
    'r_030_pengelola_kepk',
]) }}">
<a href="#" class="parent-sidebar-menu">
    <i class="fa fa-graduation-cap"></i> <span>Penunjang Akademik Dosen</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
</a>
<ul class="treeview-menu child-sidebar-menu">
@can('read-r020-assessor-bkd-lkd')
    <li class="{{ set_active('r_020_assessor_bkd_lkd') }} ">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_020_assessor_bkd_lkd') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
        <i class="fa fa-user-group"></i>
        <span>Assesor BKD/LKD</span>
        </a>
    </li>
@endcan

@can('read-r021-reviewer-eclere-penelitian-dosen')
    <li class="{{ set_active('r_021_reviewer_eclere_penelitian_dosen') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_021_reviewer_eclere_penelitian_dosen') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-building-user"></i>
            <span>Rev. Ethical Clearance Dosen</span>
        </a>
    </li>
@endcan

@can('read-r022-reviewer-eclere-penelitian-mhs')
    <li class="{{ set_active('r_022_reviewer_eclere_penelitian_mhs') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_022_reviewer_eclere_penelitian_mhs') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-user-graduate"></i>
            <span>Rev. Ethical Clearance Mhs</span>
        </a>
    </li>
@endcan

@can('read-r023-auditor-mutu-assessor-akred-internal')
    <li class="{{ set_active('r_023_auditor_mutu_assessor_akred_internal') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_023_auditor_mutu_assessor_akred_internal') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-user-tie"></i>
            <span>Auditor Mutu/Akred. Internal</span>
        </a>
    </li>
@endcan

@can('read-r024-tim-akred-prodi-dan-direktorat')
    <li class="{{ set_active('r_024_tim_akred_prodi_dan_direktorat') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_024_tim_akred_prodi_dan_direktorat') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-house-signal"></i>
            <span>Tim Akred. Prodi & Rektorat</span>
        </a>
    </li>
@endcan

@can('read-r025-kepanitiaan-kegiatan-institusi')
    <li class="{{ set_active('r_025_kepanitiaan_kegiatan_institusi') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_025_kepanitiaan_kegiatan_institusi') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-building-columns"></i>
            <span>Panitia Kegiatan Institusi</span>
        </a>
    </li>
@endcan

@can('read-r026-pengelola-jurnal-buletin')
    <li class="{{ set_active('r_026_pengelola_jurnal_buletin') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_026_pengelola_jurnal_buletin') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-file-powerpoint"></i>
            <span>Pengelola Jurnal/Buletin</span>
        </a>
    </li>
@endcan

@can('read-r027-keanggotaan-senat')
    <li class="{{ set_active('r_027_keanggotaan_senat') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_027_keanggotaan_senat') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-users"></i>
            <span>Keanggotaan Senat</span>
        </a>
    </li>
@endcan

@can('read-r028-melaksanakan-pengembangan-diri')
    <li class="{{ set_active('r_028_melaksanakan_pengembangan_diri') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_028_melaksanakan_pengembangan_diri') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-graduation-cap"></i>
            <span>Melaks. Pengembangan Diri</span>
        </a>
    </li>
@endcan

@can('read-r029-memperoleh-penghargaan')
    <li class="{{ set_active('r_029_memperoleh_penghargaan') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_029_memperoleh_penghargaan') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-medal"></i>
            <span>Memperoleh Penghargaan</span>
        </a>
    </li>
@endcan

@can('read-r030-pengelola-kepk')
    <li class="{{ set_active('r_030_pengelola_kepk') }}">
        @if(session()->has('nama_dosen'))
            <a href="{{ route('r_030_pengelola_kepk') }}">
        @else
            <a class="bg-danger" style="cursor:not-allowed">
        @endif
            <i class="fa fa-shield-halved"></i>
            <span>Pengelola KEPK</span>
        </a>
    </li>
@endcan

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
