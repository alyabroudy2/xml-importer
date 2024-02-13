FROM php:8.1-fpm

# Install additional PHP extensions (if needed)
RUN docker-php-ext-install pdo_mysql

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
# Set the working directory
WORKDIR /var/www

# Expose port 9000
EXPOSE 9000