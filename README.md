# MentalCare 🧠💚

**MentalCare** adalah aplikasi web platform kesehatan mental berbasis Laravel yang dirancang untuk memudahkan masyarakat dalam melakukan tes psikologis mandiri, membaca artikel edukasi kesehatan mental, serta melakukan pemesanan jadwal konsultasi dengan psikolog profesional.

Proyek tugas akhir mata kuliah **Pengembangan Perangkat Lunak Berbasis Web 2**.
**Politeknik Negeri Madiun**, Program Studi **Teknologi Rekayasa Perangkat Lunak**.

---

## 📌 Daftar Isi
1. [Latar Belakang dan Tujuan](#-latar-belakang-dan-tujuan)
2. [Fitur Utama](#-fitur-utama)
3. [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
4. [Arsitektur & Struktur Folder](#-arsitektur--struktur-folder)
5. [Panduan Instalasi Lokal](#-panduan-instalasi-lokal)
6. [Akun Demo](#-akun-demo)
7. [Peta Halaman (Routes)](#-peta-halaman-routes)
8. [Skema Basis Data](#-skema-basis-data)
9. [Keamanan & Validasi](#-keamanan--validasi)
10. [Pengujian](#-pengujian)
11. [Pemecahan Masalah (FAQ)](#-pemecahan-masalah-faq)
12. [Tim](#-tim)
13. [Lisensi](#-lisensi)


---

## 🎯 Latar Belakang dan Tujuan
Kesadaran akan kesehatan mental kian meningkat, tetapi akses konsultasi dan deteksi dini terjangkau masih terbatas. **MentalCare** dirancang sebagai platform digital terpadu untuk membantu masyarakat melakukan deteksi dini lewat kuis tes psikologis mandiri, mengakses edukasi tepercaya, dan menjadwalkan konsultasi dengan psikolog secara praktis.

---

## ✨ Fitur Utama

### 👤 Pengguna / Pasien
- **Autentikasi & Profil**: Registrasi, login, logout, dan manajemen profil akun.
- **Edukasi & Artikel**: Membaca artikel kesehatan mental dengan pencarian dan filter kategori.
- **Katalog Psikolog**: Mencari psikolog berdasarkan spesialisasi (*Anxiety*, *Burnout*, *Trauma*, dll.), kategori, dan biaya.
- **Pemesanan Konsultasi**: Memilih jadwal konsultasi, metode (Online/Offline), dan konfirmasi pembayaran.
- **Tes Psikologis Mandiri**: Menjawab rangkaian pertanyaan kuis untuk menghitung skor kondisi mental secara otomatis.

### 🛠️ Administrator
- **Dashboard Ringkasan**: Statistik pengguna, psikolog, serta transaksi konsultasi.
- **Kelola Data Psikolog (CRUD)**: Mengolah profil, spesialisasi, foto, biaya, dan jadwal psikolog.
- **Kelola Tes & Pertanyaan**: Membuat instrumen tes psikologi beserta opsi jawaban dan bobot poin.
- **Kelola Artikel & Kategori**: Manajemen artikel edukasi dan kategori pembahasan.
- **Manajemen Pembayaran**: Verifikasi status pembayaran transaksi konsultasi pasien.

---

## 🛠️ Teknologi yang Digunakan

| Lapisan | Teknologi |
| :--- | :--- |
| **Backend** | PHP 8.4, Laravel 12 (Monolith / Blade) |
| **Autentikasi** | Laravel Breeze (Blade) |
| **Frontend** | Blade, Tailwind CSS, Alpine.js (Vite) |
| **Basis Data** | MySQL 8 |
| **Pengujian** | Pest / PHPUnit |

---

## 📂 Arsitektur & Struktur Folder

```text
app/
  Http/Controllers/        Controller publik, pasien, dan Autentikasi
  Http/Controllers/Admin/  Controller khusus panel Admin
  Models/                  Model Eloquent (User, Psikolog, Konsultasi, Artikel, dll.)
database/
  migrations/              Skema migrasi tabel basis data
  seeders/                 Data sampel/riil awal
resources/views/           Tampilan Blade (Auth, Pasien, Admin, Layouts)
routes/
  web.php                  Seluruh rute aplikasi (Publik, Pasien, & Admin)
```

---

## 🚀 Panduan Instalasi Lokal

### Prasyarat
- PHP >= 8.3 / 8.4
- Composer 2.x
- Node.js & NPM
- MySQL Database

### Langkah Instalasi

1. **Klon Repositori**
   ```bash
   git clone https://github.com/Wijdanns/MentalCare-Kelompok5-PBW2
   cd mentalcare
   ```

2. **Install Dependensi PHP & Node**
   ```bash
   composer install
   npm install
   ```

3. **Salin & Konfigurasi Berkas `.env`**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Atur koneksi basis data pada berkas `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pjbl-web2-mentalhealth
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Jalankan Migrasi & Seeder**
   ```bash
   php artisan migrate:fresh --seed
   php artisan storage:link
   ```

5. **Jalankan Server Pengujian**
   Buka terminal terpisah:
   ```bash

   # Terminal  (Laravel)
   php artisan serve
   ```
   Akses aplikasi di peramban via `http://127.0.0.1:8000`.

---

## 🔐 Akun Demo

| Peran | Email | Kata Sandi | Akses |
| --- | --- | --- | --- |
| **Admin** | `admin@gmail.com` | `admin123` | Panel Pengelola Sistem |
| **Pasien** | `test@example.com` | `password` | Layanan Pasien & Tes |

---

## 🗺️ Peta Halaman (Routes)

| Route | Hak Akses | Keterangan |
| --- | --- | --- |
| `/` | Publik | Beranda utama & Informasi platform |
| `/psikolog` | Publik | Katalog daftar psikolog |
| `/psikolog/{id}` | Publik | Detail profil & jadwal psikolog |
| `/artikel` | Publik | Daftar artikel kesehatan mental |
| `/tes-psikologis` | Pasien (Login) | Pelaksanaan tes kesehatan mental |
| `/konsultasi` | Pasien (Login) | Pendaftaran jadwal & riwayat konsultasi |
| `/admin/*` | Admin | Panel khusus admin |

---

## 🗄️ Skema Basis Data

Aplikasi menggunakan 12 tabel utama:

1. `users` — Data akun pasien dan admin
2. `psikolog` — Profil, bidang spesialis, kategori, dan biaya psikolog
3. `jadwal_psikolog` — Ketersediaan jadwal praktek psikolog
4. `konsultasi` — Transaksi pendaftaran konsultasi pasien
5. `pembayaran` — Status dan metode pembayaran transaksi
6. `tes_psikologis` — Master instrumen kuis tes
7. `pertanyaan_psikologis` — Daftar pertanyaan per modul tes
8. `jawaban_psikologis` — Opsi pilihan jawaban & bobot poin
9. `hasil_tes` — Total poin tes akhir milik pengguna
10. `jawaban_user` — Detail riwayat jawaban pengguna per sesi tes
11. `artikel` & `kategori_artikel` — Manajemen materi edukasi
12. `jawaban_psikologis` — Detail jawaban dan poin
13. `sessions`, `cache`, `jobs` — Tabel pendukung bawaan sistem

---

## 🛡️ Keamanan & Validasi

- **Otorisasi**: Pembatasan akses halaman sensitif menggunakan Middleware Role.
- **Integritas Jawaban**: Penerapan `unique constraint` pada tabel `jawaban_user` agar pertanyaan tidak dapat dijawab berulang kali dalam satu sesi.
- **Validasi Input**: Validasi ketat di sisi server untuk pengunggahan berkas dan pendaftaran konsultasi.

---

## 🧪 Pengujian

Untuk menjalankan unit test automatisasi pada aplikasi:

```bash
php artisan test
```


---

## 👥 Tim

| Nama | NIM | Peran |
| --- | --- | --- |
| **Indah Ayu Astuti** | 254311002 | Frontend Developer |
| **Sekar Purwita Asri** | 254311008 | Backend Developer |
| **Lutfilah Ahmad** | 254311020 | Backend Developer |
| **Wijdan Hesa Fausta** | 254311030 | Frontend Developer |

---

## 📄 Lisensi

Proyek ini dikembangkan khusus untuk tugas akademik mata kuliah di **Politeknik Negeri Madiun**.