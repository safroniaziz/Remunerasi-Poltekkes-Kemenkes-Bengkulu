# PRD Rebuild Aplikasi EWMP Remunerasi Dosen

Tanggal: 2026-06-17
Status: Draft awal
Target arsitektur: Laravel monolith modular

## 1. Ringkasan

Aplikasi saat ini digunakan untuk mengelola data dosen, periode penilaian, rubrik EWMP/remunerasi R01 sampai R30, verifikasi isian, rekap point, laporan nominatif/keuangan, pengumuman, presensi, serta sinkronisasi data tertentu dari SIAKAD.

Rebuild dilakukan untuk menghasilkan aplikasi monolith yang lebih rapi, mudah dirawat, performanya terukur, dan aman untuk dikembangkan jangka panjang. Fokus utama bukan mengganti sistem menjadi microservices, tetapi merapikan batas domain di dalam satu codebase dengan struktur modul yang jelas.

## 2. Latar Belakang Masalah

Masalah yang terlihat dari codebase lama:

- Logic auth admin/verifikator dan auth dosen belum menyatu dalam mekanisme Laravel yang konsisten.
- Session dosen masih memakai `session_start()` dan `$_SESSION`, sehingga rawan bocor state, sulit dites, dan tidak konsisten dengan middleware/policy Laravel.
- Integrasi SIAKAD tersebar di controller dan helper procedural, sehingga sulit mock, sulit retry, dan sulit ditelusuri saat error.
- Controller terlalu gemuk: validasi, query, hitung point, activity log, response, dan integrasi eksternal bercampur.
- Route dan controller rubrik R01-R30 banyak duplikasi.
- Model memiliki accessor yang memicu query tambahan dan berpotensi menyebabkan N+1 query.
- Query untuk dashboard, list, dan laporan belum punya batas performa yang eksplisit.
- Nama entity dan ownership data belum tegas antara `User`, `Pegawai`, `Dosen`, `Verifikator`, dan `Administrator`.
- Validasi tersebar di controller, belum menggunakan Form Request secara konsisten.
- Perhitungan point belum dipusatkan sebagai domain rule yang dapat dites.
- Belum ada kontrak integrasi SIAKAD yang eksplisit, termasuk mapping, error handling, idempotency, dan audit.

## 3. Tujuan Produk

Tujuan rebuild:

- Menyediakan sistem EWMP/remunerasi dosen yang stabil untuk input, verifikasi, rekap, dan pelaporan point rubrik.
- Memastikan data dosen dan data akademik dari SIAKAD tersinkron dengan jelas, dapat diaudit, dan tidak merusak data manual.
- Menyederhanakan pengalaman pengguna untuk dosen, verifikator, administrator, dan pimpinan.
- Menghilangkan pola query boros dan N+1 pada halaman utama, list, dashboard, dan laporan.
- Membuat domain rule, terutama perhitungan point, dapat diuji otomatis.
- Mempertahankan deploy sederhana sebagai monolith.

## 4. Non-Goals

Yang tidak menjadi target awal:

- Tidak membangun microservices.
- Tidak membangun mobile app native.
- Tidak mengganti database menjadi event store.
- Tidak membuat workflow approval yang terlalu kompleks sebelum kebutuhan operasionalnya jelas.
- Tidak menyalin struktur database lama apa adanya jika struktur tersebut menjadi sumber duplikasi.
- Tidak mengandalkan SIAKAD secara real-time untuk semua halaman; data penting harus disimpan lokal dengan mekanisme sinkronisasi.

## 5. Persona Pengguna

### Dosen

Pengguna yang mengisi aktivitas rubrik, melihat status verifikasi, memperbaiki isian yang ditolak, melihat rekap point pribadi, dan mengambil sebagian data dari SIAKAD bila tersedia.

Kebutuhan utama:

- Login mudah dan aman.
- Mengisi rubrik dengan form yang jelas.
- Mengimpor data perkuliahan/praktikum dari SIAKAD.
- Melihat status draft, submit, verified, rejected.
- Melihat alasan penolakan.
- Melihat total point dan detail per rubrik/periode.

### Verifikator

