### PHP
FROM php:7.4-alpine

ARG GID
ARG UID

RUN set -eux \
  && apk --no-cache add git icu-libs autoconf g++ make bash \
  && pecl install -f xdebug

RUN docker-php-ext-enable xdebug

# Init user
RUN addgroup -g 4000 -S app && adduser -u ${UID} -G app -s /bin/bash -S app && sed -i "s/4000/${GID}/" /etc/group

# Configure Timezone
RUN ln -fs /usr/share/zoneinfo/Europe/Paris /etc/localtime && \
    echo "Europe/Paris" > /etc/timezone

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

USER app

WORKDIR /var/www

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "/var/www", "/var/www/public/index.php"]
