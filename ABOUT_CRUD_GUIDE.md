# About Page CRUD - Documentation

## Overview
Sistem CRUD untuk mengelola konten halaman About dari admin dashboard. Admin dapat mengedit informasi kontak, skills, timeline, dan bio tanpa perlu mengubah kode.

## Features
- ✅ Edit informasi kontak (email, phone, location, availability)
- ✅ Kelola skills dengan input comma-separated
- ✅ Timeline dinamis dengan tombol add/remove
- ✅ Bio text area
- ✅ Auto-create default data jika belum ada
- ✅ Validasi form lengkap

## Files Created

### 1. Migration
**File:** `database/migrations/2026_01_16_160142_create_about_table.php`

Schema:
```php
- id (bigIncrements)
- email (string, required)
- phone (string, required)
- location (string, required)
- availability (string, required)
- timeline (json) - Array of {year, title, desc}
- skills (json) - Array of strings
- bio (text, nullable)
- timestamps
```

### 2. Model
**File:** `app/Models/About.php`

Features:
- Fillable: email, phone, location, availability, timeline, skills, bio
- Casts: timeline & skills as 'array' untuk JSON handling

### 3. Controller
**File:** `app/Http/Controllers/Admin/AboutController.php`

Methods:
- `edit()` - Show edit form with firstOrCreate (default data from old PortfolioController)
- `update()` - Validate & save, parse comma-separated skills, filter empty timeline entries

Validation Rules:
```php
'email' => 'required|email|max:255'
'phone' => 'required|string|max:50'
'location' => 'required|string|max:255'
'availability' => 'required|string|max:255'
'bio' => 'nullable|string'
'timeline' => 'required|array'
'timeline.*.year' => 'required|string'
'timeline.*.title' => 'required|string'
'timeline.*.desc' => 'required|string'
'skills' => 'nullable|string'
```

### 4. View
**File:** `resources/views/admin/about/edit.blade.php`

Sections:
- Contact Information (email, phone, location, availability, bio)
- Skills Input (comma-separated dengan hint)
- Timeline Section (dynamic add/remove dengan JavaScript)

JavaScript Features:
- `addTimelineItem()` - Add new timeline entry
- Remove buttons untuk setiap timeline item
- Auto-increment timelineIndex counter

## Routes

```php
Route::get('/console/about/edit', [AboutController::class, 'edit'])
    ->name('admin.about.edit');
    
Route::put('/console/about', [AboutController::class, 'update'])
    ->name('admin.about.update');
```

## Updated Files

### PortfolioController
**File:** `app/Http/Controllers/PortfolioController.php`

Changes:
- Added `use App\Models\About;`
- Modified `about()` method to read from database
- Auto-create default data if none exists
- Maintains backward compatibility with existing about.blade.php view

### Dashboard
**File:** `resources/views/admin/dashboard.blade.php`

Changes:
- Added "Kelola About" quick action card (purple theme)
- Changed grid from 2 columns to 3 columns

### Routes
**File:** `routes/web.php`

Changes:
- Added AboutController import
- Added admin.about.edit and admin.about.update routes

## Usage

### Access Admin Panel
1. Login ke console: `/console/access`
2. Dari dashboard, klik "Kelola About"
3. Edit form yang sudah terisi dengan data default
4. Submit untuk save

### Edit Contact Info
- Email, Phone, Location, Availability: Standard text input
- Bio: Optional textarea untuk deskripsi panjang

### Manage Skills
- Input comma-separated: `Flutter, Laravel, Tailwind`
- Disimpan sebagai array di database: `["Flutter", "Laravel", "Tailwind"]`

### Manage Timeline
- Click "Tambah Timeline" untuk add entry baru
- Fill: Year, Title, Description
- Click "Hapus" untuk remove entry
- Minimal 1 entry required untuk submit

## Database Storage

Timeline JSON Structure:
```json
[
  {
    "year": "2023",
    "title": "Fullstack Developer",
    "desc": "Bangun SaaS multi-tenant dengan Laravel + Flutter front layer."
  }
]
```

Skills JSON Structure:
```json
["Flutter", "Laravel", "Tailwind", "Clean Architecture", "CI/CD", "TypeScript"]
```

## Testing Checklist

✅ Migration ran successfully
✅ Routes registered correctly
✅ No PHP errors in controllers/models
✅ Dashboard link to About edit works
✅ Form displays with default data
✅ Timeline add/remove functionality works
✅ Skills comma-separated parsing works
✅ Validation catches empty required fields
✅ Public about page displays data from database

## Deployment Notes

**Git Commit:** `9861cf1 - Add About page CRUD for admin dashboard`

**Changes Deployed:**
- 7 files changed
- 291 insertions, 19 deletions
- 4 new files created

**Production Checklist:**
- [x] Push to GitHub (triggers Vercel deploy)
- [ ] Run migration on production: `php artisan migrate`
- [ ] Test admin/about/edit route works
- [ ] Verify public about page loads

## Future Enhancements

Possible improvements:
- Add profile photo upload
- Social media links (GitHub, LinkedIn, Twitter)
- Resume/CV file upload
- Multi-language support
- WYSIWYG editor for bio
- Timeline item ordering/sorting

---

**Created:** 2026-01-16  
**Status:** ✅ Deployed to main branch  
**Next:** Test on production after Vercel deployment completes
