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

# 安装 composer 1.10（与 composer.lock 版本兼容；不走 docker hub 镜像，避免拉取失败）
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer --version=1.10.27 \
    && rm composer-setup.php

WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-progress

COPY . /var/www/html
RUN php init --env=Development --overwrite=All \
    && sed -i "s/mysql:host=localhost/mysql:host=db/" common/config/main-local.php \
    && mkdir -p backend/web/assets frontend/web/assets backend/runtime frontend/runtime console/runtime \
    && chown -R www-data:www-data /var/www/html

# backend/web/backend/ 在 .gitignore 中且从未提交 — 从已提交的前端资源恢复，并补齐缺失的 css/上传目录
RUN mkdir -p backend/web/backend/plugins backend/web/backend/css \
        backend/web/backend/images backend/web/backend/js \
        backend/web/backend/blog_cover backend/web/backend/link_logo \
    && cp -a frontend/web/frontend/plugins/layui backend/web/backend/plugins/layui \
    && cp -a frontend/web/frontend/plugins/font-awesome backend/web/backend/plugins/font-awesome \
    && cp frontend/web/frontend/css/animate.min.css backend/web/backend/plugins/animate.min.css \
    && cp frontend/web/frontend/images/Logo_40.png backend/web/backend/images/Logo_40.png
COPY deploy/backend-web/css/ backend/web/backend/css/
COPY deploy/backend-web/js/ backend/web/backend/js/
RUN chown -R www-data:www-data /var/www/html/backend/web/backend

COPY deploy/vhosts.conf /etc/apache2/conf-enabled/zz-vhosts.conf
COPY deploy/entrypoint.sh /usr/local/bin/blog-entrypoint
RUN chmod +x /usr/local/bin/blog-entrypoint

EXPOSE 8080 8081
ENTRYPOINT ["blog-entrypoint"]
