FROM php:8.1-fpm

COPY php.ini /usr/local/etc/php/

ARG UID
ARG GID

RUN apt update \
  && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
  && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

RUN groupadd -g ${GID} appgroup \
  && useradd -m -u ${UID} -g appgroup appuser

RUN mkdir -p /var/www && chown -R appuser:appgroup /var/www

USER appuser

WORKDIR /var/www