Pengguna yang memeriksa isian dosen sesuai prodi/jurusan/kewenangan, lalu memverifikasi atau menolak.

Kebutuhan utama:

- Melihat daftar isian yang perlu diverifikasi.
- Filter berdasarkan periode, prodi, rubrik, dosen, status, dan sumber data.
- Melihat detail bukti/isian.
- Approve/reject dengan catatan.
- Melihat histori perubahan.

### Administrator

Pengguna yang mengelola master data, role/permission, periode, parameter rubrik, nilai EWMP, data dosen, sinkronisasi SIAKAD, dan laporan.

Kebutuhan utama:

- Manajemen user dan akses.
- Manajemen master rubrik dan parameter point.
- Sinkronisasi data dosen/prodi dari SIAKAD.
- Memantau job sinkronisasi dan error integrasi.
- Generate rekap dan export laporan.

### Pimpinan/Keuangan

Pengguna yang melihat rekap final untuk kebutuhan monitoring dan pembayaran/remunerasi.

Kebutuhan utama:

- Dashboard ringkas per periode.
- Rekap nominatif dan keuangan.
- Export Excel/PDF.
- Data final yang sudah terkunci.

## 6. Scope MVP

### In Scope MVP

- Login dan role-based access untuk dosen, verifikator, administrator, dan pimpinan/keuangan.
- Master data dosen, prodi, jabatan fungsional, jabatan DT/DS, pangkat/golongan, periode, kelompok rubrik, dan nilai EWMP.
- Konfigurasi rubrik R01-R30.
- Input rubrik dosen untuk R01-R30.
- Import data SIAKAD minimal untuk data dosen, prodi, R01 perkuliahan teori, dan R02 perkuliahan praktikum.
- Workflow submit, verify, reject, dan revisi.
- Rekap point per dosen, per rubrik, per prodi, dan per periode.
- Laporan nominatif/keuangan dengan export Excel.
- Activity log untuk perubahan penting.
- Audit log integrasi SIAKAD.
- Test otomatis untuk auth, RBAC, rubrik utama, perhitungan point, verifikasi, dan sinkronisasi.

### Out of Scope MVP

- Tanda tangan digital.
- Notifikasi WhatsApp/email otomatis.
- Multi kampus/multi tenant jika belum dibutuhkan secara eksplisit.
- API publik untuk pihak ketiga selain kontrak internal yang dibutuhkan frontend.
- Real-time notification.

## 7. Prinsip Arsitektur

Aplikasi tetap monolith, tetapi dibuat modular berdasarkan domain.

Struktur yang disarankan:

```text
app/
  Domain/
    Auth/
    Users/
    Employees/
    Academic/
    Rubrics/
    Verification/
    Recaps/
    Reports/
    Siakad/
    Announcements/
  Http/
    Controllers/
    Requests/
    Resources/
  Models/
  Policies/
  Jobs/
  Actions/
  Services/
```

Aturan batas teknis:

- Controller hanya menerima request, memanggil action/service, dan mengembalikan response.
- Validasi wajib berada di Form Request.
- Authorization wajib memakai Policy/Gate, bukan kondisi role langsung di Blade/controller.
- Query list dan dashboard memakai Query Object atau repository ringan bila query kompleks.
- Perhitungan point berada di service/calculator per rubrik dan wajib punya unit test.
- Integrasi SIAKAD hanya melalui `SiakadClient` dan service sinkronisasi, bukan langsung dari controller.
- Semua halaman list wajib memakai pagination.
- Semua relasi yang tampil di table wajib eager loaded.
- Accessor model tidak boleh menjalankan query berat atau query tersembunyi.
- Export laporan wajib memakai query yang terukur dan tidak membaca semua data tanpa batas.

## 8. Model Domain Utama

### User dan Pegawai

Rekomendasi:

- `users` menjadi satu-satunya model autentikasi.
- `employees` atau `pegawais` menyimpan profil dosen/pegawai.
- Relasi `users.employee_id` atau `users.pegawai_nip` menghubungkan akun ke pegawai.
- Dosen tetap login melalui guard Laravel yang sama, bukan session PHP manual.
- Role menentukan akses: `administrator`, `verifikator`, `dosen`, `pimpinan`, `keuangan`.

