# 🚀 QUICK START - Cloudinary Setup (5 Minutes)

## 1️⃣ Get Cloudinary Account (2 min)
```
1. Visit: https://cloudinary.com
2. Click "Sign up"
3. Create free account
4. Go to Dashboard (top right)
5. Copy three values:
   - Cloud Name
   - API Key
   - API Secret
```

## 2️⃣ Update .env File (1 min)
Edit `.env` in your project root:

```env
CLOUDINARY_CLOUD_NAME=paste_your_cloud_name_here
CLOUDINARY_API_KEY=paste_your_api_key_here
CLOUDINARY_API_SECRET=paste_your_api_secret_here
CLOUDINARY_UPLOAD_PRESET=          # Leave blank for now
```

## 3️⃣ Clear Config (1 min)
```bash
php artisan config:clear && php artisan config:cache
```

## 4️⃣ Test (1 min)
```bash
# Terminal 1
php artisan serve

# Terminal 2 (if not already running)
npm run dev
```

Then:
1. Go to: `http://localhost:8000/console/access`
2. Login: `admin@portfolio.test` / `admin12345`
3. Create a new project with image
4. Check homepage: See gambar? ✅ You're done!

---

## ✅ What to Look For

**If upload works** (no warning):
```
Image URL: https://res.cloudinary.com/...
✅ Cloudinary upload successful!
```

**If fallback triggers** (amber warning):
```
Message: "Upload ke Cloudinary gagal; gambar disimpan lokal."
📝 Check .env credentials are correct
🔄 Run: php artisan config:clear
🔍 Check logs: tail -f storage/logs/laravel.log
```

---

## 📚 More Info

- **Setup Details**: See `CLOUDINARY_SETUP.md`
- **Testing Steps**: See `VERIFICATION_CHECKLIST.md`
- **What's Done**: See `CLOUDINARY_COMPLETE.md`

---

**That's it! Your portfolio now uses Cloudinary for cloud image hosting.** 🎉
