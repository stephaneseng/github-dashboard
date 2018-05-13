FROM php:7.2-apache

# apache
ENV APACHE_DOCUMENT_ROOT /var/www/github-dashboard/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# php
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql

# www
COPY . /var/www/github-dashboard
WORKDIR /var/www/github-dashboard