Field inti user:

- `id`
- `employee_id` atau `pegawai_nip`
- `name`
- `email`
- `username` atau `nip`
- `password`
- `status`
- `last_login_at`
- `email_verified_at`

Field inti pegawai/dosen:

- `id`
- `nip`
- `nidn`
- `nama`
- `email`
- `jenis_kelamin`
- `prodi_homebase_id`
- `jurusan`
- `nomor_rekening`
- `npwp`
- `no_whatsapp`
- `is_serdos`
- `no_sertifikat_serdos`
- `status`
- `siakad_id`
- `siakad_synced_at`

### Periode

Periode harus menjadi batas semua transaksi rubrik dan rekap.

Field inti:

- `id`
- `tahun_ajaran`
- `semester`
- `nama`
- `starts_at`
- `ends_at`
- `status`: draft, active, locked, archived
- `locked_at`

Aturan:

- Hanya satu periode berstatus active.
- Periode locked tidak boleh menerima perubahan rubrik kecuali administrator membuka lock dengan audit log.
- Semua rekap final mengacu ke periode locked.

### Rubrik

Rubrik sebaiknya tidak selalu menjadi 30 tabel terpisah jika pola datanya bisa disatukan. Ada dua opsi:

Opsi A, disarankan untuk rebuild:

- `rubrics`: definisi R01-R30.
- `rubric_fields`: definisi field dinamis per rubrik.
- `rubric_entries`: isian rubrik dosen.
- `rubric_entry_values`: nilai field dinamis.
- `rubric_scores`: hasil perhitungan point.

Kelebihan:

- Mengurangi 30 controller/model/table yang mirip.
- Workflow submit/verify/reject lebih seragam.
- Report dan rekap lebih mudah digabung.

Risiko:

- Butuh desain field dan validasi dinamis yang matang.
- Query detail perlu indeks yang baik.

Opsi B, lebih konservatif:

- Tetap ada tabel per rubrik untuk data yang sangat berbeda.
- Buat interface/contract `RubricEntryContract`.
- Gunakan shared service untuk workflow, verification, activity log, dan scoring.
- Definisi rubrik tetap berada di `rubrics`.

Keputusan PRD:

- Gunakan Opsi A untuk rubrik yang field-nya sederhana dan dapat dimodelkan dinamis.
- Gunakan Opsi B hanya untuk rubrik yang benar-benar butuh struktur khusus.
- Hindari membuat controller R01-R30 yang seluruhnya copy-paste.

Field inti `rubrics`:

- `id`
- `code`: R01, R02, ..., R30
- `name`
- `group`: pendidikan, pendidikan_insidental, penelitian, pengabdian, penunjang
- `default_ewmp`
- `is_active`
- `requires_siakad`
- `sort_order`

Field inti `rubric_entries`:

- `id`
- `period_id`
- `rubric_id`
- `employee_id`
- `source`: manual, siakad, import
- `status`: draft, submitted, verified, rejected, cancelled
- `submitted_at`
- `verified_at`
- `verified_by`
- `rejected_at`
- `rejected_by`
- `rejection_note`
- `point`
- `created_by`
- `updated_by`

### Rekap

Rekap adalah hasil turunan, bukan sumber kebenaran utama.

Jenis rekap:

- Rekap per dosen per periode.
- Rekap per rubrik per periode.
- Rekap per prodi/jurusan per periode.
- Rekap nominatif untuk pembayaran.

Aturan:

- Rekap dapat dihitung ulang dari `rubric_entries`.
- Rekap final disimpan sebagai snapshot saat periode dikunci.
- Snapshot final tidak berubah tanpa proses unlock dan audit.

## 9. Functional Requirements

### 9.1 Auth dan Akses

Requirement:

- Sistem menyediakan satu halaman login untuk semua role.
- User dapat login dengan email, username, atau NIP sesuai konfigurasi.
- Login harus memakai rate limit per identifier dan IP.
- User nonaktif tidak boleh login.
- Password disimpan dengan hashing standar Laravel.
- Logout harus menghapus session Laravel secara benar.
- Role dan permission dikelola melalui UI administrator.
- Middleware membatasi area berdasarkan permission, bukan hard-coded role.

