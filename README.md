# 📦 SITTA — Sistem Informasi Tracking & Transaksi Akademik

SITTA adalah aplikasi berbasis **Laravel 11** dengan integrasi **Vite**, **TailwindCSS**, dan **Flowbite** untuk menampilkan data bahan ajar, tracking pengiriman, serta pengelolaan data lokal menggunakan `store.js` dan `data.js`.

---

## 🚀 Fitur Utama

✅ **Autentikasi Lokal**
- Sistem login/logout berbasis `localStorage`
- Middleware Laravel untuk proteksi halaman

✅ **Manajemen Bahan Ajar**
- Tabel interaktif (Flowbite Table)
- Fitur pencarian, detail, edit, hapus (semua berbasis JS)
- Data tersimpan di `localStorage` (offline-ready)

✅ **Tracking Pengiriman**
- Form pelacakan berdasarkan Nomor DO
- Menampilkan detail dan riwayat perjalanan pengiriman
- Tampilan elegan dengan card dan timeline

✅ **Integrasi Frontend Modern**
- Menggunakan **Vite** untuk bundling aset
- Styling dengan **TailwindCSS + Flowbite**
- Komponen UI responsif dan ringan

---

## 🧰 Persyaratan Sistem

Pastikan kamu sudah menginstal:
- PHP >= 8.2
- Composer
- Node.js >= 18
- NPM atau Yarn
- Database (opsional jika hanya uji localStorage)
- Laragon / XAMPP (opsional)

---

## ⚙️ Langkah Instalasi

### 1️⃣ Clone Repository
```bash
git clone https://github.com/username/sitta.git
cd sitta
```

### 2️⃣ Install Dependency Laravel
```bash
composer install
```

### 3️⃣ Install Dependency Frontend
```bash
npm install
```

### 4️⃣ Konfigurasi Environment
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Lalu ubah konfigurasi sesuai kebutuhan:
```env
APP_NAME="SITTA"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://praktik-web.test
```

Generate app key:
```bash
php artisan key:generate
```

### 5️⃣ Jalankan Vite dan Server Laravel
Buka dua terminal terpisah:

**Terminal 1:**
```bash
npm run dev
```

**Terminal 2:**
```bash
php artisan serve
```

Atau jika menggunakan Laragon, cukup buka:
```
http://praktik-web.test
```

---

## 🧩 Struktur Proyek

```
├── app/
├── public/
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   ├── app.js         # Entry utama Vite
│   │   ├── data.js        # Data dummy bahan ajar & tracking
│   │   └── store.js       # Fungsi CRUD localStorage & autentikasi
│   ├── views/
│   │   ├── layouts/
│   │   │   └── main.blade.php
│   │   ├── login.blade.php
│   │   ├── bahan-ajar.blade.php
│   │   └── tracking-pengiriman.blade.php
├── routes/
│   └── web.php
├── package.json
├── vite.config.js
└── README.md
```

---

## 🧠 Cara Kerja

- Semua data awal (`dataBahanAjar`, `dataTracking`) dimuat dari `data.js`
- Saat aplikasi pertama kali dijalankan, `store.js` akan **menginisialisasi localStorage**
- Semua aksi CRUD (insert, update, delete) pada bahan ajar dilakukan di `store.js`
- Autentikasi (login/logout) juga tersimpan di `localStorage`
- Middleware Laravel tetap digunakan untuk membatasi akses route (`AuthCheck`)

---

## 💡 Catatan

> Jika tampilan tabel tidak muncul atau gaya Flowbite tidak ter-load:
> - Pastikan `import 'flowbite';` sudah ada di `resources/js/app.js`
> - Jalankan ulang perintah `npm run dev`
> - Bersihkan cache browser (`Ctrl + Shift + R`)

---

Selamat mencoba dan semoga bermanfaat! ✨