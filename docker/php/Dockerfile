FROM php:7.2-fpm

RUN apt-get update && apt-get install -y libicu-dev && apt-get clean
RUN apt-get install curl
RUN apt-get install -y zlib1g-dev \
    && docker-php-ext-install zip
RUN pecl install apcu xdebug
RUN docker-php-ext-enable apcu xdebug
RUN docker-php-ext-install pdo_mysql intl opcache
RUN apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime
RUN "date"


WORKDIR /usr/share/nginx/html