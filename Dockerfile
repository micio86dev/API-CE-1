FROM php:8.3-cli

# System dependencies + PostgreSQL dev
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www

RUN php artisan config:clear
RUN php artisan migrate --force
RUN php artisan cache:clear
RUN php artisan route:clear
RUN php artisan view:clear
RUN php artisan roles:permissions
RUN php artisan permission:cache-reset

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=$PORT
