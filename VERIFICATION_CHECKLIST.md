# ✅ Cloudinary Migration Verification Checklist

## Pre-Flight Checks (Before Testing)

- [ ] Cloudinary account created at https://cloudinary.com
- [ ] Cloudinary credentials obtained:
  - [ ] Cloud Name
  - [ ] API Key  
  - [ ] API Secret
  - [ ] Upload Preset (optional, for unsigned uploads)
- [ ] `.env` file filled with Cloudinary credentials:
  ```bash
  cat .env | grep CLOUDINARY
  ```
- [ ] Config cache cleared:
  ```bash
  php artisan config:clear && php artisan config:cache
  ```

## Code Verification

- [ ] CloudinaryUploader service exists: `app/Services/CloudinaryUploader.php`
- [ ] Controller import updated:
  ```bash
  grep "use App\Services\CloudinaryUploader" app/Http/Controllers/Admin/ProjectController.php
  ```
- [ ] store() method uses CloudinaryUploader:
  ```bash
  grep -A 3 "new CloudinaryUploader" app/Http/Controllers/Admin/ProjectController.php | head -10
  ```
- [ ] update() method uses CloudinaryUploader:
  ```bash
  grep -A 3 "new CloudinaryUploader" app/Http/Controllers/Admin/ProjectController.php | tail -10
  ```
- [ ] Local fallback logic present in both methods
- [ ] Flash warning message set on fallback

## File Structure Check

```
project_uas/
├── app/
│   ├── Services/
│   │   └── CloudinaryUploader.php          ✓ Created
│   └── Http/Controllers/Admin/
│       └── ProjectController.php           ✓ Updated
├── config/
│   └── services.php                        ✓ Has cloudinary section
├── .env                                    ✓ Has CLOUDINARY_* vars
├── CLOUDINARY_SETUP.md                     ✓ Created
├── MIGRATION_STATUS.md                     ✓ Created
└── VERIFICATION_CHECKLIST.md               ✓ This file
```

## Browser Testing

1. **Start Servers**
   ```bash
   # Terminal 1
   php artisan serve
   
   # Terminal 2  
   npm run dev
   ```

2. **Access Admin Console**
   - URL: `http://localhost:8000/console/access`
   - Email: `admin@portfolio.test`
   - Password: `admin12345`
   - [ ] Login successful

3. **Create Project with Image**
   - [ ] Click "Buat Project Baru"
   - [ ] Fill title, summary, tech_stack, description
   - [ ] Upload image via "Choose File"
   - [ ] Click "Buat"
   - [ ] No error messages (check server logs if fails)

4. **Verify Image Upload**
   - [ ] Redirected to dashboard
   - [ ] Check for warning message:
     - If "Upload ke Cloudinary gagal..." → Fallback used (check credentials)
     - If no warning → Cloudinary succeeded ✅
   - [ ] Check logs for details:
     ```bash
     tail -f storage/logs/laravel.log
     ```

5. **Check Public Pages**
   - [ ] Homepage (`http://localhost:8000/`) shows project card with image
   - [ ] Project detail (`http://localhost:8000/project/YOUR-SLUG-HERE`) shows image
   - [ ] Right-click image → "Inspect" → Check URL:
     - Cloudinary: `https://res.cloudinary.com/your-cloud-name/...`
     - Local: `http://localhost:8000/storage/covers/...`

## Database Check

```bash
# Using SQLite (default)
sqlite3 database/database.sqlite

# Inside sqlite3 shell:
SELECT id, title, cover_path FROM projects WHERE cover_path IS NOT NULL LIMIT 3;
.quit
```

**Expected Output**:
- `cover_path` contains URL (Cloudinary or local storage path)
- Not NULL or empty string

## Log File Check

```bash
# Windows PowerShell
Get-Content storage/logs/laravel.log -Tail 50

# Mac/Linux
tail -n 50 storage/logs/laravel.log
```

**Look for**:
- ✅ No "Cloudinary credentials not configured" warnings
- ✅ No HTTP errors (403, 500, etc) from Cloudinary API
- ✅ Successful uploads show no errors

## Postman Testing (Optional)

1. **Import Collection**
   - File: `docs/postman/ProjectUAS.postman_collection.json`
   - Import into Postman

2. **Configure Postman Environment**
   - Set `baseUrl`: `http://localhost:8000`
   - Set `adminEmail`: `admin@portfolio.test`
   - Set `adminPassword`: `admin12345`

3. **Run Tests**
   - [ ] "Login (Admin)" → Status 200
   - [ ] "Create Project (with cover_image)" → Status 201
     - Select image file in Body → cover_image
     - Check response has `cover_path`
   - [ ] "Get Projects" → See created project with image
   - [ ] "Update Project (with cover_image)" → Status 200

## Troubleshooting Checklist

If upload always falls back to local:

- [ ] Verify env variables are set:
  ```bash
  php -r "echo getenv('CLOUDINARY_CLOUD_NAME');"
  ```
- [ ] Check config was cached:
  ```bash
  php artisan config:show services.cloudinary
  ```
- [ ] View logs for specific error:
  ```bash
  tail -f storage/logs/laravel.log | grep -i cloudinary
  ```
- [ ] Test credentials are correct in Cloudinary Dashboard
- [ ] If using unsigned upload, verify preset exists

If "Cloudinary credentials not configured":

- [ ] `.env` has non-empty CLOUDINARY_CLOUD_NAME, CLOUDINARY_API_KEY, CLOUDINARY_API_SECRET
- [ ] Ran `php artisan config:clear`
- [ ] Restart PHP server: `php artisan serve` (kill and restart)

If image doesn't appear on public pages:

- [ ] Storage symlink exists:
  ```bash
  ls -l public/storage  # Should show link
  ```
- [ ] Create symlink if missing:
  ```bash
  php artisan storage:link
  ```
- [ ] Folder `storage/app/public/covers` is writable
- [ ] Database has correct `cover_path` URL

## Production Readiness Checklist

- [ ] `.env` on production server has valid Cloudinary credentials
- [ ] Config cache rebuilt on production:
  ```bash
  php artisan config:cache
  ```
- [ ] Storage symlink exists on production:
  ```bash
  php artisan storage:link
  ```
- [ ] `storage/app/public/covers` directory writable by web server
- [ ] Test upload with small image (~500KB) first
- [ ] Monitor logs: `tail -f storage/logs/laravel.log`
- [ ] Cloudinary account has adequate free plan limits remaining

## Success Criteria ✅

Your migration is **SUCCESSFUL** when:

1. ✅ Upload to Cloudinary completes without warning
2. ✅ Image URL is `https://res.cloudinary.com/...`
3. ✅ Image appears correctly on `/` and `/project/{slug}`
4. ✅ Logs show no Cloudinary errors
5. ✅ Database stores valid `cover_path`

Your migration has **FALLBACK WORKING** when:

1. ✅ Credentials intentionally wrong → warning shown
2. ✅ Image still appears (from local storage)
3. ✅ Image URL is `http://localhost:8000/storage/covers/...`
4. ✅ Admin sees "Upload ke Cloudinary gagal; gambar disimpan lokal." message

---

## Final Notes

- **Migration is COMPLETE** — all code changes done ✓
- **You need to: Fill in `.env` with YOUR Cloudinary credentials**
- **Then: Test via browser following steps above**
- **Questions?** See `CLOUDINARY_SETUP.md` for detailed guide

---

**Status**: Ready for testing! 🚀
