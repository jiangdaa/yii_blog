FROM php:7.4-apache

# php:7.4 is Debian bullseye (EOL) — point apt at the archive mirror, drop security repo
RUN sed -i 's|deb.debian.org|archive.debian.org|g; s|security.debian.org|archive.debian.org|g' /etc/apt/sources.list \
    && sed -i '/debian-security/d' /etc/apt/sources.list \
    && echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99no-check-valid-until \
    && apt-get update && apt-get install -y --no-install-recommends \
        libpng-dev libjpeg62-turbo-dev libfreetype6-dev libzip-dev libicu-dev libonig-dev \
        unzip git default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql gd intl zip mbstring opcache \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-progress

COPY . /var/www/html
RUN php init --env=Development --overwrite=All \
    && sed -i "s/mysql:host=localhost/mysql:host=db/" common/config/main-local.php \
    && mkdir -p backend/web/assets frontend/web/assets backend/runtime frontend/runtime console/runtime \
    && chown -R www-data:www-data /var/www/html

COPY deploy/vhosts.conf /etc/apache2/conf-enabled/zz-vhosts.conf
COPY deploy/entrypoint.sh /usr/local/bin/blog-entrypoint
RUN chmod +x /usr/local/bin/blog-entrypoint

EXPOSE 8080 8081
ENTRYPOINT ["blog-entrypoint"]
