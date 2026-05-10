# Website Administrasi Rekam Medis Pasien

Website ini dirancang untuk membantu klinik / fasilitas kesehatan sederhana dalam mengelola data pasien dan rekam medis menggunakan PHP, HTML, dan MySQL. Proyek ini merupakan tugas akhir Praktikum Pemrograman Web Dasar yang mengintegrasikan sistem manajemen pasien, rekam medis, dan laporan medis dalam satu platform.

## 📋 Fitur Utama

### Autentikasi & Akses

- Login dengan role berdasarkan pengguna:
  - **Admin**: Mengelola semua data aplikasi
  - **Petugas Pendaftaran**: Menangani registrasi pasien baru dan harian
  - **Dokter**: Membuat pemeriksaan dan rekam medis pasien

### Manajemen Data

- **Pasien**: CRUD lengkap (Tambah, Lihat, Edit, Hapus) dengan validasi data
- **Dokter**: Kelola data dokter dan spesialisasi
- **Poli**: Manajemen poliklinik/ruang pemeriksaan
- **Obat**: Manajemen inventaris obat
- **Resep**: Pencatatan resep untuk pasien
- **Tindakan**: Pencatatan tindakan medis yang dilakukan

### Alur Layanan Kesehatan

- **Registrasi**: Pendaftaran pasien ke dalam sistem
- **Pemeriksaan**: Proses pemeriksaan per poli dengan pencatatan tanda vital
- **Kunjungan**: Riwayat lengkap kunjungan pasien ke klinik
- **Rekam Medis**: Dokumentasi lengkap riwayat medis pasien

### Laporan

- Laporan Pasien
- Laporan Dokter
- Laporan Poliklinik
- Laporan Kunjungan
- Laporan Rekam Medis
- Laporan Resep
- Laporan Tindakan
- Export ke format cetak

### Dashboard & Monitoring

- Dashboard dengan informasi ringkas
- List registrasi hari ini
- Riwayat kunjungan pasien

## 🛠 Teknologi yang Digunakan

- **Backend**: PHP 7.x (native, tanpa framework)
- **Frontend**: HTML5, CSS3, Bootstrap
- **Database**: MySQL
- **Server**: XAMPP (Apache + MySQL)
- **Scripting**: JavaScript (validasi dan interaksi UI)
- **Styling**: Bootstrap CSS + Custom CSS

## 📁 Struktur Folder

