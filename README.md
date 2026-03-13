# 🕌 Dashboard Masjid

Aplikasi website berbasis sistem informasi untuk memonitoring keuangan dan trafik masjid. Dashboard ini dirancang untuk memudahkan pengurus dalam mengelola data operasional secara transparan dan efisien.

## ✨ Fitur Utama
* **Monitoring Keuangan:** Pencatatan arus Keuangan (pemasukan dan pengeluaran) operasional masjid.
* **Keamanan Data:** Sistem ini **tidak** menyimpan data finansial sensitif pribadi (seperti informasi kartu kredit, PIN, atau data ATM), melainkan murni berfokus pada rekapitulasi keuangan masjid.
* **Dashboard Interaktif:** Visualisasi data yang mudah dibaca oleh pengurus.

## 🛠️ Teknologi yang Digunakan
* **Bahasa Pemrograman:** PHP
* **Database:** MySQL
* **Environment:** Laragon (Local Development)

## 🚀 Cara Instalasi (Localhost)

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal:

1. **Clone Repository**
   Buka terminal/Git Bash dan jalankan perintah:
   ```bash
   git clone [https://github.com/username-kamu/Dashboard-Masjid.git](https://github.com/username-kamu/Dashboard-Masjid.git)

2. Masuk ke Direktori Project
    cd Dashboard-Masjid

3. Konfigurasi Database
    - Buka aplikasi Laragon, nyalakan Apache dan MySQL.
    - Buat database baru di MySQL (misalnya: db_masjid).
    - Copy file .env.example dan ubah namanya menjadi .env.
    - Buka file .env dan sesuaikan nama database, username (biasanya root), dan password (kosongkan jika default Laragon).

4. Jalankan Aplikasi
Akses project melalui browser sesuai dengan konfigurasi Laragon kamu (contoh: http://dashboard-masjid.test atau http://localhost/dashboard-masjid).
