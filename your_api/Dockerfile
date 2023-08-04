FROM php:8.1-fpm-alpine

RUN apk update && apk add --no-cache \
    libzip-dev zip unzip \
    sqlite-dev

RUN docker-php-ext-install pdo pdo_sqlite


RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# copy .env.example to .env
COPY .env.example .env

COPY . .

RUN composer install

# creating sqlLite databse file
RUN touch database/database.sqlite
RUN php artisan migrate
RUN php artisan key:generate



EXPOSE 8000

# Utilisation de supervisord pour exécuter le serveur de développement et le worker de la file d'attente
RUN apk add supervisor
COPY supervisord.conf /etc/supervisord.conf
CMD ["supervisord", "-n"]