Acceptance criteria:

- Dosen, verifikator, administrator, dan pimpinan dapat login dari form yang sama.
- Dosen tidak menggunakan `$_SESSION`.
- User nonaktif menerima pesan error yang jelas.
- Percobaan login gagal berulang terkena rate limit.
- Semua route protected memiliki middleware auth.

### 9.2 Dashboard

Dashboard dosen:

- Menampilkan periode aktif.
- Menampilkan total point sementara.
- Menampilkan status isian per rubrik.
- Menampilkan daftar isian rejected yang perlu diperbaiki.
- Menampilkan progress jumlah rubrik yang sudah diisi.

Dashboard verifikator:

- Menampilkan total isian pending verification.
- Menampilkan pending per prodi/rubrik/periode.
- Menampilkan daftar terbaru yang perlu diverifikasi.

Dashboard administrator:

- Menampilkan status sinkronisasi SIAKAD.
- Menampilkan ringkasan dosen aktif, periode aktif, rubrik aktif, dan rekap.
- Menampilkan job gagal dan error integrasi.

Kebutuhan performa:

- Dashboard tidak boleh melakukan query per dosen/per rubrik di loop.
- Semua angka agregat memakai query agregasi atau materialized snapshot.

### 9.3 Master Data

Master data yang harus dikelola:

- Dosen/Pegawai.
- Program Studi.
- Jurusan/Fakultas bila berlaku.
- Jabatan fungsional.
- Jabatan DT/DS.
- Pangkat/golongan.
- Periode.
- Kelompok rubrik.
- Rubrik R01-R30.
- Nilai EWMP/parameter point.
- Pengumuman.
- Dokumen.
- Presensi bila masih diperlukan.

Requirement:

- Setiap master data memiliki list, search, create, edit, activate/deactivate, dan audit log.
- Delete default memakai soft delete untuk data referensial.
- Data yang sudah dipakai transaksi tidak boleh hard delete.
- Import/sync dari SIAKAD memakai preview atau summary sebelum overwrite data lokal.

### 9.4 Input Rubrik Dosen

Requirement:

- Dosen dapat melihat rubrik yang aktif pada periode aktif.
- Dosen dapat membuat draft isian.
- Dosen dapat submit isian untuk diverifikasi.
- Dosen dapat mengedit isian selama status draft atau rejected.
- Dosen tidak dapat mengubah isian verified kecuali dibuka oleh verifikator/admin.
- Sistem menghitung point otomatis berdasarkan parameter rubrik.
- Sistem menyimpan sumber data: manual, siakad, import.
- Sistem menyimpan histori perubahan penting.

Acceptance criteria:

- Perhitungan point setiap rubrik dapat diuji dengan unit test.
- Perubahan field yang memengaruhi point memicu kalkulasi ulang.
- Semua isian terikat ke dosen dan periode.
- Dosen tidak bisa mengakses atau mengubah isian dosen lain.

### 9.5 Verifikasi Rubrik

Requirement:

- Verifikator melihat isian sesuai kewenangannya.
- Verifikator dapat approve atau reject.
- Reject wajib berisi catatan.
- Approve menyimpan `verified_by` dan `verified_at`.
- Reject menyimpan `rejected_by`, `rejected_at`, dan `rejection_note`.
- Status perubahan terekam di audit log.

Acceptance criteria:

- Verifikator tidak dapat memverifikasi rubrik di luar scope prodi/jurusan yang ditugaskan.
- Isian yang sudah verified masuk ke rekap.
- Isian rejected tidak masuk ke rekap final.

### 9.6 Perhitungan Point

Requirement:

- Setiap rubrik memiliki calculator yang eksplisit.
- Formula point tidak tersebar di controller.
- Parameter formula dapat dikonfigurasi melalui master data bila memang berubah per periode.
- Hasil point disimpan di entry untuk kebutuhan report cepat.
- Sistem menyimpan metadata kalkulasi untuk audit minimal: formula version, input penting, dan parameter EWMP.

Contoh struktur service:

