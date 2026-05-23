FROM php:8.0-apache

# Cài extension MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Bật mod_rewrite Apache
RUN a2enmod rewrite

# Cấu hình Apache cho phép .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copy toàn bộ source vào web root
COPY . /var/www/html/

# Cấp quyền cho thư mục assets/images (upload ảnh)
RUN chown -R www-data:www-data /var/www/html/assets/images \
    && chmod -R 775 /var/www/html/assets/images

EXPOSE 80