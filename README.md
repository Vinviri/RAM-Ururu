# RAM-Ururu Inventory System

Aplikasi Manajemen Persediaan Barang (Inventory) berbasis Web untuk Toko RAM Ururu. Dibangun menggunakan framework **Laravel 11** dan **Vite**.

## 🚀 Fitur Utama
- **Dashboard Analitik**: Ringkasan total barang, stok keluar/masuk, barang stok menipis, dan riwayat transaksi terbaru.
- **Master Data**: Kelola Kategori Barang, Daftar Barang, dan Manajemen Pengguna (Admin).
- **Manajemen Persediaan**: Pencatatan Barang Masuk dan Barang Keluar dengan validasi otomatis (stok otomatis bertambah/berkurang).
- **Laporan Transaksi**: Catatan jejak transaksi lengkap dengan fitur Filter Tanggal.
- **Sistem Otentikasi**: Proteksi halaman yang mengharuskan Admin untuk login.

## 📋 Persyaratan Sistem
Sebelum menjalankan aplikasi, pastikan komputer Anda telah menginstal:
- [PHP](https://www.php.net/) (Versi 8.2 atau lebih baru)
- [Composer](https://getcomposer.org/)
- [Node.js & npm](https://nodejs.org/)
- [MySQL/MariaDB](https://www.apachefriends.org/index.html) (Bisa menggunakan XAMPP)

## 🛠️ Tata Cara Instalasi (Clone Repo)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi di komputer lokal Anda:

### 1. Clone Repository
Buka terminal/Command Prompt dan jalankan perintah berikut:
```bash
git clone https://github.com/Vinviri/RAM-Ururu.git
cd RAM-Ururu
```

### 2. Install Dependensi PHP & JavaScript
Unduh semua pustaka (library) yang dibutuhkan oleh Laravel dan Vite:
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
*(Pengguna Windows Command Prompt bisa menggunakan `copy .env.example .env`)*

Lalu hasilkan *Application Key* baru:
```bash
php artisan key:generate
```

### 4. Konfigurasi Database
1. Buka XAMPP dan jalankan modul **Apache** dan **MySQL**.
2. Buka `http://localhost/phpmyadmin` di browser Anda.
3. Buat database baru dengan nama `pembekalan` (atau nama lain sesuai selera).
4. Buka file `.env` di teks editor, lalu ubah bagian database agar sesuai dengan yang baru Anda buat:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pembekalan
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### 5. Membangun Struktur Database
Terdapat dua cara untuk membangun struktur tabel database, yaitu menggunakan **Migrations** atau menggunakan file **.sql**.

**Opsi A: Menggunakan Migrations (Direkomendasikan)**
Jalankan perintah ini untuk membangun struktur tabel secara otomatis dan memasukkan data admin standar (dummy data):
```bash
php artisan migrate --seed
```

**Opsi B: Menggunakan file `.sql`**
Jika Anda sudah memiliki file `.sql` (contoh: `db_ramururu.sql`), Anda bisa mengimpor file tersebut langsung ke phpMyAdmin:
1. Buka `http://localhost/phpmyadmin` di browser.
2. Klik nama database yang telah Anda buat pada langkah ke-4.
3. Klik menu **Import** pada bagian atas layar.
4. Klik tombol **Choose File** lalu pilih file `.sql` Anda (contoh: `db_ramururu.sql`).
5. Scroll ke bawah lalu klik tombol **Import** atau **Go** untuk mengeksekusi file tersebut.

### 6. Build Assets (Tampilan HTML/CSS/JS)
Agar tampilan website terlihat sempurna, *compile* aset desainnya menggunakan perintah:
```bash
npm run build
```

### 7. Jalankan Server Lokal
Nyalakan server internal Laravel dengan perintah:
```bash
php artisan serve
```

### 🎉 Selesai!
Aplikasi sekarang dapat diakses melalui browser di alamat:
**`http://localhost:8000`**

---

## 🔑 Akun Login Default
Gunakan akun ini untuk masuk ke dalam aplikasi pertama kali:
- **Email:** `admin@ramururu.com`
- **Password:** `admin123`