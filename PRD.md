# PRODUCT REQUIREMENTS DOCUMENT (PRD)

# SISTEM INFORMASI PRAKTIK KERJA LAPANGAN (SIPRAK)

## 1. Informasi Dokumen

| Item            | Keterangan                              |
| --------------- | --------------------------------------- |
| Nama Sistem     | SIPRAK                                  |
| Kepanjangan     | Sistem Informasi Praktik Kerja Lapangan |
| Platform        | Web                                     |
| Framework       | Laravel                                 |
| Database        | MySQL                                   |
| Database Aktif  | `sistem_pkl`                            |
| Primary Key     | INT UNSIGNED                            |
| Status          | Pengembangan                            |
| Target Pengguna | Admin, Guru, Siswa                      |

---

# 2. Latar Belakang

Pelaksanaan Praktik Kerja Lapangan (PKL) membutuhkan pengelolaan data siswa, guru, rombel, jurusan, industri, pengajuan PKL, persetujuan, pembimbing, jurnal, absensi, dan penilaian.

Pengelolaan secara manual dapat menyebabkan data tersebar, proses persetujuan sulit dipantau, serta menyulitkan sekolah dalam melakukan monitoring dan pembuatan laporan.

SIPRAK dibuat untuk mengintegrasikan seluruh proses tersebut dalam satu sistem berbasis web.

---

# 3. Tujuan Sistem

SIPRAK bertujuan untuk:

1. Mengelola data siswa dan guru secara terpusat.
2. Mengelola data jurusan dan rombel.
3. Mengelola data industri yang menjadi tempat PKL.
4. Memfasilitasi pengajuan PKL siswa.
5. Mengelola proses approval pengajuan PKL.
6. Mengelola penugasan guru pembimbing.
7. Memantau jurnal kegiatan siswa.
8. Mengelola absensi PKL.
9. Mengelola penilaian PKL.
10. Menyediakan data dan laporan kegiatan PKL.
11. Mencatat aktivitas pengguna dalam sistem.

---

# 4. Ruang Lingkup Sistem

SIPRAK mencakup:

```text
Autentikasi
    ↓
Master Data
    ↓
Data PKL
    ↓
Approval
    ↓
Mapping Pembimbing
    ↓
Monitoring
    ↓
Penilaian
    ↓
Laporan
```

## 4.1 Modul Utama

### A. Authentication

* Login
* Logout
* Session pengguna
* Pencatatan waktu login

### B. Master Data

* Murid
* Rombel
* Jurusan
* Guru

**Tidak terdapat Master Data Kelas.**

Data tingkat/kelas siswa direpresentasikan melalui `rombel`.

### C. Data PKL

* Pengajuan PKL
* Industri
* Mapping Pembimbing
* Approval

### D. Monitoring

* Jurnal
* Absensi
* Penilaian

### E. Laporan

* Data siswa PKL
* Data industri
* Data pembimbing
* Rekap jurnal
* Rekap absensi
* Rekap penilaian
* Status pengajuan

### F. Log Aktivitas

Mencatat aktivitas penting pengguna pada sistem.

---

# 5. Pengguna Sistem

SIPRAK memiliki dua tipe akun utama pada database:

```text
users.tipe_akun
├── siswa
└── guru
```

Guru kemudian mendapatkan role melalui tabel `guru_role`.

Role guru:

```text
Admin
WaliKelas
Pembimbing
Kaprog
```

Dengan demikian, satu akun guru dapat memiliki role tertentu sesuai data pada `guru_role`.

---

# 6. Hak Akses Pengguna

## 6.1 Admin

Admin bertanggung jawab terhadap pengelolaan sistem dan data.

### Akses:

* Dashboard
* Master Data Murid
* Master Data Rombel
* Master Data Jurusan
* Master Data Guru
* Data Industri
* Pengajuan PKL
* Mapping Pembimbing
* Approval
* Monitoring Jurnal
* Monitoring Absensi
* Monitoring Penilaian
* Laporan
* Log Aktivitas

---

## 6.2 Wali Kelas

Wali Kelas bertanggung jawab terhadap pengajuan siswa pada rombel yang menjadi tanggung jawabnya.

### Akses:

* Dashboard
* Data siswa pada rombel
* Verifikasi pengajuan PKL
* Melihat status pengajuan
* Monitoring data siswa terkait

---

## 6.3 Kaprog

Kaprog bertanggung jawab terhadap proses persetujuan pengajuan berdasarkan jurusan.

### Akses:

* Dashboard
* Data siswa jurusan terkait
* Verifikasi pengajuan PKL
* Monitoring PKL
* Melihat data industri terkait jurusan

---

## 6.4 Pembimbing

Pembimbing bertanggung jawab terhadap siswa yang telah ditugaskan kepadanya.

