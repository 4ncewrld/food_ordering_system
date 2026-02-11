# ===== PHP with Apache base image =====
FROM php:8.2-apache

# ===== Enable mysqli and pdo_mysql extensions =====
RUN docker-php-ext-install mysqli pdo pdo_mysql

# ===== Set working directory =====
WORKDIR /var/www/html

# ===== Copy project files into container =====
COPY . /var/www/html/

# ===== Expose port 8080 (Railway default) =====
EXPOSE 8080

# ===== Start Apache in foreground =====
CMD ["apache2-foreground"]