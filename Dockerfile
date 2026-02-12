FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip nginx

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app
COPY . .


RUN mkdir -p /app/bootstrap/cache /app/storage/framework/sessions /app/storage/framework/views /app/storage/framework/cache
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache
RUN chmod -R 775 /app/storage /app/bootstrap/cache

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Expose port 80
EXPOSE 80

# Start Nginx & PHP-FPM
CMD service nginx start && php-fpm