### Akses:

* Dashboard
* Daftar siswa bimbingan
* Monitoring jurnal
* Monitoring absensi
* Verifikasi jurnal
* Penilaian siswa

---

## 6.5 Siswa

Siswa menggunakan sistem untuk proses PKL pribadi.

### Akses:

* Dashboard
* Melihat profil
* Pengajuan PKL
* Melihat status pengajuan
* Melihat industri
* Mengisi jurnal
* Mengisi absensi
* Melihat penilaian

---

# 7. Master Data

## 7.1 Master Data Murid

Admin dapat:

* Melihat data siswa
* Menambah siswa
* Mengubah data siswa
* Menghapus/nonaktifkan siswa
* Mencari siswa
* Memfilter berdasarkan jurusan
* Memfilter berdasarkan rombel
* Melihat status akun

Data siswa berasal dari tabel:

```text
siswa
```

Relasi utama:

```text
siswa
├── users
├── rombel
└── jurusan
```

---

## 7.2 Master Data Rombel

Admin dapat:

* Melihat daftar rombel
* Menambah rombel
* Mengubah rombel
* Mengaktifkan/nonaktifkan rombel
* Menentukan jurusan
* Menentukan wali kelas
* Menentukan tahun ajaran

Data berasal dari:

```text
rombel
```

Tidak diperlukan tabel `kelas`.

---

## 7.3 Master Data Jurusan

Admin dapat:

* Melihat jurusan
* Menambah jurusan
* Mengubah jurusan
* Mengaktifkan/nonaktifkan jurusan
* Menentukan Kaprog

Data berasal dari:

```text
jurusan
```

---

## 7.4 Master Data Guru

Admin dapat:

* Melihat data guru
* Menambah guru
* Mengubah data guru
* Mengaktifkan/nonaktifkan akun guru
* Mengatur role guru

Data guru disimpan pada:

```text
guru
```

Role guru disimpan melalui:

```text
guru_role
role
```

---

# 8. Data Industri

Admin dapat mengelola data perusahaan/instansi tempat PKL.

Data industri meliputi:

* Nama industri
* Alamat
* Latitude
* Longitude
* Radius lokasi
* Nama kontak
* Nomor kontak
* Email kontak
* Kuota
* Dokumen MOU
* Masa berlaku MOU
* Status

Tabel:

```text
industri
```

Hubungan industri dengan jurusan menggunakan:

```text
industri_jurusan
```

Satu industri dapat menerima siswa dari beberapa jurusan.

---

# 9. Pengajuan PKL

Siswa dapat mengajukan PKL dengan memilih industri dan menentukan periode PKL.

Data pengajuan:

* Siswa
* Industri
* Tanggal mulai
* Tanggal selesai
* Dokumen
* Status
* Waktu dibuat

Tabel:

```text
pengajuan_pkl
```

## Status Pengajuan

```text
draft
menunggu_walikelas
menunggu_kaprog
menunggu_hubinmas
disetujui
ditolak
```

---

# 10. Proses Approval

Pengajuan PKL diproses secara bertahap:

```text
Siswa
  ↓
Pengajuan
  ↓
Wali Kelas
  ↓
Kaprog
  ↓
Hubinmas
  ↓
Disetujui
```

Setiap proses approval disimpan pada:

```text
approval
```

Data approval:

* Pengajuan
* Guru pemroses
* Tahap
* Status
* Catatan
* Waktu proses

Status:

```text
menunggu
disetujui
ditolak
```

---

# 11. Mapping Pembimbing

Setelah pengajuan PKL disetujui, siswa dapat diberikan guru pembimbing.

Data penugasan:

```text
pembimbing_penugasan
```

Data meliputi:

* Siswa
* Pengajuan PKL
* Guru pembimbing
* Tanggal mulai

Alur:

```text
Pengajuan Disetujui
        ↓
Pilih Siswa
        ↓
Pilih Guru Pembimbing
        ↓
Tentukan Tanggal Mulai
        ↓
Simpan Penugasan
```

---

# 12. Jurnal PKL

Siswa dapat mencatat kegiatan PKL.

Data jurnal:

* Tanggal
* Kegiatan
* Deskripsi
* Hasil
* Kendala
* Solusi
* Bukti kegiatan
* Status

Status jurnal:

```text
draft
diajukan
disetujui
ditolak
```

Pembimbing dapat melakukan pemeriksaan terhadap jurnal siswa.

---

# 13. Absensi PKL

Siswa memiliki data absensi berdasarkan tanggal.

Status absensi:

```text
hadir
izin
sakit
alpa
```

Data tambahan:

* Jam masuk
* Jam keluar
* Keterangan
* Bukti

Satu siswa hanya memiliki satu data absensi dalam satu tanggal.

