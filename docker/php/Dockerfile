FROM php:8.1.2-fpm-alpine

RUN apk update && apk add --update \
    libtool \
    g++ \
    autoconf \
    make \
    zlib-dev \
    libzip-dev \
    oniguruma-dev \
    && pecl install redis-5.3.6 \
    && docker-php-ext-install mbstring pdo_mysql iconv zip opcache \
    && docker-php-ext-enable redis \
    && apk del autoconf g++ libtool make \
    && rm -rf /tmp/* /var/cache/apk/* /usr/src/* /code

WORKDIR /var/www/ecom

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN cd /usr/local/etc/php/conf.d/ && \
    echo 'php_max_execution_time = 360' >> /usr/local/etc/php/conf.d/custom-settings.ini && \
    echo 'php_max_input_time = 3600' >> /usr/local/etc/php/conf.d/custom-settings.ini && \
    echo 'php_max_input_vars = 20000' >> /usr/local/etc/php/conf.d/custom-settings.ini
