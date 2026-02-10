FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    git \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    nodejs \
    npm \
    gettext-base \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd

WORKDIR /var/www

# Copy app
COPY . .

# Install PHP deps
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# INSTALL & BUILD FRONTEND
RUN npm install && npm run build

# Permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Configs
COPY docker/nginx.conf /etc/nginx/templates/default.conf.template
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/zz-render.conf

EXPOSE 8080

CMD envsubst '$PORT' < /etc/nginx/templates/default.conf.template > /etc/nginx/sites-available/default \
 && nginx -t \
 && /usr/bin/supervisord -n
