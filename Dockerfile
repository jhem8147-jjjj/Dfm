
FROM php:5.3-apache@sha256:de95de8b4ea46b09cba512bf56c39f3b2521c3b46deeee197b3beaf5c6b3d5cb

# Configurar repositorios históricos de Debian Jessie
RUN echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99archive \
    && echo 'Acquire::AllowInsecureRepositories "true";' >> /etc/apt/apt.conf.d/99archive \
    && echo 'APT::Get::AllowUnauthenticated "true";' >> /etc/apt/apt.conf.d/99archive \
    && sed -i 's|http://http.debian.net/debian|http://archive.debian.org/debian|g' /etc/apt/sources.list \
    && sed -i 's|http://security.debian.org|http://archive.debian.org/debian-security|g' /etc/apt/sources.list \
    && sed -i '/jessie-updates/d' /etc/apt/sources.list

# Instalar herramientas de compilación
RUN apt-get update \
    && apt-get install -y --allow-unauthenticated \
        build-essential \
        autoconf \
        bison \
        re2c \
        libxml2-dev \
        apache2-dev \
        curl \
        ca-certificates \
    && rm -rf /var/lib/apt/lists/*

# Incorporar código fuente de PHP 5.3.29
RUN mkdir -p /usr/src/php-build

COPY php-5.3.29.tar.gz /usr/src/php-build/php.tar.gz

RUN cd /usr/src/php-build \
    && tar -xzf php.tar.gz

# Compilar PHP con mbstring
RUN cd /usr/src/php-build/php-5.3.29 \
    && ./configure \
        --disable-cgi \
        --with-apxs2=/usr/bin/apxs2 \
        --with-mysql \
        --with-mysqli \
        --with-pdo-mysql \
        --enable-mbstring=shared \
    && make -j2 \
    && make install

# Habilitar mbstring
RUN echo "extension=mbstring.so" >> /usr/local/lib/php.ini

# Habilitar Apache rewrite
RUN a2enmod rewrite

