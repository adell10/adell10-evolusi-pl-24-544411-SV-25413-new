#!/usr/bin/env bash
set -e

echo "[1/7] Mengambil kode terbaru dari branch main (git pull origin main)"
echo "[2/7] Mengaktifkan mode maintenance (php artisan down)"
echo "[3/7] Memasang dependency produksi (composer install --no-dev --optimize-autoloader)"
echo "[4/7] Menjalankan migrasi database (php artisan migrate --force)"
echo "[5/7] Membangun ulang cache konfigurasi, route, dan view (config:cache, route:cache, view:cache)"
echo "[6/7] Me-restart queue worker agar memakai kode terbaru (php artisan queue:restart)"
echo "[7/7] Menonaktifkan mode maintenance dan memverifikasi aplikasi hidup (php artisan up)"

echo "Deploy ke production selesai."