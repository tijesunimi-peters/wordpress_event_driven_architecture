FROM php
WORKDIR /var/www/html/wp-content/plugins/tijes-plugin

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN apt-get update && apt-get install -y \
    zip \
    unzip 

RUN docker-php-ext-install bcmath
RUN docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

COPY . .

RUN composer install

RUN ls -al ./vendor

RUN composer dump-autoload -o

