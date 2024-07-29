FROM php:7.4-apache

# Install necessary system dependencies and PHP extensions
RUN apt-get update && \
    apt-get install -y \
    libpq-dev \
    netcat \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy custom Apache configuration
COPY ./config/000-default.conf /etc/apache2/sites-available/000-default.conf

# Set the working directory
WORKDIR /var/www/html

# Copy the wait-for-it.sh script and set the permission
COPY ./wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh

# Ensure permissions are set correctly
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set COMPOSER_ALLOW_SUPERUSER environment variable
ENV COMPOSER_ALLOW_SUPERUSER 1

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

# Install Firebase JWT package
# RUN composer require firebase/php-jwt:^v6.1.0

# Expose port 80
EXPOSE 80

# Run migrations, seeders, and start Apache
CMD ["sh", "-c", "/usr/local/bin/wait-for-it.sh db -- php /var/www/html/migrations/migrate.php && php /var/www/html/migrations/seed_users.php && apache2-foreground"]