FROM php:7.1-apache-jessie

MAINTAINER Dev2Choiz

WORKDIR /var/www/html/filegen

ENV DEBIAN_FRONTEND noninteractive

RUN useradd -ms /bin/bash filegen
ENV DEV_REMOTE_HOST 192.168.0.15

ENV APACHE_RUN_USER filegen
ENV APACHE_RUN_GROUP filegen
ENV APACHE_DOCUMENTROOT /var/www

COPY ./docker/filegen/php.ini /usr/local/etc/php/php.ini

RUN apt-get update \
    && buildDeps=" \
        libz-dev \
        libsqlite3-dev \
        libpng-dev \
    " \
    && doNotUninstall=" \
    " \
    && apt-get install -y $buildDeps --no-install-recommends \
    && rm -r /var/lib/apt/lists/* \
    \
    && docker-php-source extract \
        && docker-php-ext-install -j$(nproc) zip bcmath sockets gd \
    && docker-php-source delete \
    \
    #&& apt-mark manual $doNotUninstall \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false $buildDeps


RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo "xdebug.remote_host=192.168.0.15" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN apt-get update \
    && apt-get install -y curl vim \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["apache2-foreground"]
