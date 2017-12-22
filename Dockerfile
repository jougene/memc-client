FROM php:7.1-cli-jessie

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install -y \
    zlibc \
    zlib1g \
    zlib1g-dev \
    libxml2-dev \
    memcached \
    && docker-php-ext-install -j$(nproc) xml mbstring zip

COPY . /app
WORKDIR /app
RUN composer install
CMD /bin/bash


