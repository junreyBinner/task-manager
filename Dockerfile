FROM php:8.3-fpm

# Install dependencies
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

WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader

# Install Node deps & build frontend assets
RUN npm install && npm run build

# Fix permissions
RUN chmod -R 777 storage bootstrap/cache public

EXPOSE 8000

# Cache config & routes for performance
RUN php artisan config:clear && php artisan config:cache && php artisan route:clear && php artisan view:clear

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
