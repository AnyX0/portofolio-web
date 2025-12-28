# Cloudinary Setup Guide

## Overview
Proyek ini menggunakan **Cloudinary** untuk mengelola dan menyimpan gambar cover project secara cloud. Aplikasi fallback otomatis ke penyimpanan lokal jika upload gagal.

## 1. Dapatkan Credentials Cloudinary

1. Daftar di [cloudinary.com](https://cloudinary.com)
2. Pergi ke **Dashboard** untuk melihat:
   - **Cloud Name**
   - **API Key**
   - **API Secret**
3. (Opsional) Buat **Upload Preset** untuk unsigned uploads:
   - Dashboard → Settings → Upload
   - Buat preset baru, copy nama preset-nya

## 2. Konfigurasi Environment

Edit file `.env` di root project:

```env
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
CLOUDINARY_UPLOAD_PRESET=your_upload_preset  # Opsional
```

### Contoh:
```env
CLOUDINARY_CLOUD_NAME=demo123
CLOUDINARY_API_KEY=456789012345
CLOUDINARY_API_SECRET=abcdef_ghij_klmno
CLOUDINARY_UPLOAD_PRESET=portfolio  # Jika menggunakan unsigned uploads
```

## 3. Reload Configuration

Jalankan:
```bash
php artisan config:clear
php artisan config:cache
```

## 4. Memahami Upload Flow

### Normal Flow (Dengan Internet)
1. Admin form submit dengan file gambar
2. `CloudinaryUploader` mengirim gambar ke API Cloudinary
3. Cloudinary merespons dengan `secure_url` (HTTPS CDN URL)
4. URL disimpan ke database di field `cover_path`

### Fallback Flow (Jika Cloudinary Gagal)
1. Upload ke Cloudinary gagal (timeout, 403, koneksi error, dll)
2. Aplikasi otomatis menyimpan gambar lokal ke `storage/app/public/covers`
3. URL lokal disimpan ke database
4. Admin melihat pesan warning amber di form: "Upload ke Cloudinary gagal; gambar disimpan lokal."
5. Gambar tetap tampil di public pages

## 5. Testing via Browser

1. Jalankan server:
   ```bash
   php artisan serve
   npm run dev  # Di terminal lain
   ```

2. Akses admin: `http://localhost:8000/console/access`
   - Email: `admin@portfolio.test`
   - Password: `admin12345`

3. Create/Edit Project:
   - Klik "Buat Project Baru" atau edit existing
   - Upload gambar via file input
   - Lihat apakah gambar tampil di `/` atau `/project/{slug}`

4. Verifikasi URL:
   - Klik kanan gambar → "Open Image in New Tab"
   - URL Cloudinary: `https://res.cloudinary.com/...`
   - URL Local: `http://localhost:8000/storage/covers/...`

## 6. Testing via Postman

1. Import `docs/postman/ProjectUAS.postman_collection.json`
2. Atur environment variables:
   - `baseUrl`: `http://localhost:8000`
   - `adminEmail`: `admin@portfolio.test`
   - `adminPassword`: `admin12345`

3. Request "Create Project (with cover_image)":
   - Tab Body → form-data
   - Kolom `cover_image`: Select file
   - Klik Send
   - Response berisi project dengan `cover_path` (Cloudinary atau lokal)

## 7. Troubleshooting

### Upload Always Falls Back to Local
- ✅ Normal jika setup env belum sempurna atau credentials invalid
- Check logs: `tail -f storage/logs/laravel.log` untuk error details
- Verifikasi credentials di `.env` Match dengan Dashboard Cloudinary

### "Upload Preset Not Found" (403)
- Pastikan `CLOUDINARY_UPLOAD_PRESET` di `.env` sesuai dengan nama preset di Cloudinary Dashboard
- Atau hapus env var jika tidak perlu (fallback ke signed auth)

### Gambar Tidak Muncul di Public Pages
- Cek field `cover_path` di database:
  ```bash
  sqlite3 database/database.sqlite "SELECT id, title, cover_path FROM projects LIMIT 3;"
  ```
- Jika URL lokal:
  - Pastikan symlink aktif: `php artisan storage:link` (jika belum)
  - Verifikasi folder `storage/app/public/covers` ada
- Jika URL Cloudinary:
  - Akses URL langsung di browser untuk test

### CORS Error (Jika Ada)
- Tidak relevan; upload dilakukan server-side (bukan browser)
- Jika ada error JavaScript di browser console, abaikan image upload bukan penyebabnya

## 8. Production Checklist

- [ ] `.env` di server memiliki Cloudinary credentials yang benar
- [ ] `php artisan config:cache` sudah dijalankan di server
- [ ] Storage symlink aktif: `php artisan storage:link`
- [ ] Folder `storage/app/public/covers` writable oleh web server
- [ ] Cloudinary API Key aman (jangan commit ke git)
- [ ] Test upload dengan gambar kecil dulu (~500KB)

## 9. API Reference

### CloudinaryUploader Service
**Lokasi**: `app/Services/CloudinaryUploader.php`

**Method**:
```php
public function upload(UploadedFile $file): ?string
```

**Parameter**:
- `$file`: `Illuminate\Http\UploadedFile` object dari request

**Return**:
- `string`: Secure URL dari Cloudinary jika berhasil
- `null`: Jika gagal (controller akan trigger fallback)

**Contoh**:
```php
$uploader = new CloudinaryUploader();
$url = $uploader->upload($request->file('cover_image'));
if ($url) {
    // Simpan $url ke database
} else {
    // Fallback ke local storage
}
```

## 10. Catatan Penting

- **Cloudinary Free Plan**: 25 juta transformasi/bulan, unlimited storage, full API access
- **Fallback Lokal**: Tidak mengurangi reliability; gambar selalu tampil
- **CDN Benefits**: Cloudinary menggunakan CDN global untuk kecepatan loading optimal
- **Transformations**: Bisa menambah width/height/crop parameters ke URL di `resources/views/portfolio/` jika perlu optimization

---

Selamat! Portfolio Anda sekarang menggunakan cloud image hosting yang powerful dan reliable. 🚀
