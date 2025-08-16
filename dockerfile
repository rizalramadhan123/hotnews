# Gunakan PHP 8.1 + Apache official image
FROM php:8.1-apache

# Install ekstensi PHP yang sering dipakai Yii2
RUN docker-php-ext-install pdo pdo_mysql mbstring opcache

# Enable Apache mod_rewrite (dibutuhkan Yii2 untuk routing)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy source code Yii2 ke container
COPY . /var/www/html

# Set permission agar Yii2 bisa publish asset & write runtime
RUN chown -R www-data:www-data /var/www/html/runtime /var/www/html/web/assets \
    && chmod -R 775 /var/www/html/runtime /var/www/html/web/assets

# Expose port 80
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