```
├── index.php                          # Halaman utama / landing
├── klinik_rekam_medis.sql            # Database SQL
├── README.md                          # Dokumentasi
│
├── assets/                            # Aset statis
│   ├── css/                           # Stylesheet
│   │   ├── bootstrap.css
│   │   ├── bootstrap.min.css
│   │   ├── simple-sidebar.css
│   │   └── style.css
│   ├── fonts/                         # Font files
│   └── js/                            # JavaScript
│       ├── bootstrap.js
│       ├── bootstrap.min.js
│       └── jquery.js
│
├── auth/                              # Autentikasi
│   ├── login.php                      # Halaman login
│   ├── logout.php                     # Proses logout
│   └── proses_login.php               # Validasi login
│
├── config/                            # Konfigurasi
│   ├── koneksi.php                    # Koneksi database
│   ├── auth.php                       # Fungsi autentikasi
│   ├── bootstrap.php                  # Bootstrap aplikasi
│   └── fungsi.php                     # Fungsi utility
│
├── dashboard/                         # Dashboard
│   └── index.php                      # Halaman dashboard
│
├── includes/                          # Komponen shared
│   ├── header.php                     # Header layout
│   ├── sidebar.php                    # Sidebar navigasi
│   └── footer.php                     # Footer layout
│
├── pasien/                            # Manajemen Pasien
│   ├── index.php                      # List pasien
│   ├── create.php                     # Form tambah pasien
│   ├── edit.php                       # Form edit pasien
│   ├── proses.php                     # Proses tambah pasien
│   ├── proses_edit.php                # Proses edit pasien
│   ├── hapus.php                      # Proses hapus pasien
│   └── print.php                      # Cetak data pasien
│
├── dokter/                            # Manajemen Dokter
│   ├── index.php
│   ├── create.php
│   ├── edit.php
│   ├── delete.php
│   ├── proses.php
│   └── proses_edit.php
│
├── poli/                              # Manajemen Poliklinik
│   ├── index.php
│   ├── create.php
│   ├── edit.php
│   ├── delete.php
│   ├── proses.php
│   └── proses_edit.php
│
├── obat/                              # Manajemen Obat
│   ├── index.php
│   ├── create.php
│   ├── edit.php
│   ├── delete.php
│   ├── proses.php
│   └── proses_edit.php
│
├── tindakan/                          # Manajemen Tindakan
│   ├── index.php
│   ├── create.php
│   ├── edit.php
│   ├── delete.php
│   ├── proses.php
│   └── proses_edit.php
│
├── resep/                             # Manajemen Resep
│   ├── index.php
│   ├── create.php
│   ├── edit.php
│   ├── delete.php
│   ├── proses.php
│   └── proses_edit.php
│
├── kunjungan/                         # Manajemen Kunjungan
│   ├── index.php
│   ├── create.php
│   ├── edit.php
│   ├── delete.php
│   ├── proses.php
│   └── proses_edit.php
│
├── registrasi/                        # Registrasi Pasien
│   ├── index.php                      # Form registrasi
│   ├── history.php                    # Riwayat registrasi
│   └── list_hari_ini.php              # Registrasi hari ini
│
├── pemeriksaan/                       # Pemeriksaan Pasien
│   ├── index.php
│   └── poli.php                       # Per poliklinik
│
├── rekam_medis/                       # Manajemen Rekam Medis
│   ├── index.php
│   ├── create.php
│   ├── edit.php
│   ├── delete.php
│   ├── proses.php
│   ├── proses_edit.php
│   └── print.php
│
└── laporan/                           # Laporan
    ├── index.php
    ├── laporan_pasien.php
    ├── laporan_dokter.php
    ├── laporan_poli.php
    ├── laporan_kunjungan.php
    ├── laporan_rekam_medis.php
    ├── laporan_resep.php
    ├── laporan_tindakan.php
    ├── laporan_simple.php
    └── print.php
```

## 🚀 Instalasi & Setup

### Prasyarat

- XAMPP (atau web server dengan PHP 7.x dan MySQL)
- Browser modern (Chrome, Firefox, dll)

### Langkah-langkah Instalasi

1. **Download/Clone Project**

   ```bash
   git clone <repository-url>
   # atau extract file ke folder
   cd Website-Administrasi-Rekam-Medis-Pasien
   ```

2. **Setup Database**
   - Buka phpMyAdmin (<http://localhost/phpmyadmin>)
   - Import file `klinik_rekam_medis.sql` untuk membuat database dan tabel

3. **Konfigurasi Koneksi Database**
   - Edit file `config/koneksi.php`
   - Sesuaikan parameter host, user, password, dan database name

4. **Akses Aplikasi**
   - Tempatkan folder proyek di `htdocs/` (XAMPP)
   - Akses melalui browser: `http://localhost/Website-Administrasi-Rekam-Medis-Pasien`

## 👤 Role & Permission

### Admin

- Akses penuh ke semua fitur
- Dapat mengelola dokter, poli, obat, tindakan
- Dapat melihat semua laporan

### Petugas Pendaftaran

- Melakukan registrasi pasien baru
- Melihat list registrasi harian
- Melihat riwayat kunjungan pasien
- Tidak dapat mengedit data master (dokter, poli, obat)

### Dokter

- Membuat pemeriksaan pasien
- Membuat rekam medis
- Membuat resep
- Melihat laporan yang relevan

## 📄 Lisensi

Aplikasi ini dibuat untuk keperluan akademik dan tugas akhir Praktikum Pemrograman Web Dasar. Silakan gunakan dengan atribusi kepada penulis dan jelaskan tujuan penggunaan.

## 👥 Tim Pengembang

**Kelompok 2 PRAK.WEB SI-C**

### Anggota

- **Azriel Yalsha Hanifah** – 124250058
- **Tiara Edita Kurniasari** – 124250065

### Asisten Lab

- **Luthfan Kafi Maulana** - 124230165
- **Krisna Mus'ad Zein** - 124240154

---

**Terakhir diperbarui**: Mei 2026