```text
RubricScoringService
  calculate(RubricEntry $entry): ScoreResult

R01LectureTheoryCalculator
R02PracticumCalculator
DefaultFixedPointCalculator
```

Acceptance criteria:

- Unit test mencakup minimal R01, R02, satu rubrik fixed point, dan satu rubrik insidental.
- Perubahan formula punya migration/config versioning.

### 9.7 Rekap dan Laporan

Requirement:

- Rekap dapat ditampilkan per dosen, per rubrik, per prodi, dan per periode.
- Laporan keuangan/nominatif dapat diexport Excel.
- Export besar dijalankan melalui queue job.
- Pimpinan/keuangan hanya melihat data yang sudah sesuai permission.
- Rekap final dibuat saat periode locked.

Acceptance criteria:

- Rekap detail dan total harus konsisten.
- Export tidak timeout untuk data besar.
- Query laporan punya indeks dan batas memory yang jelas.

### 9.8 Integrasi SIAKAD

Requirement:

- Semua call ke SIAKAD melalui satu client: `SiakadClient`.
- Credential SIAKAD disimpan di environment/config, bukan hard-coded.
- Request/response SIAKAD dicatat minimal metadata-nya: action, status, duration, correlation id, error.
- Response mentah yang sensitif tidak disimpan sembarangan.
- Sinkronisasi dijalankan via job queue untuk proses besar.
- Sinkronisasi harus idempotent: menjalankan ulang job tidak membuat duplikasi.
- Sistem membedakan data dari SIAKAD dan data manual.
- Error SIAKAD harus terlihat di UI admin.

Endpoint/aksi minimal:

- Ambil data dosen.
- Ambil data prodi.
- Ambil data perkuliahan teori R01.
- Ambil data praktikum R02.
- OAuth/login dosen bila tetap menggunakan SIAKAD sebagai identity provider.

Acceptance criteria:

- Controller tidak melakukan `require_once` helper SIAKAD.
- Controller tidak memanggil curl langsung.
- Sinkronisasi dosen menampilkan jumlah created, updated, skipped, failed.
- Jika SIAKAD down, aplikasi internal tetap dapat digunakan untuk data lokal.

### 9.9 Pengumuman dan Dokumen

Requirement:

- Administrator dapat membuat pengumuman.
- Pengumuman dapat memiliki lampiran.
- Pengumuman dapat dipublikasi/unpublish.
- User publik dapat membaca pengumuman yang published.
- File disimpan di storage Laravel dengan validasi tipe dan ukuran.

### 9.10 Audit Log

Requirement:

- Sistem mencatat perubahan penting:
  - Login/logout penting dan gagal login berulang.
  - Create/update/delete master data.
  - Submit/approve/reject rubrik.
  - Generate rekap.
  - Lock/unlock periode.
  - Sinkronisasi SIAKAD.
- Audit log harus menyimpan actor, event, entity, old value, new value, IP, user agent, dan waktu.

## 10. Non-Functional Requirements

### Performance

Target awal:

- Halaman list standar: maksimal 20 query SQL per request.
- Dashboard dosen: maksimal 15 query SQL.
- Dashboard admin/verifikator: maksimal 25 query SQL.
- Halaman detail dosen dengan relasi: maksimal 30 query SQL.
- Response time halaman umum: p95 di bawah 800 ms pada data produksi normal.
- Export besar boleh async, tetapi UI harus memberi status progress.

Aturan:

- Wajib memakai pagination untuk list.
- Wajib eager load relasi yang ditampilkan.
- Hindari accessor yang menjalankan query di setiap row.
- Hindari query di Blade.
- Tambahkan indeks untuk foreign key, status, periode, rubrik, nip/employee_id, dan kolom filter utama.

### Security

Requirement:

- Semua form mutasi memakai CSRF protection.
- Authorization memakai Policy/Gate.
- Password tidak pernah ditampilkan balik ke UI.
- File upload divalidasi.
- IDOR dicegah dengan policy dan scoped query.
- Semua credential eksternal ada di `.env`.
- Error production tidak membocorkan stack trace.
- Session memakai konfigurasi secure sesuai environment.

### Reliability

Requirement:

