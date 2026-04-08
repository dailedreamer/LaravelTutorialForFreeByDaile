FROM php:8.4-fpm

# Install system packages
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev

# Install Node
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy FULL Laravel project first  ⭐ IMPORTANT
COPY . .

# Install PHP dependencies (now artisan exists)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Laravel optimizations
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Fix permissions
RUN chown -R www-data:www-data /var/www \
 && chmod -R 755 /var/www/storage

EXPOSE 10000

CMD php -S 0.0.0.0:10000 -t public