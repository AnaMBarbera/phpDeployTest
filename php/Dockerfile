FROM php:8.4-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    libonig-dev \
    libssl-dev \
    libmongoc-1.0-0 \
    libjemalloc2 \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo pdo_mysql zip xml ctype

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Configuración de PHP
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# Directorio de trabajo
WORKDIR /var/www/html


# Copiar entrypoint personalizado
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Usar entrypoint y comando por defecto
ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]


