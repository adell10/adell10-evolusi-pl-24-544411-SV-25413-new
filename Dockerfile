# syntax=docker/dockerfile:1

# ==================================================================
# STAGE 1: vendor (builder) - boleh besar. Composer dan seluruh proses
# instalasi dependency terjadi di sini. Stage ini TIDAK ikut ke image akhir.
# ==================================================================
FROM composer:2.7 AS vendor

WORKDIR /app

# Lapisan cache: salin daftar dependency dulu, baru install
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev --no-scripts --no-autoloader --prefer-dist \
    --no-interaction --ignore-platform-reqs

# Baru salin kode aplikasi, lalu buat autoloader final
COPY . .
RUN composer dump-autoload --optimize --no-dev


# ==================================================================
# STAGE 2: runtime - HANYA berisi yang dibutuhkan aplikasi saat jalan.
# Base image alpine (jauh lebih kecil dari varian Debian), versi PHP
# dan versi Alpine dikunci eksplisit (bukan "latest").
# Ekstensi pdo, pdo_sqlite, dan mbstring sudah bawaan image ini,
# jadi tidak perlu dipasang lagi.
# ==================================================================
FROM php:8.3-cli-alpine3.20 AS runtime

WORKDIR /var/www/html

# Salin HANYA hasil jadi dari stage vendor (kode + vendor/ produksi).
# Composer, cache Composer, dan dependency dev tertinggal di stage 1.
COPY --from=vendor /app ./

# Folder storage yang dikecualikan .dockerignore dibuat ulang (kosong),
# lalu .env dan database SQLite disiapkan dan dimigrasi.
RUN mkdir -p storage/framework/cache/data storage/framework/sessions \
        storage/framework/views storage/logs bootstrap/cache \
    && cp .env.example .env \
    && php artisan key:generate --force \
    && touch database/database.sqlite \
    && php artisan migrate --force \
    && php artisan config:clear

# --- Jangan jalan sebagai root ---
RUN addgroup -g 1000 appgroup \
    && adduser -D -u 1000 -G appgroup appuser \
    && chown -R appuser:appgroup /var/www/html
USER appuser

EXPOSE 8000

# Container dianggap sehat kalau endpoint health bawaan Laravel (/up) merespons.
HEALTHCHECK --interval=15s --timeout=5s --start-period=10s --retries=3 \
  CMD php -r "exit(@file_get_contents('http://127.0.0.1:8000/up') === false ? 1 : 0);"

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]