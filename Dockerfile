FROM php:7.4-apache

# Install necessary system dependencies and PHP extensions
RUN apt-get update && \
    apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy custom Apache configuration
COPY ./config/000-default.conf /etc/apache2/sites-available/000-default.conf

# Set the working directory
WORKDIR /var/www/html

# Copy application files
COPY ./web /var/www/html

# Ensure permissions are set correctly
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


