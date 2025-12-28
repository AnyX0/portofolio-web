# 🚀 Next Steps: Create Project dengan Upload Gambar

## Status: ✅ Login Berhasil!

Sekarang kita test:
1. Create project baru
2. Upload gambar ke Cloudinary
3. Verify gambar tampil di public pages

---

## 📋 Step 1: Request "2. Create Project (via Laravel + Cloudinary)"

### A. Fill Form Data
Di Postman, pilih request: **"2. Create Project (via Laravel + Cloudinary)"**

Tab **Body** - Ubah values:
```
title: Website Portfolio Modern
summary: Portfolio website dengan design modern dan responsive
description: Website portfolio yang menampilkan semua project dengan design clean dan animasi smooth
tech_stack: Laravel 12, Tailwind CSS v4, MySQL, Cloudinary
live_url: https://portfolio.example.com
repo_url: https://github.com/andi/portfolio
is_published: on
cover_image: [SELECT FILE]
```

### B. Select Gambar
```
Body tab → cover_image field
Click: SELECT FILE
Pilih gambar dari komputer (JPG, PNG, WebP - max 5MB)
```

### C. Send Request
```
Click: SEND
Tunggu response...
```

---

## ✅ Step 2: Check Response

### Success Response (Status 302):
```
Status: 302 Redirect
Headers: location: http://localhost:8000/console/dashboard
Body: Kosong (atau redirect page)
```

**Artinya**: Project berhasil dibuat + gambar uploaded ke Cloudinary! ✓

### Jika Error (Status 419):
```
Kemungkinan: Session expired
Solusi: Login ulang (run "Get CSRF Token" + "Login")
```

### Jika Error (Status 422):
```
Kemungkinan: Validation error
Check: title, summary harus ada
Check: gambar harus JPG/PNG/WebP, max 5MB
```

---

## 🖼️ Step 3: Verify Gambar Tampil

### Via Browser:

**1. Buka Homepage**:
```
http://localhost:8000/
```

**Expected**: 
- ✓ Muncul kartu project baru
- ✓ Gambar tampil di kartu
- ✓ Title, summary, tech stack tampil

**2. Click Project Card**:
```
Buka detail: http://localhost:8000/project/website-portfolio
(slug disesuaikan)
```

**Expected**:
- ✓ Gambar besar tampil
- ✓ Smooth fade animation saat hover
- ✓ Project details tampil (title, summary, tech stack)

**3. Check Gambar URL**:
```
Right-click gambar → Inspect Element
Cari <img> tag
src attribute harus:
- https://res.cloudinary.com/dducuhzso/... ← CLOUDINARY ✓
atau
- http://localhost:8000/storage/covers/... ← LOCAL FALLBACK ✓
```

---

## 🔍 Via Postman: Check Cloudinary Folder

### Request "4. Get All Projects":
```
Send request
Response: JSON dengan semua projects
```

**Cari:**
```json
{
  "id": 1,
  "title": "Website Portfolio Modern",
  "slug": "website-portfolio",
  "cloudinary_folder": "portfolio/projects/website-portfolio",
  "is_published": true,
  ...
}
```

**Verify**: 
- ✓ `cloudinary_folder` ada dan berisi `portfolio/projects/{slug}`
- ✓ Project published

---

## 🌐 Via Cloudinary Dashboard:

1. Buka: https://cloudinary.com/console/
2. Login dengan credentials Anda
3. Dashboard → Media Library
4. Folder: `portfolio/projects/website-portfolio/`
5. **Harus muncul gambar yang di-upload!** ✓

---

## 📊 Summary Test

| Step | Action | Expected Result | Status |
|------|--------|-----------------|--------|
| 1 | Login | Status 302 | ✅ Done |
| 2 | Create Project + Upload | Status 302 | ⏳ Todo |
| 3 | Homepage | Gambar tampil | ⏳ Todo |
| 4 | Project Detail | Gambar + fade animation | ⏳ Todo |
| 5 | Cloudinary Dashboard | Folder + gambar | ⏳ Todo |

---

## 🎯 Jika Gambar Tidak Tampil

### Check 1: Cloudinary Folder
```
Via Dashboard atau Postman GET Projects
cloudinary_folder harus ada value: "portfolio/projects/website-portfolio"
```

### Check 2: Server Logs
```
Terminal (Laravel):
php artisan tail
```

**Cari error**:
```
- Cloudinary API error
- File not found
- Network timeout
```

### Check 3: Local Fallback
```
Jika gambar URL lokal (/storage/covers/...)
Cek folder: storage/app/public/covers/
File harus ada di situ
```

### Check 4: Storage Symlink
```
Folder public/storage harus exist:
ls -l public/storage

Jika tidak ada:
php artisan storage:link
```

---

## 💡 Troubleshooting Quick Links

| Issue | Solution |
|-------|----------|
| Gambar not found | Check cloudinary_folder di DB, Check Cloudinary Dashboard |
| Local fallback only | Verify CLOUDINARY_* di .env, Run `php artisan config:clear` |
| Upload timeout | File terlalu besar? Max 5MB |
| 419 Error | Session expired, Login ulang |
| 422 Error | Validation error, check form fields |

---

## 🎉 Next After Success

Setelah berhasil:
1. ✅ Test create 2-3 project lebih
2. ✅ Upload gambar berbeda
3. ✅ Test update project (edit + upload gambar baru)
4. ✅ Test delete project
5. ✅ Try direct Cloudinary upload (Request 6)

---

## 📝 Test Checklist

- [ ] Create Project request sent
- [ ] Response status 302 (redirect)
- [ ] Homepage: Project card muncul
- [ ] Homepage: Gambar tampil dengan smooth fade
- [ ] Project Detail: Gambar besar tampil
- [ ] Inspect element: URL dari Cloudinary ✓
- [ ] Cloudinary Dashboard: Folder + gambar ada ✓

---

**Go ahead dan test Create Project sekarang!** 🚀
