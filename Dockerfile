FROM php:8.2-fpm-alpine

# Install dependencies for PHP extensions if needed
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    libzip-dev \
    tzdata

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip

# Set PHP timezone
RUN echo "date.timezone=Asia/Ho_Chi_Minh" > /usr/local/etc/php/conf.d/timezone.ini

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY public_html /var/www/html

# Set permissions for Bludit
RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000
CMD ["php-fpm"]
