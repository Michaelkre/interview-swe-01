FROM php:8.1-fpm-alpine

RUN apk update && apk add --no-cache \
    libzip-dev zip unzip \
    sqlite-dev

RUN docker-php-ext-install pdo pdo_sqlite


RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# creating sqlLite databse file
RUN touch database/database.sqlite
RUN chmod 777 database/database.sqlite
# copy .env.example to .env
COPY .env.example .env

WORKDIR /var/www/html

COPY . .

RUN composer install

RUN php artisan migrate
RUN php artisan key:generate

EXPOSE 8000

CMD ["php", "artisan", "serve", "--port=8000"]