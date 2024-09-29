# Use an official PHP runtime as a parent image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader && php artisan key:generate && php artisan migrate

# Expose port 10000
EXPOSE 10000

# Start Laravel server
CMD php artisan serve --host 0.0.0.0 --port 10000
