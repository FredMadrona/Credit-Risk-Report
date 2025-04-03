# Use official PHP image with FPM
FROM php:8.2-fpm

# Install required extensions
RUN apt-get update && apt-get install -y \
    zip unzip curl git libpq-dev libpng-dev libicu-dev libzip-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_pgsql gd intl zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 9000

# Start Laravel
CMD ["php-fpm"]
