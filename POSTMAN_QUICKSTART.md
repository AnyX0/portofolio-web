# 🚀 Postman Cloudinary - Quick Cheat Sheet

## Import (First Time)

```
1. Buka Postman
2. Click "Import" (top-left)
3. Choose folder: docs/postman/
4. Select: ProjectUAS.postman_collection.json
5. Click "Import"
```

## Setup Environment

```
1. Click "Environments" (left sidebar)
2. Click "Import"
3. Choose: docs/postman/Cloudinary_Dev.postman_environment.json
4. Click "Import"
5. Select environment: "Cloudinary Dev" (dropdown top-right)
```

## Test Flow

### Step 1: Login
```
Request: 1. Login (Admin)
Click: Send
Result: Status 200, Cookie saved ✅
```

### Step 2: Create Project
```
Request: 2. Create Project (via Laravel + Cloudinary)
Body: Select file image
Click: Send
Result: Status 302 (redirect), Project created ✅
Check: http://localhost:8000/ → Gambar muncul
```

### Step 3: Direct Cloudinary Upload (Optional)
```
Request: 6. Direct Upload to Cloudinary (Signed)
Pre-request Script: ✅ Auto-runs (generates signature)
Body: Select file image
Click: Send
Result: Status 200, Image uploaded to Cloudinary ✅
```

---

## Environment Variables

| Variable | Value |
|----------|-------|
| `{{baseUrl}}` | http://localhost:8000 |
| `{{adminEmail}}` | admin@portfolio.test |
| `{{adminPassword}}` | admin12345 |
| `{{projectId}}` | 1 (update setelah create) |
| `{{cloudinaryCloudName}}` | dducuhzso |
| `{{cloudinaryApiKey}}` | 381236954385957 |
| `{{cloudinaryApiSecret}}` | LCPFjOjbNw_mKUeIfY5uNY8b_8Q |
| `{{timestamp}}` | Auto-generate |
| `{{signature}}` | Auto-generate |

---

## Requests Available

| # | Name | Method | Purpose |
|---|------|--------|---------|
| 1 | Login (Admin) | POST | Authenticate & get session |
| 2 | Create Project | POST | Create + upload gambar ke Cloudinary |
| 3 | Update Project | POST | Update + replace gambar (optional) |
| 4 | Get All Projects | GET | Fetch semua projects |
| 5 | Delete Project | DELETE | Hapus project |
| 6 | Direct Upload to Cloudinary | POST | Upload langsung ke Cloudinary API |
| 7 | Logout (Admin) | POST | Close session |

---

## Tips

✅ **Enable Cookie Jar**: Postman → Settings → Cookies → ON
- Diperlukan untuk session persistence

✅ **Set projectId**: Setelah "Create Project", manual set {{projectId}}
- Untuk request "Update" dan "Delete"

✅ **Auto Signature**: Pre-request Script di "Direct Upload" auto-generate
- No manual calculation needed!

✅ **Test Multiple Files**: 
- Click "Select File" → pilih file berbeda
- Send lagi → Image terupload dengan nama beda

---

## Troubleshooting

| Problem | Solution |
|---------|----------|
| "Not authenticated" | Ulang request 1 (Login) |
| "File required" | Click "Select File" untuk cover_image |
| "Invalid API key" | Check environment variables |
| "CSRF token mismatch" | Cookie jar harus ON |
| "Method not allowed" | Pastikan request method benar |

---

Siap testing! 🎉
