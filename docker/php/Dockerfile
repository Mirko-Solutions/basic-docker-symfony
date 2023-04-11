FROM php:8.1.6-fpm

RUN apt-get update -y && apt-get install -y libpng-dev libzip-dev gcc g++ libtool libmcrypt-dev libpq-dev unzip

RUN docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql pgsql bcmath gd zip

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
