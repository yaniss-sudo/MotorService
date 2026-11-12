# YZ Service Motor — Sistem Manajemen Operasional Bengkel

Aplikasi manajemen layanan bengkel motor berbasis web dan REST API yang dibangun menggunakan **Laravel**, **MySQL**, dan **Bootstrap 5**. Sistem ini dirancang untuk mengelola data pelanggan, unit kendaraan, pendaftaran antrean servis, detail pengerjaan mekanik, hingga transaksi pembayaran secara terpadu.

---

## Fitur Utama & Modul Aplikasi

Aplikasi ini mencakup lima modul operasional utama beserta kontrol hak akses pengguna (`Admin` dan `User`):

1. **Data Pelanggan**
   - Manajemen informasi identitas pemilik kendaraan (`Id Pelanggan`, `Nama Lengkap`, `No HP`, `Alamat Pelanggan`, dan `Pekerjaan`).
2. **Data Kendaraan**
   - Pencatatan data unit motor (`No Plat Kendaraan`, `Jenis Kendaraan` dengan pilihan radio button *Matic* / *Manual Transmisi*, `No STNK`, `Tahun Pembuatan`, `Nama Pemilik`, `Warna Kendaraan`, serta unggah foto unit).
3. **Daftar Service**
   - Pendaftaran keluhan dan jadwal masuk kendaraan (`Id Servis`, pemilihan `No Plat` dan `Id Pelanggan` via dropdown, pengisian `Nama Pelanggan` secara otomatis melalui AJAX lookup, `Keluhan Kendaraan`, dan `Tanggal Servis`).
4. **Data Service**
   - Pencatatan rincian pengerjaan servis (`Id Servis` via dropdown, pemanggilan `Keluhan Kendaraan` secara otomatis, `Estimasi Service`, `Nama Mekanik`, dan `Sparepart Pengganti`).
5. **Pembayaran Service**
   - Rekapitulasi dan pencatatan transaksi kasir (`Id Servis` via dropdown, `Jumlah Biaya Servis`, `Jenis Pembayaran` dengan pilihan radio button *Cash / Tunai* / *Non Tunai*, dan `Keterangan`).
6. **Dashboard & Autentikasi**
   - Ringkasan metrik operasional bengkel secara *real-time*, daftar servis masuk terbaru, serta pemisahan hak akses antara Admin (CRUD penuh) dan Pengguna biasa (lihat data).

---

## Teknologi yang Digunakan

- **Framework Backend:** Laravel (PHP 8.2+)
- **Database:** MySQL
- **Frontend:** Blade Template, Bootstrap 5.3, Custom CSS (`Dark Industrial Theme`), Vanilla JavaScript (AJAX Lookup & Live Table Search)
- **Pengujian API:** Postman
- **Version Control:** Git & GitHub

---

## Panduan Instalasi & Kloning Proyek

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di komputer lokal setelah melakukan kloning dari Git:

### 1. Kloning Repositori
```bash
git clone https://github.com/yaniss-sudo/MotorService.git
cd MotorService
```

### 2. Instalasi Dependensi
```bash
composer install
```

### 3. Konfigurasi Environment & Database
Salin file `.env.example` menjadi `.env`, lalu sesuaikan pengaturan koneksi database MySQL:
```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env` dan atur bagian database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=service_motor
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi Database & Seeder
Pastikan database `service_motor` sudah dibuat di MySQL, lalu jalankan perintah:
```bash
php artisan migrate --seed
```
*(Jika menggunakan penyimpanan foto kendaraan, jalankan juga `php artisan storage:link`)*

### 5. Jalankan Server Lokal
```bash
php artisan serve
```
Akses aplikasi melalui browser di alamat: **`http://127.0.0.1:8000`**

---

## Pengujian REST API (Postman)

Aplikasi menyediakan *endpoint* REST API untuk seluruh modul utama yang dapat diuji melalui Postman menggunakan header `Accept: application/json`:

| Modul | Endpoint Dasar | Metode HTTP |
| :--- | :--- | :--- |
| **Pelanggan** | `/api/pelanggan` | `GET`, `POST`, `PUT`, `DELETE` |
| **Kendaraan** | `/api/kendaraan` | `GET`, `POST`, `PUT`, `DELETE` |
| **Daftar Service** | `/api/daftar-service` | `GET`, `POST`, `PUT`, `DELETE` |
| **Data Service** | `/api/data-service` | `GET`, `POST`, `PUT`, `DELETE` |
| **Pembayaran** | `/api/pembayaran` | `GET`, `POST`, `PUT`, `DELETE` |

### Endpoint Lookup Internal (AJAX)
- `GET /lookup/pelanggan/{id}` — Mengambil data nama lengkap pelanggan berdasarkan ID.
- `GET /lookup/servis/{id}` — Mengambil deskripsi keluhan kendaraan berdasarkan ID servis.

---

## Struktur Direktori Penting

```text
├── app/
│   ├── Http/Controllers/   # Controller Web & API untuk setiap modul
│   └── Models/             # Model Eloquent & relasi antar tabel
├── database/
│   ├── migrations/         # Skema tabel MySQL
│   └── seeders/            # Data awal & akun pengguna
├── public/
│   ├── css/main.css        # Stylesheet utama antarmuka aplikasi
│   └── images/             # Aset gambar latar antarmuka
├── resources/views/
│   ├── auth/               # Halaman Login, Register, & Reset Password
│   ├── layouts/main.blade.php # Kerangka utama aplikasi (Sidebar & Layout)
│   ├── pelanggan/          # View CRUD Data Pelanggan
│   ├── kendaraan/          # View CRUD Data Kendaraan
│   ├── daftar_service/     # View CRUD Daftar Service
│   ├── data_service/       # View CRUD Data Service
│   ├── pembayaran/         # View CRUD Pembayaran Service
│   ├── dashboard.blade.php # Halaman ringkasan operasional
│   └── welcome.blade.php   # Halaman pembuka aplikasi
└── routes/
    ├── web.php             # Rute halaman web & middleware hak akses
    └── api.php             # Rute endpoint REST API
```