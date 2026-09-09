# ☕ Planova — Sistem Reservasi Cafe

![Laravel](https://img.shields.io/badge/Laravel-9.x-red?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-blue?logo=php)

**Planova** adalah aplikasi web **reservasi cafe** yang memudahkan pengguna mencari cafe, melihat menu, dan memesan tempat secara online. Aplikasi ini juga dilengkapi **panel admin** untuk mengelola cafe, menu, dan reservasi.

## ✨ Fitur

### 👤 Pengguna (User)
- 🔍 Melihat daftar cafe dan detail menu
- 📅 Membuat, melihat, mengubah, dan membatalkan reservasi
- 🔐 Registrasi, login, dan kelola profil

### 🛠️ Admin
- 🏪 Kelola **cafe** (CRUD + hapus massal)
- 🍽️ Kelola **menu** tiap cafe (CRUD)
- 📋 Kelola **reservasi** & ubah status (pending/confirmed/cancelled)

## 🧱 Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Framework | Laravel 9.x |
| Bahasa | PHP 8.0+ |
| Templating | Blade |
| Database | MySQL |
| Autentikasi | Laravel Breeze + Sanctum |

## 🛠️ Kebutuhan

- **PHP** ≥ 8.0.2 (dengan ekstensi: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)
- **Composer**
- **MySQL**

## 🚀 Cara Instalasi

```bash
# 1. Clone repository
git clone https://github.com/hiffero/planova.git
cd planova

# 2. Install dependency
composer install

# 3. Salin file environment
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Konfigurasi database di file .env
#    DB_DATABASE=planova
#    DB_USERNAME=root
#    DB_PASSWORD=

# 6. Jalankan migrasi & seeder
php artisan migrate --seed

# 7. Jalankan server
php artisan serve
```

Buka **http://localhost:8000** di browser.

## 📁 Struktur Utama

```
app/
├── Models/
│   ├── Cafe.php            # Model cafe
│   ├── Menu.php            # Model menu (milik cafe)
│   ├── Reservation.php     # Model reservasi (milik user & cafe)
│   └── User.php            # Model user
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Controller khusus admin
│   │   ├── Auth/           # Autentikasi (Breeze)
│   │   ├── HomeController.php
│   │   ├── ProfileController.php
│   │   └── ReservationController.php
│   └── Middleware/
│       └── AdminMiddleware.php   # Proteksi role admin
├── database/
│   ├── migrations/
│   └── seeders/
└── routes/web.php
```

## 🔗 Relasi Database

```
Cafe 1 ──── * Menu
Cafe 1 ──── * Reservation
User 1 ──── * Reservation
```

## 🎯 Role & Akses

| Role | Akses |
|------|-------|
| **User** | Reservasi, profil |
| **Admin** | Kelola cafe, menu, reservasi (prefix `/admin`) |

> Admin dilindungi oleh `AdminMiddleware` — akses panel admin di `/admin`.

## 👤 Author

- **Feronika Liana** — [@hiffero](https://github.com/hiffero)

## 📄 Lisensi

Proyek ini dibuat untuk keperluan pembelajaran. Silakan gunakan & kembangkan.
