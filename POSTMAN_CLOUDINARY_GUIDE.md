# 📮 Postman Guide untuk Cloudinary

## Setup Awal

### 1. Import Collection
1. Buka Postman
2. Click **Import** (top-left)
3. Choose file: `docs/postman/ProjectUAS.postman_collection.json`
4. Click **Import**

### 2. Create Environment
1. Klik **Environments** (left sidebar)
2. Click **Create Environment** → **Blank environment**
3. Nama: `Cloudinary Dev`
4. Tambah variables berikut:

```json
{
  "baseUrl": "http://localhost:8000",
  "adminEmail": "admin@portfolio.test",
  "adminPassword": "admin12345",
  "cloudinaryCloudName": "dducuhzso",
  "cloudinaryApiKey": "381236954385957",
  "cloudinaryApiSecret": "LCPFjOjbNw_mKUeIfY5uNY8b_8Q",
  "projectId": 1,
  "projectSlug": "website-portfolio"
}
```

5. Click **Save**

### 3. Select Environment
1. Top-right, dropdown environment
2. Select: **Cloudinary Dev**
3. Sekarang variabel tersedia untuk semua request

---

## API Endpoints

### A. Admin Authentication

#### 1. Login (Admin)
```
POST {{baseUrl}}/console/access
Body (form-urlencoded):
  - email: {{adminEmail}}
  - password: {{adminPassword}}
  - remember: 1 (optional)
```

**Response**: Session cookie disimpan otomatis

### B. Project Management (Authenticated)

#### 2. Get All Projects
```
GET {{baseUrl}}/api/projects
```

**Response**: JSON list semua projects (published)

#### 3. Create Project (dengan upload gambar)
```
POST {{baseUrl}}/console/projects
Body (form-data):
  - title: Website Portfolio
  - summary: Portfolio website modern dengan Laravel
  - description: Deskripsi lengkap...
  - tech_stack: Laravel, Tailwind, Vue
  - live_url: https://example.com
  - repo_url: https://github.com/...
  - cover_image: [SELECT FILE]
  - is_published: on
```

**Response**: Redirect ke dashboard, atau JSON jika API route

#### 4. Update Project
```
POST {{baseUrl}}/console/projects/{{projectId}}
Body (form-data):
  - _method: PUT
  - title: Nama project update
  - summary: Summary baru
  - description: Deskripsi baru
  - tech_stack: Stack baru
  - cover_image: [SELECT FILE atau kosongkan]
  - is_published: on
```

#### 5. Delete Project
```
DELETE {{baseUrl}}/console/projects/{{projectId}}
```

### C. Direct Cloudinary Upload (Advanced)

#### 6. Upload Langsung ke Cloudinary
```
POST https://api.cloudinary.com/v1_1/{{cloudinaryCloudName}}/image/upload
Body (form-data):
  - file: [SELECT FILE]
  - api_key: {{cloudinaryApiKey}}
  - timestamp: [Generated]
  - signature: [Generated dengan API Secret]
  - folder: portfolio/projects/nama-project
  - upload_preset: (opsional jika tidak menggunakan signed)
```

---

## Step-by-Step Testing

### Scenario 1: Create Project via Laravel Admin Panel

**Langkah 1**: Login
1. Pilih request: **Login (Admin)**
2. Pastikan environment: **Cloudinary Dev**
3. Click **Send**
4. Check response: Status 200/302 (redirect)
5. Cookie session otomatis disimpan ✅

**Langkah 2**: Create Project
1. Pilih request: **Create Project**
2. Di **Body** tab:
   - Ganti `title`, `summary`, `description` sesuai keinginan
   - Ganti `tech_stack` (pisah dengan koma)
   - Field `cover_image`: klik **Select File** → pilih gambar dari komputer
3. Click **Send**
4. Response: Project berhasil dibuat
5. Cek di browser: `http://localhost:8000/` → Gambar muncul dari Cloudinary folder ✅

**Langkah 3**: Update Project
1. Pilih request: **Update Project**
2. Di URL ganti `{{projectId}}` dengan ID actual (dari response step 2)
3. Update body (opsional upload gambar baru)
4. Click **Send**
5. Project terupdate ✅

