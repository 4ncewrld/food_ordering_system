# Step 1: Base image PHP + Apache
FROM php:8.2-apache

# Step 2: Set working directory inside container
WORKDIR /var/www/html/food

# Step 3: Copy all project files into container
COPY . .

# Step 4: Enable Apache mod_rewrite (optional, useful for clean URLs)
RUN a2enmod rewrite

# Step 5: Install mysqli extension for PHP (required for MySQL)
RUN docker-php-ext-install mysqli

# Step 6: Expose default Apache port
EXPOSE 80

# Step 7: Start Apache in foreground
CMD ["apache2-foreground"]