FROM php:8.0-fpm-alpine3.12

RUN apk --no-cache update && \
    apk --no-cache upgrade && \
    apk --no-cache add git postgresql-dev

RUN docker-php-ext-install bcmath pdo_mysql pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/web

CMD ["php-fpm"]
