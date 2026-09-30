# syntax=docker/dockerfile:1
FROM php:8.3-cli

# --- Dependensi sistem + ekstensi PHP ---
# pdo, pdo_sqlite, dan mbstring SUDAH bawaan image php:8.3-cli,
# jadi yang perlu dipasang hanya zip (dibutuhkan Composer).
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

# --- Composer (disalin dari image resmi composer, bukan diinstal manual) ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# =========================================================
# LAPISAN CACHE: salin composer.json & composer.lock DULU,
# baru install dependency. Selama kedua file ini tidak
# berubah, Docker memakai cache lapisan ini dan melewati
# "composer install" (langkah paling lama).
# =========================================================
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

# --- Baru salin SISA kode aplikasi (paling sering berubah) ---
COPY . .

# --- Folder storage yang dikecualikan .dockerignore dibuat ulang (kosong) ---
RUN mkdir -p storage/framework/cache/data storage/framework/sessions \
        storage/framework/views storage/logs bootstrap/cache \
    && composer dump-autoload --optimize --no-dev

# --- Siapkan .env dari template (bukan menyalin .env asli laptop) ---
# Database SQLite baru dibuat di dalam image, lalu dimigrasi supaya
# tabel tasks, sessions, dan cache sudah ada saat container jalan.
RUN cp .env.example .env \
    && php artisan key:generate --force \
    && touch database/database.sqlite \
    && php artisan migrate --force \
    && php artisan config:clear

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]