**Langkah 4**: Get Projects
1. Pilih request: **Get All Projects**
2. Click **Send**
3. Response: JSON dengan semua projects + cloudinary_folder path

---

## Scenario 2: Direct Cloudinary Upload (Tanpa Laravel)

Jika ingin test Cloudinary API langsung:

### Setup Auth Token (untuk Signed Upload)

1. Buat **Pre-request Script** di request "Upload ke Cloudinary":

```javascript
// Generate timestamp
const timestamp = Math.floor(Date.now() / 1000);
pm.environment.set('timestamp', timestamp);

// Generate signature
const crypto = require('crypto');
const apiSecret = pm.environment.get('cloudinaryApiSecret');
const params = `folder=portfolio/projects/test&timestamp=${timestamp}${apiSecret}`;
const signature = crypto.createHash('sha1').update(params).digest('hex');
pm.environment.set('signature', signature);
```

2. Di request body (form-data):
   - `file`: [Select File]
   - `api_key`: {{cloudinaryApiKey}}
   - `timestamp`: {{timestamp}}
   - `signature`: {{signature}}
   - `folder`: portfolio/projects/test

3. Click **Send**

---

## Troubleshooting

### Masalah: "Invalid API key"
- ✅ Check `cloudinaryApiKey` di environment
- ✅ Pastikan nilai sesuai Cloudinary Dashboard
- ✅ Coba signed upload (dengan signature)

### Masalah: "Missing required parameter"
- ✅ Pastikan `file` ada (Select File, bukan text)
- ✅ Pastikan folder path format benar: `portfolio/projects/nama`
- ✅ Check required fields di endpoint

### Masalah: Upload via Laravel tapi gambar lokal
- ✅ Check Laravel logs: `php artisan tail`
- ✅ Verify `CLOUDINARY_*` di `.env` match dengan Postman
- ✅ Run: `php artisan config:clear && php artisan config:cache`

### Masalah: Session expired
- ✅ Ulang request "Login (Admin)"
- ✅ Pastikan Cookie Jar aktif (Postman → Settings → Cookies)

---

## Tips & Tricks

### Auto-refresh Signature
Gunakan Pre-request Script untuk auto-generate signature setiap request:

```javascript
// Di Pre-request Script
const crypto = require('crypto');
const timestamp = Math.floor(Date.now() / 1000);
const apiSecret = pm.environment.get('cloudinaryApiSecret');
const folder = 'portfolio/projects/test';

const message = `folder=${folder}&timestamp=${timestamp}${apiSecret}`;
const signature = crypto.createHash('sha1').update(message).digest('hex');

pm.environment.set('timestamp', timestamp);
pm.environment.set('signature', signature);
```

### Test dengan File Berbeda
1. Buat folder lokal: `test-images/`
2. Simpan beberapa gambar: `photo1.jpg`, `photo2.png`
3. Di Postman, "Select File" dari folder tersebut
4. Jalankan request multiple times dengan file berbeda

### Monitor Response Time
Postman otomatis track response time:
- Kecepatan Cloudinary upload (biasanya 200-500ms)
- Network latency (localhost: sangat cepat)

---

## Quick Reference

| Task | Request | Method |
|------|---------|--------|
| Login | Login (Admin) | POST |
| Buat Project | Create Project | POST |
| Update Project | Update Project | POST/PUT |
| Hapus Project | Delete Project | DELETE |
| Lihat Semua | Get Projects | GET |
| Upload Direct | Upload ke Cloudinary | POST |

---

## Environment Variables Summary

```
{{baseUrl}}                    → http://localhost:8000
{{adminEmail}}                → admin@portfolio.test
{{adminPassword}}             → admin12345
{{cloudinaryCloudName}}       → dducuhzso
{{cloudinaryApiKey}}          → 381236954385957
{{cloudinaryApiSecret}}       → LCPFjOjbNw_mKUeIfY5uNY8b_8Q
{{projectId}}                 → (from response setelah create)
{{projectSlug}}               → (dari create response)
{{timestamp}}                 → (auto-generate via script)
{{signature}}                 → (auto-generate via script)
```

---

Siap testing Cloudinary dengan Postman! 🚀📮