- Job queue untuk sync dan export.
- Retry terkontrol untuk integrasi SIAKAD.
- Timeout eksplisit untuk HTTP client.
- Error job tercatat dan bisa diulang.
- Proses generate rekap idempotent.

### Maintainability

Requirement:

- Setiap modul punya action/service yang jelas.
- Tidak ada business logic di Blade.
- Tidak ada query kompleks di controller jika bisa dipindah ke query object/service.
- Tidak ada duplikasi controller R01-R30 tanpa abstraksi.
- Coding standard memakai Laravel Pint.
- Static analysis direkomendasikan, minimal PHPStan Larastan level awal.

### Observability

Requirement:

- Query lambat dicatat di local/staging.
- Error integrasi dicatat dengan correlation id.
- Job queue gagal bisa dilihat administrator.
- Activity log bisa difilter.

## 11. Rekomendasi Teknologi

Stack utama:

- Laravel monolith.
- Blade + Vite atau Livewire/Inertia sesuai preferensi tim.
- MySQL/MariaDB atau PostgreSQL.
- Redis untuk cache, queue, dan rate limit bila tersedia.
- Laravel Queue untuk sync/export.
- Spatie Permission untuk RBAC.
- Spatie Activitylog untuk audit, dengan struktur event yang distandarkan.
- Laravel Excel untuk export.

Catatan:

- Pilih versi Laravel stabil saat implementasi dimulai.
- Jangan mengejar framework baru jika tim belum siap; prioritasnya struktur domain, testing, dan performa.

## 12. Struktur Modul yang Disarankan

### Auth Module

Tanggung jawab:

- Login/logout.
- Password management.
- Session management.
- Login via SIAKAD jika diputuskan tetap dipakai.
- Redirect setelah login berdasarkan role/permission.

### Users and Access Module

Tanggung jawab:

- User management.
- Role/permission.
- Assignment verifikator ke prodi/jurusan.
- Status user.

### Employee Module

Tanggung jawab:

- Data dosen/pegawai.
- Riwayat jabatan.
- Riwayat pangkat/golongan.
- Homebase prodi.
- Status aktif.

### Rubric Module

Tanggung jawab:

- Definisi rubrik.
- Parameter rubrik.
- Field rubrik.
- Input dan update isian.
- Scoring.

### Verification Module

Tanggung jawab:

- Queue verifikasi.
- Approve/reject.
- Catatan penolakan.
- Scope kewenangan.

### Recap Module

Tanggung jawab:

- Kalkulasi rekap.
- Snapshot final.
- Query agregasi.

### Report Module

Tanggung jawab:

- Laporan nominatif.
- Laporan keuangan.
- Export Excel/PDF.

### Siakad Module

Tanggung jawab:

- Client SIAKAD.
- OAuth/callback.
- Mapping response.
- Sync job.
- Sync log.
- Error handling.

## 13. Database dan Indexing

Indeks wajib:

- `users.email`
- `users.username` atau `users.pegawai_nip`
- `users.status`
- `employees.nip`
- `employees.nidn`
- `employees.prodi_homebase_id`
- `rubric_entries.period_id`
- `rubric_entries.rubric_id`
- `rubric_entries.employee_id`
- `rubric_entries.status`
- Composite: `rubric_entries(period_id, employee_id, status)`
- Composite: `rubric_entries(period_id, rubric_id, status)`
- Composite: `rubric_entries(period_id, employee_id, rubric_id)`
- `verification_assignments.verifier_id`
- `verification_assignments.prodi_id`
- `recap_snapshots.period_id`
- `siakad_sync_logs.action`
- `siakad_sync_logs.status`

Data integrity:

- Foreign key dipakai untuk entity utama.
- Unique constraint untuk data yang tidak boleh duplikat, misalnya periode aktif, kode rubrik, NIP, dan assignment tertentu.
- Soft delete untuk master data yang sudah dipakai transaksi.

## 14. UX Requirement Ringkas

Navigasi:

- Sidebar dibedakan berdasarkan permission.
- Dosen melihat menu rubrik, status isian, rekap pribadi, dan pengumuman.
- Verifikator melihat antrian verifikasi, riwayat verifikasi, dan rekap scope-nya.
- Admin melihat master data, sinkronisasi, user/access, rubrik, periode, rekap, laporan.