Constraint:

```text
siswa_id + tanggal
```

---

# 14. Penilaian PKL

Guru pembimbing dapat memberikan penilaian kepada siswa.

Komponen penilaian:

* Nilai Pembimbing
* Nilai Industri
* Nilai Akhir
* Catatan
* Waktu penilaian

Data disimpan pada:

```text
penilaian
```

Satu pengajuan PKL siswa memiliki satu data penilaian berdasarkan constraint:

```text
siswa_id + pengajuan_id
```

---

# 15. Dashboard

## 15.1 Dashboard Admin

Dashboard menampilkan ringkasan:

* Total siswa
* Total guru
* Total jurusan
* Total rombel
* Total industri
* Total pengajuan
* Pengajuan menunggu approval
* PKL aktif
* Data pembimbing

Dashboard dapat menyediakan grafik:

* Jumlah pengajuan berdasarkan status
* Jumlah siswa berdasarkan jurusan
* Jumlah siswa berdasarkan industri
* Rekap PKL

---

## 15.2 Dashboard Wali Kelas

Menampilkan:

* Jumlah siswa pada rombel
* Siswa yang sudah mengajukan PKL
* Pengajuan menunggu verifikasi
* Pengajuan disetujui
* Pengajuan ditolak

---

## 15.3 Dashboard Kaprog

Menampilkan:

* Jumlah siswa jurusan
* Pengajuan menunggu approval
* Pengajuan disetujui
* Pengajuan ditolak
* Industri terkait jurusan

---

## 15.4 Dashboard Pembimbing

Menampilkan:

* Jumlah siswa bimbingan
* Jurnal menunggu pemeriksaan
* Rekap absensi
* Siswa PKL aktif
* Penilaian yang belum dilakukan

---

## 15.5 Dashboard Siswa

Menampilkan:

* Status pengajuan PKL
* Industri PKL
* Guru pembimbing
* Periode PKL
* Jurnal terbaru
* Rekap absensi
* Nilai akhir

---

# 16. Laporan

Sistem menyediakan laporan berdasarkan data yang tersedia pada database.

### Laporan yang direncanakan:

1. Laporan Data Siswa PKL
2. Laporan Data Industri
3. Laporan Pengajuan PKL
4. Laporan Approval
5. Laporan Pembimbing
6. Laporan Jurnal
7. Laporan Absensi
8. Laporan Penilaian

Filter dapat berdasarkan:

* Jurusan
* Rombel
* Industri
* Guru Pembimbing
* Status
* Periode
* Tahun Ajaran

---

# 17. Log Aktivitas

Sistem mencatat aktivitas pengguna melalui tabel:

```text
log_aktivitas
```

Informasi yang dicatat:

* User
* Aksi
* Modul
* Deskripsi
* IP Address
* User Agent
* Waktu aktivitas

Contoh:

```text
Admin menambahkan data siswa
Admin mengubah data industri
Guru menyetujui pengajuan
Pembimbing menyetujui jurnal
Siswa membuat pengajuan PKL
```

---

# 18. Struktur Database yang Digunakan

Database bisnis utama SIPRAK menggunakan:

```text
users
jurusan
rombel
siswa
guru
role
guru_role
industri
industri_jurusan
pengajuan_pkl
approval
pembimbing_penugasan
jurnal
absensi
penilaian
log_aktivitas
```

### Tabel yang sengaja tidak digunakan

```text
kelas
```

Karena data kelas sudah direpresentasikan melalui:

```text
rombel
```

### Tabel pendukung Laravel

Laravel juga membuat tabel internal framework seperti:

```text
cache
cache_locks
jobs
job_batches
failed_jobs
password_reset_tokens
sessions
```

Tabel tersebut bukan bagian dari proses bisnis SIPRAK.

---

# 19. Aturan Database

Seluruh primary key tabel bisnis utama menggunakan:

```php
$table->increments('id');
```

yang menghasilkan:

```text
INT UNSIGNED
```

Foreign key menggunakan:

```php
$table->unsignedInteger('..._id');
```

sehingga seluruh primary key dan foreign key mempunyai tipe yang konsisten.

---

# 20. Aturan Integritas Data

Sistem menggunakan foreign key untuk menjaga hubungan antar data.

Contoh:

```text
users
 ↓
guru / siswa
```

```text
jurusan
 ↓
rombel
 ↓
siswa
```

```text
siswa + industri
 ↓
pengajuan_pkl
 ↓
approval
 ↓
pembimbing_penugasan
```

```text
siswa
 ↓
jurnal
absensi
penilaian
```

Data yang masih memiliki relasi aktif tidak boleh dihapus sembarangan. Sistem menggunakan aturan cascade, restrict, atau set null sesuai kebutuhan relasi.

