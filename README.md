# Aplikasi Manajemen Inventaris

Aplikasi berbasis web untuk mengelola inventaris barang, transaksi masuk/keluar, dan pelaporan, dibangun menggunakan **Laravel 11**.

## Fitur Utama

### 1. Dashboard

- Ringkasan statistik inventaris.
- Grafik monitoring stok dan transaksi.

### 2. Manajemen Data Master (Master Data)

- **Barang**: Kelola data barang (Nama, Kode, Harga, Stok, Kondisi, dll).
- **Kategori**: Pengelompokan barang (Elektronik, Alat Tulis, dll).
- **Merek**: Manajemen merek barang.
- **Satuan**: Manajemen satuan barang (Pcs, Unit, Rim, dll).
- **Customer**: Data pelanggan.
- **Supplier**: Data pemasok.

### 3. Transaksi

- **Barang Masuk**: Mencatat penerimaan barang dari supplier (menambah stok).
- **Barang Keluar**: Mencatat pengeluaran barang ke customer (mengurangi stok).

### 4. Laporan (Reporting)

- **Laporan Stok**: Memantau posisi stok saat ini. Dilengkapi **Filter Canggih Real-time** (Tanggal, Bulan, Kategori, Lokasi) untuk pencarian data yang akurat.
- **Laporan Barang Masuk**: Riwayat transaksi masuk.
- **Laporan Barang Keluar**: Riwayat transaksi keluar.
- **Laporan Pendapatan**: Analisis keuangan sederhana.
- **Laporan Barang Baru**: Daftar barang yang baru ditambahkan.
- **Ekspor Data**: Mendukung cetak dokumen, ekspor PDF, dan Excel.

### 5. Manajemen Pengguna & Hak Akses (Role-Based Access Control)

Aplikasi memiliki 5 role dengan tingkat akses berbeda:

1.  **Super Admin**: Akses penuh ke seluruh sistem.
2.  **Admin**: Akses manajemen data dan transaksi.
3.  **Employee**: Akses operasional standar.
4.  **Staff**: Akses terbatas (Read-Only untuk Master Data Customer & Supplier, tidak bisa kelola User).
5.  **Pimpinan**: Akses **Monitoring Saja** (Read-Only) untuk melihat data dan laporan, tanpa fitur tambah/edit/hapus.

## Teknologi Teknikal

- **Framework**: Laravel 11 (PHP ^8.2)
- **Database**: MySQL.
- **Frontend**: Blade Templates, jQuery, DataTables (Server-side).
- **Packages Utama**: `yajra/laravel-datatables`.

## Instalasi

Ikuti langkah berikut untuk menjalankan aplikasi di komputer lokal:

### Prasyarat

- PHP >= 8.2
- Composer
- MySQL

### Langkah-langkah

1.  **Clone Repository**

    ```bash
    git clone https://github.com/Dimascndra/AdminLTE-Inventaris.git
    cd Aplikasi-Management-Inventaris
    ```

2.  **Install Dependencies**

    ```bash
    composer install
    ```

3.  **Konfigurasi Environment**
    - Salin file env: `cp .env.example .env`
    - Atur koneksi database di file `.env`:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=nama_database_anda
        DB_USERNAME=root
        DB_PASSWORD=
        ```

4.  **Generate Key**

    ```bash
    php artisan key:generate
    ```

5.  **Migrasi & Seeding Database**
    Jalankan perintah ini untuk membuat tabel dan mengisi data awal (termasuk user default dan 50 data dummy barang):

    ```bash
    php artisan migrate --seed
    ```

6.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Buka `http://localhost:8000` di browser Anda.

## Akun Demo (Default Seeder)

Gunakan akun berikut untuk login:

| Role            | Username      | Password   |
| :-------------- | :------------ | :--------- |
| **Super Admin** | `super_admin` | `12345678` |
| **Admin**       | `admin`       | `12345678` |
| **Employee**    | `ryugen`      | `12345678` |
| **Pimpinan**    | `pimpinan`    | `12345678` |

## Workflow Aplikasi

1.  **Login**: Masuk menggunakan akun sesuai role.
2.  **Setup Data Master**:
    - Admin/Super Admin mengisi data Kategori, Satuan, dan Merek.
    - Admin/Super Admin mendaftarkan Supplier dan Customer.
    - Admin/Super Admin mendaftarkan Barang awal.
3.  **Transaksi**:
    - Stok habis? Lakukan **Transaksi Masuk** dari Supplier.
    - Ada permintaan? Lakukan **Transaksi Keluar** ke Customer.
4.  **Pelaporan**:
    - Pimpinan atau Admin memantau pergerakan stok dan pendapatan melalui menu **Laporan**.

## Catatan Tambahan

- Gunakan `php artisan migrate:refresh --seed` jika ingin mereset ulang seluruh database dan data dummy.
- Untuk generate data barang dummy tambahan (realistic), gunakan: `php artisan db:seed --class=ItemSeeder`.
