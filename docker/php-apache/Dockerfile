FROM php:7.2-apache

# apache
ENV APACHE_DOCUMENT_ROOT /var/www/github-dashboard/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# apt-miscellaneous
RUN apt-get update \
    && apt-get install -y wget

# php
RUN apt-get install -y libpq-dev && docker-php-ext-install pdo_pgsql \
    && apt-get install -y zlib1g-dev && docker-php-ext-install zip

# php-composer
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/fe44bd5b10b89fbe7e7fc70e99e5d1a344a683dd/web/installer -O - -q | php -- --quiet

# www
COPY . /var/www/github-dashboard
WORKDIR /var/www/github-dashboard
