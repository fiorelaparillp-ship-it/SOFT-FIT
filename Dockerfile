FROM php:8.2-apache

WORKDIR /var/www/html

COPY . .

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Crear la carpeta uploads por si no existe
RUN mkdir -p /var/www/html/uploads

# Dar permisos de escritura
RUN chown -R www-data:www-data /var/www/html/uploads
RUN chmod -R 775 /var/www/html/uploads

EXPOSE 80