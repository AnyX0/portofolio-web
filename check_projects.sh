#!/bin/bash

cd "E:\Andi\Documents\Kuliah\PEMROGRAMAN MOBILE - SMT5\StudioProjects\project_uas"

# Check projects with images
php artisan db:seed --class=ProjectSeeder 2>/dev/null || true

# Show projects info
sqlite3 database/database.sqlite "
  SELECT id, title, slug, cover_image, cloudinary_folder FROM projects LIMIT 5;
" 2>/dev/null || php -r "
\$db = new PDO('mysql:host=localhost;dbname=' . trim(file_get_contents('.env')), 'root', '');
\$stmt = \$db->query('SELECT id, title, slug, cover_image, cloudinary_folder FROM projects LIMIT 5');
while (\$row = \$stmt->fetch(PDO::FETCH_ASSOC)) {
    echo \$row['id'] . ' | ' . \$row['title'] . ' | ' . (\$row['cover_image'] ? 'HAS IMAGES' : 'NO IMAGES') . PHP_EOL;
}
"
