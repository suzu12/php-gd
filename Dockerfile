# php のイメージ
FROM php:7.4-fpm

# コマンド実行ディレクトリ
WORKDIR /var/www/html

# パッケージインストール
RUN apt-get update \
  && apt-get install -y \
  git \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libonig-dev \
  libzip-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd
