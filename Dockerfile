# Base image
FROM php:8.2-cli

# Set working directory
WORKDIR /app

# Copy project files
COPY . /app

# Expose port 8080 (Railway default for HTTP)
EXPOSE 8080

# Start PHP built-in server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]