Form:

- Validasi tampil dekat field.
- Submit mutasi penting punya loading state.
- Reject wajib meminta catatan.
- Import SIAKAD menampilkan preview/summary sebelum hasil dipakai.

Table:

- Search, filter, sort, pagination.
- Kolom status memakai label konsisten.
- Action button disesuaikan status dan permission.

## 15. Migration Strategy dari Sistem Lama

Tahap 1: Audit data lama

- Inventaris tabel dan kolom yang masih dipakai.
- Identifikasi rubrik aktif dan data historis.
- Identifikasi data yang bisa dihitung ulang vs harus disimpan sebagai snapshot.
- Identifikasi user, role, dan mapping dosen.

Tahap 2: Desain mapping

- Mapping `users` lama ke user baru.
- Mapping `pegawais` ke employee/dosen baru.
- Mapping tabel R01-R30 ke `rubric_entries` atau tabel khusus.
- Mapping `nilai_ewmps` ke parameter rubrik.
- Mapping rekap lama ke snapshot jika perlu mempertahankan laporan historis.

Tahap 3: Migrasi percobaan

- Jalankan migrasi di staging.
- Bandingkan total dosen, total isian per rubrik, total point per dosen, dan laporan nominatif.
- Catat mismatch dan buat script koreksi.

Tahap 4: Cutover

- Freeze input di sistem lama.
- Backup database dan storage.
- Jalankan migrasi final.
- Validasi sampling bersama admin/verifikator.
- Buka sistem baru.

Tahap 5: Masa paralel

- Sistem lama read-only selama masa transisi.
- Sistem baru menjadi sumber input.
- Audit laporan periode pertama sebelum dipakai final.

## 16. Testing Strategy

Unit test:

- Calculator point R01-R30.
- Mapping response SIAKAD.
- Status transition rubrik.
- Policy access.

Feature test:

- Login semua role.
- CRUD master data penting.
- Dosen input rubrik.
- Dosen tidak bisa akses data dosen lain.
- Verifikator approve/reject sesuai scope.
- Generate rekap.
- Export laporan.

Integration test:

- SIAKAD client memakai fake HTTP response.
- Sync dosen idempotent.
- Sync R01/R02 idempotent.
- Retry dan error handling.

Performance test manual/staging:

- Dashboard dengan data produksi salinan.
- List rubrik dengan ribuan entry.
- Rekap periode besar.
- Export laporan besar.

## 17. Definition of Done

Satu fitur dianggap selesai jika:

- Requirement terpenuhi.
- Validasi ada di Form Request.
- Authorization memakai Policy/Gate.
- Query list menggunakan pagination.
- Relasi yang ditampilkan sudah eager loaded.
- Tidak ada query di Blade.
- Business logic tidak berada di controller.
- Unit/feature test relevan tersedia.
- Activity log dibuat untuk mutasi penting.
- Error state ditangani.
- Dokumentasi singkat tersedia bila ada flow baru.

## 18. Milestone Implementasi

### Milestone 1: Foundation

- Setup project Laravel baru.
- Setup auth, RBAC, layout dasar, coding standard, test framework.
- Setup struktur modul.
- Setup audit log.
- Setup queue dan cache.

Output:

- User dapat login/logout.
- Role dan permission berjalan.
- Struktur folder dan pattern disepakati.

### Milestone 2: Master Data

- Dosen/pegawai.
- Prodi/jurusan.
- Jabatan/pangkat.
- Periode.
- Rubrik dan nilai EWMP.

Output:

- Master data lengkap dan siap dipakai transaksi.

### Milestone 3: Integrasi SIAKAD Dasar

- SiakadClient.
- OAuth/callback jika dibutuhkan.
- Sync dosen dan prodi.
- Sync log.
- Admin UI untuk menjalankan dan melihat hasil sync.

Output:

- Sinkronisasi idempotent dan terpantau.

### Milestone 4: Rubrik dan Scoring

