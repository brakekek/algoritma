# Website Materi Algoritma dan Dasar Pemrograman (Laravel 12)

Starter source untuk satu mata kuliah. Mahasiswa tidak perlu login; dashboard admin dosen dilindungi login Laravel.
Materi disimpan di disk `local` (private), bukan `public`.

## Fitur
- Halaman publik menampilkan hanya pertemuan berstatus Open.
- Admin login, membuat/mengedit/menghapus pertemuan.
- Upload banyak file per pertemuan, unduh melalui controller yang memeriksa status pertemuan.
- Open/Hide per pertemuan.
- Validasi tipe file dan ukuran upload.
- CSRF untuk formulir dan middleware `auth` pada semua rute admin.

## Tampilan
Seluruh gaya ada di `resources/views/layouts/course.blade.php` (CSS inline, tanpa Vite/npm). Font Plus Jakarta Sans dan JetBrains Mono dimuat dari Google Fonts; jika offline, otomatis memakai font sistem. Badge tipe file dibuat oleh `resources/views/partials/file-badge.blade.php`.

## Persyaratan
- PHP 8.2+ (sesuaikan dengan versi Laravel 12 yang dipakai), Composer
- Laravel 12, MySQL/MariaDB atau SQLite
- Ekstensi PHP fileinfo, mbstring, openssl, PDO

## Instalasi
1. Buat proyek Laravel:
   ```bash
   composer create-project laravel/laravel algoritma-dasar-pemrograman "^12.0"
   cd algoritma-dasar-pemrograman
   ```
2. Ekstrak ZIP ini. Salin isi folder `app/`, `database/`, `resources/`, dan `routes/` ke proyek Laravel, gabungkan direktori yang sama.
3. Atur `.env` untuk database, lalu jalankan:
   ```bash
   php artisan key:generate
   php artisan migrate
   ```
4. Buat akun admin menggunakan Tinker:
   ```bash
   php artisan tinker
   ```
   Lalu jalankan:
   ```php
   \App\Models\User::create([
       'name' => 'Dosen',
       'email' => 'dosen@example.com',
       'password' => \Illuminate\Support\Facades\Hash::make('GantiPasswordKuat123!')
   ]);
   ```
   Keluar dari Tinker dengan `exit`.
5. Jalankan:
   ```bash
   php artisan serve
   ```
6. Buka `http://127.0.0.1:8000/admin/login` dan masuk dengan akun di atas.
7. Halaman publik: `http://127.0.0.1:8000/`.

## Catatan autentikasi
Rute admin menggunakan middleware `auth` Laravel. Halaman login sederhana disertakan di `resources/views/admin/login.blade.php`; controller menggunakan `Auth::attempt`.
Untuk proyek baru, pastikan model `User` bawaan Laravel memiliki `$fillable = ['name', 'email', 'password']` dan casts password hashed seperti standar Laravel 12.

## Storage privat
File disimpan ke disk `local` di `storage/app/private/course-materials`. Jangan membuat symlink publik untuk folder ini. File hanya dikirim melalui endpoint `/materi/{material}/download`, yang memeriksa status Open.

## Produksi
- Gunakan HTTPS.
- Ubah password contoh dan jangan gunakan akun contoh di produksi.
- Set `APP_DEBUG=false`.
- Batasi akses `/admin` bila memungkinkan (VPN/IP allowlist atau proteksi tambahan).
- Terapkan backup database dan storage.
- Upload dibatasi 20 MB per file. Sesuaikan `upload_max_filesize` dan `post_max_size` PHP jika diperlukan.
