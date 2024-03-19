FROM composer:2.6 as build
WORKDIR /build
COPY . .
RUN composer install

FROM php:8.3-rc-apache-bullseye
COPY --from=build /build/ /var/www/html/
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN apt update
RUN apt install -y libpq-dev libicu-dev
RUN docker-php-ext-install pdo_pgsql intl

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN chown -R www-data /var/www/html/storage
RUN chown -R www-data /var/www/html/bootstrap/cache
RUN a2enmod rewrite