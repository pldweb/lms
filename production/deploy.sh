#!/bin/bash
# Hentikan script jika ada perintah yang gagal
set -e

echo "🚀 Memulai proses deployment update..."

# 1. Masuk ke maintenance mode
echo "Masuk ke maintenance mode..."
php artisan down || true

# 2. Tarik perubahan terbaru dari branch 'main'
echo "Menarik perubahan dari branch 'main'..."
git pull origin main

# 3. Install/update dependensi Composer
echo "Install/update dependensi Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 5. Jalankan migrasi database (AMAN: hanya menjalankan migrasi yang baru)
echo "Menjalankan migrasi database..."
php artisan migrate --force

# 6. Bersihkan cache dan buat cache baru yang teroptimasi
echo "Membersihkan dan membuat cache optimasi..."
php artisan app:clear-route
php artisan config:cache
php artisan view:cache

# 7. Atur ulang izin folder
echo "Mengatur izin folder..."
sudo chown -R $USER:www-data .
sudo chmod -R 775 storage bootstrap/cache

# 8. Keluar dari maintenance mode
echo "Keluar dari maintenance mode..."
php artisan up

echo "✅ Deployment update selesai!"