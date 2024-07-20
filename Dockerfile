FROM php:8.3.9-alpine

WORKDIR /var/www/lumen-app

RUN apk update \
    && apk add --no-cache bash \
    && curl -sS https://getcomposer.org/installer | php -- --version=2.4.3 --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "public/index.php"]
