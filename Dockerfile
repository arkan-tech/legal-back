FROM php:8.2-fpm

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN echo "max_multipart_body_parts = 10000" >> /usr/local/etc/php/php.ini
RUN echo "max_input_vars = 10000" >> /usr/local/etc/php/php.ini
RUN echo "post_max_size = 100M" >> /usr/local/etc/php/php.ini
RUN echo "upload_max_filesize = 100M" >> /usr/local/etc/php/php.ini

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    nginx \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    libzip-dev \
    jpegoptim optipng pngquant gifsicle \
    vim unzip git curl \
    nodejs npm \
    procps \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip bcmath \
    && pecl install redis \
    && docker-php-ext-enable redis

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY nginx.conf /etc/nginx/nginx.conf

COPY . /var/www/html

RUN composer install --optimize-autoloader --no-dev

RUN npm install && npm run build

EXPOSE 80
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
