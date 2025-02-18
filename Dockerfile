FROM php:8.3-apache

LABEL maintainer="getlaminas.org" \
    org.label-schema.docker.dockerfile="/Dockerfile" \
    org.label-schema.name="Laminas MVC Skeleton" \
    org.label-schema.url="https://docs.getlaminas.org/mvc/" \
    org.label-schema.vcs-url="https://github.com/laminas/laminas-mvc-skeleton"

# Actualizar paquetes
RUN apt-get update && apt-get install -y \
    git \
    zlib1g-dev \
    libzip-dev \
    libicu-dev \
    && apt-get clean

# Habilitar módulos de Apache
RUN a2enmod rewrite

# Configurar Apache para permitir .htaccess y reescritura
RUN printf "<VirtualHost *:80>\n\
    DocumentRoot /var/www/public\n\
    <Directory \"/var/www/public\">\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>\n" > /etc/apache2/sites-available/000-default.conf

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install zip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# Configurar el directorio de trabajo
WORKDIR /var/www

# Copiar archivos del proyecto (composer.json y composer.lock)
COPY composer.json composer.lock ./

# Instalar dependencias con Composer
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Exponer el puerto 80 para la web
EXPOSE 80

# Iniciar Apache en primer plano
CMD ["apache2-foreground"]

