FROM php:7.4-fpm
#цим докер файлом ми розширюємо php 7.4.додатковими утилітами.при білді цьго фалу окрім php будуть завантажені ці утиліти.

RUN apt-get update --fix-missing \
    && apt-get install -y --no-install-recommends \
    libpq-dev wget unzip mc git locales iputils-ping \
    postgresql-client ssh-client libssl-dev libzip-dev libmagickwand-dev \
    apt-transport-https ca-certificates libpng-dev libicu-dev libldap2-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql bcmath sockets gd zip \
    && docker-php-ext-install intl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer