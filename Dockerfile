FROM php:7.1-fpm

RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i 's/security.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i '/stretch-updates/d' /etc/apt/sources.list && \
    sed -i '/buster-updates/d' /etc/apt/sources.list


RUN apt-get update && apt-get install -y \
    nginx git curl libpng-dev libxml2-dev zip unzip


RUN docker-php-ext-install pdo_mysql exif pcntl bcmath gd


WORKDIR /app
COPY . .


RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache && \
    chmod -R 775 /app/storage /app/bootstrap/cache

COPY nginx.conf /etc/nginx/sites-available/default

EXPOSE 80

CMD php-fpm -D && nginx -g 'daemon off;'