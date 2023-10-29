FROM php:8.2-fpm-alpine

ARG UID
ARG GID



RUN docker-php-ext-install pdo pdo_mysql
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk --no-cache add shadow && usermod -u $UID www-data && groupmod -g $GID www-data
RUN chown -R www-data:www-data /var/www
RUN chown -R www-data:www-data /home/www-data

WORKDIR /var/www
