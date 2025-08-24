FROM dunglas/frankenphp AS base

RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    git \
    unzip \
    librabbitmq-dev \
    libpq-dev \
    supervisor

RUN install-php-extensions \
    gd \
    pcntl \
    opcache \
    pdo \
    pdo_pgsql \
    pgsql \
    redis \
    zip

WORKDIR /app

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY --from=node:latest /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node:latest /usr/local/bin/node /usr/local/bin/node

RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

FROM base AS dev

COPY ./.docker/php/php.ini /usr/local/etc/php/php.ini

RUN pecl install xdebug  \
    && docker-php-ext-enable xdebug

COPY ./.docker/supervisor/supervisord.dev.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

FROM base AS prod

COPY ./.docker/supervisor/supervisord.prod.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
