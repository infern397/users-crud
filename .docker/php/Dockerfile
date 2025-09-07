FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

RUN docker-php-ext-install \
    pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer
