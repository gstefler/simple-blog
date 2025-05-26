FROM composer:2 AS composer-builder
WORKDIR /app
COPY composer.json composer.lock artisan ./
COPY routes routes
COPY bootstrap bootstrap
COPY app app
RUN composer install --ignore-platform-reqs --prefer-dist --no-interaction --optimize-autoloader

FROM node:22-alpine AS node-builder
WORKDIR /app
COPY package*.json .
RUN npm install

COPY --from=composer-builder /app ./
COPY resources resources
COPY public public
COPY vite.config.ts tsconfig.json ./
RUN npm run build

COPY config config
COPY database database
COPY storage/app storage/app
COPY storage/framework storage/framework
COPY .env.example .env
RUN mkdir "./storage/logs" && touch "./storage/logs/laravel.log"

FROM dunglas/frankenphp

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        mariadb-client \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        libzip-dev \
        unzip \
        git \
        curl && \
    docker-php-ext-install pdo_mysql pcntl && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /app
COPY --from=node-builder /app ./
EXPOSE 80
