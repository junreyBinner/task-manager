FROM php:8.3-fpm

# Install system dependencies (IMPORTANT: may libpq-dev na)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libonig-dev \
    libpq-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node deps & build frontend
RUN npm install && npm run build

# Set permissions
RUN chmod -R 777 storage bootstrap/cache

# Expose port
EXPOSE 8000

# Start Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
