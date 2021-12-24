FROM php:8.0-fpm

COPY ./docker/php/php.ini /usr/local/etc/php

# Composerのインストール
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# 環境変数の設定
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

#パッケージインストール
RUN apt-get update && \
    apt-get -y install \
    git \
    zip \
    unzip \
    vim && \
    docker-php-ext-install pdo_mysql bcmath


#Laravelインストール
RUN composer global require "laravel/installer"

#ワークディレクトリを移動
WORKDIR /var/www


