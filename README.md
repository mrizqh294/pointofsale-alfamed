# Sistem Informasi Apotek Alfamed

Sistem Informasi Apotek Alfamed merupakan aplikasi berbasis web yang dikembangkan untuk membantu proses **penjualan obat, pengelolaan stok, pengelolaan data obat, serta pencatatan transaksi** pada Apotek Alfamed.

Aplikasi ini dirancang untuk mempermudah pengelolaan operasional apotek dan mengurangi proses pencatatan secara manual sehingga data dapat dikelola dengan lebih terstruktur dan efisien.

## Fitur Utama

### Manajemen Obat
- Menambahkan data obat
- Mengubah data obat
- Menghapus data obat
- Melihat daftar obat
- Mengelola kategori obat
- Mengelola satuan obat
- Mengelola harga obat
- Menampilkan stok obat

### Pengelolaan Stok
- Pencatatan stok obat
- Penambahan stok
- Pengurangan stok berdasarkan transaksi
- Monitoring ketersediaan obat
- Peringatan stok obat yang menipis

### Penjualan
- Membuat transaksi penjualan
- Menambahkan obat ke dalam transaksi
- Menghitung total transaksi secara otomatis
- Mengelola detail transaksi


### Manajemen Pengguna

Sistem memiliki beberapa hak akses pengguna untuk membatasi fitur berdasarkan peran:

- **Admin** — mengelola data dan operasional sistem
- **Kasir** — melakukan transaksi penjualan
- **Pemilik** — melihat informasi dan laporan yang diperlukan

### Laporan
- Laporan penjualan
- Laporan transaksi
- Laporan stok obat
- Export data ke Excel

## Teknologi yang Digunakan

Project ini dikembangkan menggunakan teknologi berikut:

| Teknologi | Penggunaan |
|---|---|
| **Laravel** | Backend dan application framework |
| **PHP** | Bahasa pemrograman backend |
| **MySQL** | Database |
| **Vite** | Asset bundling dan development server |
| **Tailwind CSS** | Styling dan UI |
| **JavaScript** | Interaksi pada sisi frontend |
| **Blade** | Template engine Laravel |

## Arsitektur Sistem

Secara umum, aplikasi menggunakan arsitektur Laravel dengan alur:

```text
User
 │
 ▼
Web Browser
 │
 ▼
Laravel
 ├── Routes
 ├── Controllers
 ├── Models
 ├── Services
 └── Views (Blade)
 │
 ▼
MySQL Database
```

Frontend menggunakan **Blade + Tailwind CSS**, sedangkan **Vite** digunakan untuk mengelola asset dan proses development frontend.

## Struktur Project

Struktur utama project secara umum:

```text
PointOfSales-Alfamed/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Requests/
│   ├── Models/
│   └── ...
│
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
│
├── public/
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/
│   ├── web.php
│   └── ...
│
├── storage/
│
├── tests/
│
├── .env.example
├── artisan
├── composer.json
├── package.json
└── vite.config.js
```
# Tujuan Pengembangan

Sistem ini dikembangkan untuk:

- Mempermudah proses transaksi penjualan obat.
- Membantu pengelolaan stok obat.
- Mengurangi pencatatan transaksi secara manual.
- Meminimalkan kesalahan dalam pencatatan data.
- Mempermudah pencarian data obat.
- Membantu pemilik dalam memperoleh informasi penjualan dan stok.
- Meningkatkan efisiensi operasional apotek.

## Pengujian

Pengujian sistem dilakukan menggunakan beberapa metode, antara lain:

- **Black Box Testing** untuk menguji fungsi-fungsi utama sistem.
- **User Acceptance Test (UAT)** untuk mengetahui tingkat penerimaan pengguna terhadap sistem.

## Status Project

**Status:** Completed / Final Project

Project ini dikembangkan sebagai sistem informasi penjualan dan pengelolaan stok obat untuk **Apotek Alfamed, Ciater, Subang**.

## Author

**Muhammad Rizki Haikal**

Mahasiswa Teknik Informatika  
Universitas Pasundan

### Contact

- GitHub: [@mrizqh294](https://github.com/mrizqh294)

---

