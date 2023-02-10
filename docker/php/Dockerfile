FROM php:7.2-cli
COPY . /var/www
WORKDIR /var/www

RUN apt-get update && \
  apt-get install -y \
  curl \
  git \
  gnupg \
  unzip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer