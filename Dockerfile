FROM php:8.2-cli AS vendor

RUN apt-get update && apt-get install -y unzip git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY composer.json composer.lock ./
RUN mkdir -p database/seeds database/seeders database/factories database/migrations \
    && composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --ignore-platform-reqs

FROM dunglas/frankenphp:php8.2-bookworm

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring gd zip bcmath opcache

WORKDIR /app

COPY --from=vendor /app/vendor ./vendor
COPY . .

RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R a+rw storage bootstrap/cache \
    && mkdir -p database/seeds database/seeders database/factories database/migrations

EXPOSE 80

CMD ["sh", "-c", "php artisan config:cache && php artisan route:cache && php artisan view:cache && frankenphp run --config /etc/caddy/Caddyfile"]
