# Base image PHP + Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install ekstensi PHP yang dibutuhkan Yii2
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install zip

# Aktifkan mod_rewrite untuk pretty URL
RUN a2enmod rewrite

# Set DocumentRoot ke folder 'web'
ENV APACHE_DOCUMENT_ROOT /var/www/html/web
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Copy seluruh aplikasi ke container
COPY . /var/www/html

# Pastikan folder runtime & web/assets bisa ditulis Apache
RUN mkdir -p /var/www/html/runtime /var/www/html/web/assets \
    && chown -R www-data:www-data /var/www/html/runtime /var/www/html/web/assets \
    && chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
