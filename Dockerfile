FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    vim \
    unzip \
    libicu-dev \
    sqlite3 \
    libsqlite3-dev \
    libgd-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev

# Configure and install PHP extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql intl

# Install GD with JPEG and FreeType support
RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install gd

# Enable GD extension
RUN docker-php-ext-enable gd

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHPUnit globally
RUN curl -L https://phar.phpunit.de/phpunit-10.1.phar -o /usr/local/bin/phpunit \
    && chmod +x /usr/local/bin/phpunit

# Set the working directory
WORKDIR /var/www/html/

# Copy your application code into the container
COPY ./expense-approval /var/www/html/

# Expose the port PHP-FPM is running on
EXPOSE 9002

# Default command to run the application
CMD ["php-fpm"]
