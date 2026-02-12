FROM php:7.1-fpm

# 1. Fix Debian Stretch sources (Arsip)
RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i 's/security.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i '/stretch-updates/d' /etc/apt/sources.list

# 2. Update dan Install minimal tools
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# 3. Install ekstensi PHP secara bertahap (ini kunci agar tidak crash)
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl

WORKDIR /app
COPY . .

# 4. Permissions
RUN mkdir -p /app/storage /app/bootstrap/cache && \
    chown -R www-data:www-data /app/storage /app/bootstrap/cache && \
    chmod -R 775 /app/storage /app/bootstrap/cache

COPY nginx.conf /etc/nginx/sites-available/default

EXPOSE 80

CMD php-fpm -D && nginx -g 'daemon off;'