---

# 21. Alur Bisnis Utama

```text
LOGIN
  ↓
Dashboard sesuai role
  ↓
Master Data
  ↓
Siswa memilih Industri
  ↓
Pengajuan PKL
  ↓
Approval Wali Kelas
  ↓
Approval Kaprog
  ↓
Approval Hubinmas
  ↓
Pengajuan Disetujui
  ↓
Mapping Pembimbing
  ↓
Pelaksanaan PKL
  ├── Absensi
  └── Jurnal
        ↓
    Monitoring Pembimbing
        ↓
     Penilaian
        ↓
      Laporan
```

---

# 22. Persyaratan Fungsional

| ID     | Fitur               | Prioritas |
| ------ | ------------------- | --------- |
| FR-001 | Login               | Tinggi    |
| FR-002 | Logout              | Tinggi    |
| FR-003 | Manajemen siswa     | Tinggi    |
| FR-004 | Manajemen rombel    | Tinggi    |
| FR-005 | Manajemen jurusan   | Tinggi    |
| FR-006 | Manajemen guru      | Tinggi    |
| FR-007 | Manajemen role guru | Tinggi    |
| FR-008 | Manajemen industri  | Tinggi    |
| FR-009 | Pengajuan PKL       | Tinggi    |
| FR-010 | Approval PKL        | Tinggi    |
| FR-011 | Mapping pembimbing  | Tinggi    |
| FR-012 | Jurnal PKL          | Tinggi    |
| FR-013 | Absensi PKL         | Tinggi    |
| FR-014 | Penilaian PKL       | Tinggi    |
| FR-015 | Dashboard           | Sedang    |
| FR-016 | Laporan             | Sedang    |
| FR-017 | Log aktivitas       | Sedang    |

---

# 23. Persyaratan Non-Fungsional

## 23.1 Keamanan

* Password disimpan menggunakan hashing.
* Halaman harus membutuhkan autentikasi sesuai kebutuhan.
* Hak akses dibatasi berdasarkan role.
* Aktivitas penting dicatat.
* Validasi input dilakukan pada server.

## 23.2 Usability

* Antarmuka sederhana dan mudah digunakan.
* Navigasi konsisten.
* Form memiliki validasi.
* Pesan error harus mudah dipahami.
* Data dapat dicari dan difilter.

## 23.3 Performance

* Query database menggunakan relasi yang sesuai.
* Pagination digunakan pada tabel data besar.
* Index digunakan pada kolom yang sering digunakan untuk pencarian dan relasi.

---

# 24. Acceptance Criteria Utama

Sistem dianggap memenuhi kebutuhan dasar apabila:

### Authentication

* User dapat login menggunakan akun yang valid.
* User dengan password salah ditolak.
* User dapat logout.
* Session pengguna dihapus setelah logout.

### Master Data

* Admin dapat mengelola siswa.
* Admin dapat mengelola rombel.
* Admin dapat mengelola jurusan.
* Admin dapat mengelola guru.
* Admin dapat mengelola industri.

### Pengajuan

* Siswa dapat membuat pengajuan PKL.
* Pengajuan memiliki status.
* Pengajuan dapat diproses melalui tahapan approval.

### Pembimbing

* Admin dapat menentukan guru pembimbing.
* Siswa memiliki pembimbing berdasarkan pengajuan PKL.

### Monitoring

* Siswa dapat membuat jurnal.
* Siswa dapat mengisi absensi.
* Pembimbing dapat memonitor jurnal dan absensi.

### Penilaian

* Pembimbing dapat memberikan penilaian.
* Nilai akhir tersimpan.
* Siswa dapat melihat hasil penilaian.

### Database

* Seluruh foreign key valid.
* Tidak terdapat tabel `kelas`.
* Struktur database sesuai migration aktif.
* Tidak terdapat konflik tipe PK/FK.
* Seeder dapat dijalankan dengan:

```bash
php artisan migrate:fresh --seed
```

tanpa error.

---

# 25. Status Implementasi Database

Database SIPRAK saat ini telah berhasil menjalankan:

```bash
php artisan migrate:fresh --seed
```

tanpa error.

Migration bisnis utama yang berhasil:

```text
users
jurusan
guru
role
rombel
industri
siswa
guru_role
industri_jurusan
pengajuan_pkl
approval
jurnal
pembimbing_penugasan
absensi
log_aktivitas
penilaian
```

Seeder yang berhasil:

```text
JurusanSeeder
GuruSeeder
RombelSeeder
SiswaSeeder
IndustriSeeder
PengajuanPklSeeder
PembimbingPenugasanSeeder
```

Dengan demikian, PRD ini menggunakan **struktur database aktual SIPRAK**, bukan struktur rancangan lama.
