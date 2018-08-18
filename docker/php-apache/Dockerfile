FROM php:7.2-apache

# apache
ENV APACHE_DOCUMENT_ROOT /var/www/github-dashboard/public
RUN sed -i 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -i 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# apt-miscellaneous
RUN apt-get update \
    && apt-get install -y wget

# php-pdo_pgsql
RUN apt-get install -y libpq-dev && docker-php-ext-install pdo_pgsql

# php-zip
RUN apt-get install -y zlib1g-dev && docker-php-ext-install zip

# php-xdebug
RUN pecl install xdebug-2.6.1 && docker-php-ext-enable xdebug

# php-composer (1.7.2)
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/7cf90ec1d9540d586f6ac80babbc342033adf6b6/web/installer -O - -q | php -- --quiet --install-dir=/usr/local/bin --filename=composer

# www
COPY . /var/www/github-dashboard
WORKDIR /var/www/github-dashboard
