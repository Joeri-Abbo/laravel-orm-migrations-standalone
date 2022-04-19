# we still use composer one
FROM composer:2 as composer
FROM php:8.1-fpm-alpine3.15

WORKDIR /var/www

ENV COMPOSER_MEMORY_LIMIT=-1
ENV NGINX_HTTP_PORT_NUMBER=8080
ENV NGINX_HTTPS_PORT_NUMBER=8444

# install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# install packages
RUN apk add nginx nginx-mod-http-headers-more supervisor curl libzip-dev git pcre-dev ${PHPIZE_DEPS}

RUN docker-php-source extract \
    # install zip ext
    && docker-php-ext-install zip \
    # install myqsl ext
    && docker-php-ext-install pdo pdo_mysql\
    # install pcntl ext
    && docker-php-ext-install pcntl

RUN apk update
RUN apk upgrade
RUN apk add bash

# install xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# configure PHP-FPM
COPY config/fpm-pool.conf /etc/php81/php-fpm.d/www.conf
COPY config/php.ini /etc/php81/conf.d/docker-php-custom.ini

# configure nginx
COPY config/nginx.conf /etc/nginx/nginx.conf

# configure supervisord
COPY config/supervisord.conf /etc/supervisord.conf

# configure xdebug
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.mode=debug,trace" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# clean up
RUN apk del pcre-dev ${PHPIZE_DEPS}
RUN docker-php-source delete

# setup document root
RUN mkdir -p /var/www
RUN mkdir -p /var/www/storage/nginx/cache
RUN mkdir -p /.composer

RUN ln -s /var/www /app

# make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody.nobody /var/www && \
  chown -R nobody.nobody /run && \
  chown -R nobody.nobody /var/lib/nginx && \
  chown -R nobody.nobody /var/log/nginx && \
  chown -R nobody.nobody /.composer

# for xdebug
EXPOSE 9003

# for ngix
EXPOSE 8080
EXPOSE 8444