# Use PHP with Apache and mysqli
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Enable mysqli extension
RUN docker-php-ext-install mysqli

# Expose port 8080 (Railway default)
EXPOSE 8080

# Start Apache server (default CMD already works)