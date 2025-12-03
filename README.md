# BEM UDINUS - Sistem Absensi Digital

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.50.0-red" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.3-blue" alt="PHP Version">
  <img src="https://img.shields.io/badge/Bootstrap-5-purple" alt="Bootstrap Version">
  <img src="https://img.shields.io/badge/MySQL-8.0-orange" alt="MySQL Version">
  <img src="https://img.shields.io/badge/Status-Production_Ready-green" alt="Status">
</p>

**Sistem Absensi Digital** berbasis NFC untuk Badan Eksekutif Mahasiswa Keluarga Mahasiswa Universitas Dian Nuswantoro. Aplikasi modern dengan antarmuka profesional yang memungkinkan pencatatan kehadiran secara real-time dan export laporan resmi BEM.

## 🚀 Fitur Utama

### 📋 Manajemen Data
- **Kelola Peserta**: CRUD lengkap untuk data peserta dengan informasi NIM, nama, fakultas, dan jabatan
- **Kelola Kegiatan**: Manajemen kegiatan dengan tanggal dan waktu pelaksanaan
- **Validasi Data**: Validasi unik untuk NIM dan UID kartu NFC

### 📱 Sistem Absensi
- **Scan NFC**: Interface scanning kartu NFC untuk absensi otomatis
- **Status Real-time**: Menampilkan status kehadiran secara real-time
- **Riwayat Kehadiran**: Tracking lengkap riwayat absensi per kegiatan
- **Deteksi Duplikasi**: Mencegah absensi ganda dalam satu kegiatan

### 📊 Monitoring & Laporan
- **Dashboard Monitoring**: Overview data absensi dan statistik kehadiran
- **Export Data**: Export laporan ke format PDF dan Excel
- **Filter Data**: Filter berdasarkan kegiatan, tanggal, dan status kehadiran

### 🔒 Keamanan
- **Autentikasi Admin**: Sistem login khusus untuk admin
- **Session Management**: Manajemen sesi yang aman
- **CSRF Protection**: Perlindungan terhadap serangan CSRF

## 🛠 Teknologi yang Digunakan

- **Backend**: Laravel 10.50.0
- **Database**: MySQL
- **Frontend**: Bootstrap 5, jQuery
- **PHP**: 8.3.26
- **CSS Framework**: Bootstrap Icons
- **Session**: File-based sessions
- **Timezone**: Asia/Jakarta

## 📋 Persyaratan Sistem

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Web Server (Apache/Nginx)
- Extension PHP: PDO, Mbstring, Tokenizer, XML, JSON

## ⚡ Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/username/AbsensiNFC.git
cd AbsensiNFC
```

### 2. Install Dependencies
```bash
composer install
npm install && npm run build
```

### 3. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan pengaturan database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absen
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Migrasi Database
```bash
php artisan migrate
php artisan db:seed
```

### 6. Jalankan Aplikasi
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 👤 Akun Default

Setelah menjalankan seeder, gunakan akun berikut untuk login:

- **Email**: admin@admin.com
- **Password**: password

> ⚠️ **Penting**: Segera ubah password default setelah login pertama kali!

## 🔧 Menambah Administrator

### Cara 1: Menggunakan Script (Termudah)
```bash
# Windows
TAMBAH_ADMIN.bat

# Linux/Mac
php tambah_admin.php
```

### Cara 2: Menggunakan Artisan Command
```bash
php artisan admin:add
# atau langsung dengan parameter
php artisan admin:add "Nama Admin" "email@admin.com" "password123"
```

### Cara 3: Melihat Daftar Admin
```bash
# Windows  
LIHAT_ADMIN.bat

# Linux/Mac
php lihat_admin.php
```

## 📖 Panduan Penggunaan

### 1. Login Admin
- Akses halaman login di URL utama
- Masukkan username dan password admin
- Sistem akan redirect ke dashboard

### 2. Mengelola Peserta
- Masuk ke menu "Kelola Peserta"
- Tambah peserta baru dengan mengisi form
- UID kartu NFC bisa dikosongkan dulu, diisi nanti saat kartu tersedia
- Edit atau hapus data peserta sesuai kebutuhan

### 3. Mengelola Kegiatan
- Masuk ke menu "Kelola Kegiatan"  
- Buat kegiatan baru dengan nama dan jadwal
- Aktifkan kegiatan yang sedang berlangsung
- Edit detail kegiatan jika diperlukan

### 4. Melakukan Absensi
- Masuk ke menu "Scan Absensi"
- Pilih kegiatan yang sedang berlangsung
- Tempelkan kartu NFC ke reader
- Sistem otomatis mencatat kehadiran dan mencegah duplikasi

### 5. Monitoring Data
- Akses menu "Monitor Absensi"
- Lihat data kehadiran real-time
- Filter berdasarkan kegiatan atau tanggal
- Export data ke PDF atau Excel

## 🗂 Struktur Database

### Tabel Peserta
- `id`: Primary key
- `uid`: UID kartu NFC (nullable, unique)
- `nama`: Nama lengkap peserta
- `nim`: Nomor Induk Mahasiswa (unique)
- `fakultas`: Nama fakultas/jurusan
- `jabatan`: Jabatan peserta (nullable)
- `timestamps`: Created at, Updated at

### Tabel Kegiatan
- `id`: Primary key
- `nama`: Nama kegiatan
- `tanggal`: Tanggal pelaksanaan
- `waktu_mulai`: Waktu mulai kegiatan
- `waktu_selesai`: Waktu selesai kegiatan
- `status`: Status kegiatan (aktif/nonaktif)
- `timestamps`: Created at, Updated at

### Tabel Absensi
- `id`: Primary key
- `peserta_id`: Foreign key ke tabel peserta
- `kegiatan_id`: Foreign key ke tabel kegiatan
- `waktu_absen`: Timestamp absensi
- `status`: Status kehadiran
- `timestamps`: Created at, Updated at

## 🔧 Kustomisasi

### Mengubah Timezone
Edit file `config/app.php`:
```php
'timezone' => 'Asia/Jakarta',
```

### Mengubah Session Lifetime
Edit file `.env`:
```env
SESSION_LIFETIME=480
```

### Kustomisasi Validasi
Edit controller yang sesuai di folder `app/Http/Controllers/`

## 🚀 Deployment

### Untuk Production
1. Set environment ke production:
```env
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
```

2. Optimize aplikasi:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

3. Set permissions yang tepat:
```bash
chmod -R 755 storage bootstrap/cache
```

## 📝 Lisensi

Proyek ini menggunakan lisensi MIT. Lihat file `LICENSE` untuk detail lengkap.

## 🔄 Changelog

### Version 1.0.0
- ✅ Sistem autentikasi admin
- ✅ CRUD peserta dengan NIM dan fakultas
- ✅ CRUD kegiatan
- ✅ Sistem absensi NFC dengan deteksi duplikasi
- ✅ Dashboard monitoring real-time
- ✅ Export laporan PDF dan Excel
- ✅ Interface responsive dengan Bootstrap 5
- ✅ Timezone Asia/Jakarta
- ✅ Validasi data lengkap

---

**Dikembangkan dengan ❤️ menggunakan Laravel Framework**