- Definisi rubrik R01-R30.
- Form input rubrik.
- Calculator point.
- Draft/submit.
- Import SIAKAD untuk R01/R02.

Output:

- Dosen dapat mengisi rubrik dan point dihitung otomatis.

### Milestone 5: Verifikasi

- Antrian verifikasi.
- Approve/reject.
- Scope verifikator.
- Catatan penolakan.
- Audit verifikasi.

Output:

- Workflow verifikasi siap dipakai.

### Milestone 6: Rekap dan Laporan

- Rekap per dosen/rubrik/prodi/periode.
- Snapshot periode locked.
- Laporan nominatif/keuangan.
- Export Excel.

Output:

- Data final siap digunakan pimpinan/keuangan.

### Milestone 7: Migrasi dan Cutover

- Script migrasi data lama.
- Validasi data.
- UAT.
- Cutover.

Output:

- Sistem baru menggantikan sistem lama.

## 19. Risiko dan Mitigasi

Risiko: Struktur rubrik dinamis terlalu kompleks.

Mitigasi: Gunakan hybrid model. Rubrik sederhana masuk tabel generik, rubrik kompleks memakai tabel khusus dengan contract yang sama.

Risiko: Formula point lama tidak terdokumentasi.

Mitigasi: Extract formula dari kode lama, validasi dengan user operasional, lalu kunci dalam unit test.

Risiko: Data historis tidak konsisten.

Mitigasi: Buat migration report dan mismatch report sebelum cutover.

Risiko: SIAKAD tidak stabil.

Mitigasi: Sync async, retry terbatas, timeout, fallback data lokal, dan UI error log.

Risiko: Scope verifikator tidak jelas.

Mitigasi: Buat tabel assignment eksplisit dan policy berdasarkan assignment.

Risiko: Rebuild melebar.

Mitigasi: MVP dibatasi sampai input-verifikasi-rekap-laporan. Fitur tambahan masuk backlog.

## 20. Open Questions

- Apakah dosen harus login langsung via SIAKAD, atau cukup akun lokal yang disinkronkan dengan data SIAKAD?
- Apakah data R01/R02 dari SIAKAD harus otomatis masuk sebagai submitted, atau masuk sebagai draft dulu untuk direview dosen?
- Apakah semua rubrik R01-R30 wajib tersedia di MVP, atau bisa diprioritaskan berdasarkan frekuensi penggunaan?
- Apakah verifikator berbasis prodi, jurusan, rubrik, atau kombinasi?
- Apakah periode lama harus dimigrasikan lengkap sampai detail isian, atau cukup rekap final?
- Apakah laporan keuangan punya formula pembayaran yang tetap atau berubah per periode?
- Apakah presensi masih menjadi bagian sistem baru?
- Apakah ada kebutuhan approval berlapis setelah verifikator?

## 21. Backlog Teknis Prioritas

Prioritas tinggi:

- Hilangkan auth dosen berbasis `$_SESSION`.
- Buat `SiakadClient` dengan fakeable HTTP client.
- Pusatkan calculator point.
- Buat policy untuk semua akses data dosen/rubrik.
- Buat query agregasi untuk dashboard dan rekap.
- Buat indeks database sejak migration awal.
- Buat test untuk flow login, input rubrik, verifikasi, dan rekap.

Prioritas menengah:

- Async export.
- UI monitoring sync.
- Snapshot rekap final.
- Import preview dari SIAKAD.
- Static analysis.

Prioritas rendah:

- Notification email/WhatsApp.
- Advanced analytics.
- API publik.

## 22. Kriteria Sukses

Produk dianggap berhasil jika:

- User operasional dapat menyelesaikan input, verifikasi, dan laporan satu periode penuh di sistem baru.
- Jumlah query halaman utama berada dalam target performa.
- Tidak ada logic SIAKAD di controller.
- Tidak ada auth dosen berbasis session manual.
- Formula point punya test dan hasilnya tervalidasi dengan data contoh.
- Rekap laporan baru cocok dengan laporan lama untuk data pembanding yang disepakati.
- Admin dapat melihat status dan error sinkronisasi SIAKAD.
- Developer dapat menambah/mengubah rubrik tanpa copy-paste controller besar.

