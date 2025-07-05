# Zaybela - Toko Online CodeIgniter 4

Proyek ini adalah platform toko online yang dibangun menggunakan [CodeIgniter 4](https://codeigniter.com/). Sistem ini menyediakan beberapa fungsionalitas untuk toko online, termasuk manajemen produk, keranjang belanja, dan sistem transaksi.

## Daftar Isi

- [Fitur](#fitur)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Struktur Proyek](#struktur-proyek)

## Fitur

## **1. Sistem Login**
- Terdapat fitur login untuk mengakses aplikasi.
- Setelah login berhasil, pengguna diarahkan ke halaman home.

---

## **2. Halaman Home**

### **2.1 Struktur Halaman**
Halaman home terdiri dari:
- **Sidebar**: Menu navigasi.
- **Header**: Informasi toko dan kontrol.
- **Content**: Area konten utama.

### **2.2 Sidebar**
Menu yang tersedia:
- Home
- Keranjang
- Produk
- Diskon
- Kategori Produk
- Profil
- FAQ

### **2.3 Header**
Berisi:
- Nama toko
- Tombol untuk menyembunyikan dan menampilkan sidebar
- Notifikasi diskon hari ini
- Informasi profil (foto dan nama)

### **2.4 Content**
Menampilkan produk yang dijual dengan informasi:
- Foto produk
- Nama produk
- Harga
- Tombol beli

---


## **3. Menu Keranjang**

### **3.1 Tabel Informasi Produk**
- Nama produk
- Foto produk
- Jumlah (dapat diatur sesuai keinginan)
- Subtotal
- Tombol hapus dari keranjang

### **3.2 Fitur Keranjang**
- Menampilkan total harga keseluruhan isi keranjang
- Tombol "Perbarui Keranjang"
- Tombol "Kosongkan Keranjang"
- Tombol "Selesai Belanja"

---

## **4. Halaman Checkout**

### **4.1 Proses Checkout**
Ketika klik "Selesai Belanja", diarahkan ke halaman checkout yang berisi:
- Nama user
- Informasi produk
- Form pengisian alamat lengkap
- Pilihan kelurahan
- Pilihan layanan pengantar paket
- Total harga sudah termasuk ongkos kirim
- Tombol "Buat Pesanan"

### **4.2 Setelah Checkout**
- Jika berhasil, produk yang dibeli tersimpan pada menu pesanan.
- Otomatis diarahkan ke halaman home.

---

## **5. Menu Profile**

### **5.1 Header**
- Nama user

### **5.2 Tabel pesanan**
- Fitur pagination
- Fitur search
- Kolom tabel:
  - ID pembelian
  - Waktu pembelian
  - Total bayar
  - Alamat
  - Status
  - Tombol action "Detail"

### **5.3 Detail pesanan**
Ketika tombol "Detail" diklik, muncul informasi:
- Nama produk
- Foto produk
- Harga
- Total bayar
- Ongkos kirim

---

## **6. Halaman Produk**

### **6.1 Menu Utama**
- Tombol "Tambah Data"
- Tombol "Download Data"
- Fitur search

### **6.2 Tabel Produk**
- Nama produk
- Harga
- Jumlah produk
- Tombol aksi: "Ubah" dan "Hapus"
- Pagination

### **6.3 Fitur Ubah Produk**
Ketika tombol "Ubah" diklik:
- Form edit data produk: nama, harga, jumlah
- Opsi mengganti foto produk (harus centang checkbox terlebih dahulu)
- Tombol "Simpan" untuk menyimpan perubahan
- Tombol "Batal" jika tidak jadi edit

### **6.4 Fitur Hapus Produk**
Ketika tombol "Hapus" diklik:
- Muncul validasi konfirmasi penghapusan

---

## **7. Menu Diskon**

### **7.1 Menu Utama**
- Tombol "Tambah Diskon"
- Fitur search
- Pagination

### **7.2 Tabel Diskon**
- Nomor
- Tanggal
- Nominal
- Tombol action: "Edit" dan "Hapus"

### **7.3 Fitur Tambah Diskon**
Ketika tombol "Tambah Diskon" diklik:
- Muncul modal input tanggal dan nominal
- Jika memilih tanggal yang belum ada di tabel, data bisa disimpan
- Jika tanggal sudah ada di tabel, data tidak bisa disimpan

### **7.4 Fitur Edit Diskon**
Ketika tombol "Edit" diklik:
- Muncul modal edit tanggal dan nominal
- Jika memilih tanggal yang belum ada di tabel, data bisa disimpan
- Jika tanggal sudah ada di tabel, data tidak bisa disimpan

### **7.5 Fitur Hapus Diskon**
Ketika tombol "Hapus" diklik:
- Muncul modal konfirmasi penghapusan
- Pilihan "Ya" atau "Tidak"

---

## **8. Halaman Kategori Produk**

### **8.1 Menu Utama**
- Tombol "Tambah Data"
- Fitur search

### **8.2 Tabel Kategori**
- Nama kategori
- Tanggal dibuat
- Terakhir diubah
- Tombol aksi: "Ubah" dan "Hapus"
- Pagination

### **8.3 Fitur Ubah Kategori**
Ketika tombol "Ubah" diklik:
- Form edit nama kategori
- Tombol "Simpan" (ketika berhasil simpan, "Terakhir diubah" akan berubah)

### **8.4 Fitur Hapus Kategori**
Ketika tombol "Hapus" diklik:
- Muncul validasi konfirmasi penghapusan

---


## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Web server (Laragon)

## Instalasi

1. **Clone repository ini**
   ```bash
   git clone https://github.com/RestuArdiannsyah/belajar-ci-tugas.git
   cd belajar-ci-tugas
   ```
2. **Install dependensi**
   ```bash
   composer install
   ```
3. **Konfigurasi database**

   - Start module Apache dan MySQL pada XAMPP
   - Buat database **db_ci4** di phpmyadmin.
   - copy file .env dari tutorial https://www.notion.so/april-ns/Codeigniter4-Migration-dan-Seeding-045ffe5f44904e5c88633b2deae724d2

4. **Jalankan migrasi database**
   ```bash
   php spark migrate
   ```
5. **Seeder data**
   ```bash
   php spark db:seed ProductSeeder
   ```
   ```bash
   php spark db:seed UserSeeder
   ```
   ```bash
   php spark db:seed CategorySeeder
   ```
   ```bash
   php spark db:seed DiskonSeeder
   ```

6. **Jalankan server**
   ```bash
   php spark serve
   ```
7. **Akses aplikasi**
   Buka browser dan akses `http://localhost:8080` untuk melihat aplikasi.

## Struktur Proyek

Proyek menggunakan struktur MVC CodeIgniter 4:

- app/Controllers - Logika aplikasi dan penanganan request
  - AuthController.php - Autentikasi pengguna
  - ProdukController.php - Manajemen produk
  - TransaksiController.php - Proses transaksi
  - DiskonController.php - Manajemen diskon
  - KategoriController.php - Manajemen kategori produk
  - ApiController.php - Manajement detail transaksi pada dashboard
- app/Models - Model untuk interaksi database
  - ProductModel.php - Model produk
  - UserModel.php - Model pengguna
  - KategoriModel.php - Model Kategori Produk
  - TransactionModel.php - Model Transaksi
  - TransactionDetailModel.php - Model Detail Transaksi
- app/Views - Template dan komponen UI
  - v_produk.php - Tampilan produk
  - v_keranjang.php - Halaman keranjang
  - v_checkout.php - Halaman Checkout
  - v_diskon.php - Halaman diskon
  - v_faq.php - halaman faq
  - v_home.php - halaman beranda
  - v_kategori.php - halaman kategori
  - v_login.php - halaman login
  - v_profile.php - berisi pesanan yang user beli
  - v_produkPDF.php - format layout pdf data produk yang di download
- public/img - Gambar produk dan aset
- public/NiceAdmin - Template admin
