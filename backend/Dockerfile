FROM php:8.1-fpm-alpine

RUN apk update && apk add --no-cache \
    libzip-dev zip unzip \
    sqlite-dev

RUN docker-php-ext-install pdo pdo_sqlite

RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copy the application code
COPY . .

# copy .env.example to .env
COPY .env.example .env

# creating sqlLite database file
RUN touch database/database.sqlite

# Copy Composer files and install dependencies
COPY composer.json composer.lock artisan ./
RUN composer install

RUN php artisan migrate --force
RUN php artisan key:generate


CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000