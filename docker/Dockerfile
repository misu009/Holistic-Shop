FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip cron supervisor libpng-dev libonig-dev libxml2-dev \
    libzip-dev libcurl4-openssl-dev pkg-config libssl-dev \
    nodejs npm \
    && rm -rf /var/lib/apt/lists/*

# Add PHP repository for PHP 8.3 extensions
RUN apt-get update && apt-get install -y \
    lsb-release apt-transport-https ca-certificates \
    && curl -sSL https://packages.sury.org/php/apt.gpg | tee /etc/apt/trusted.gpg.d/sury.asc \
    && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/sury.list \
    && apt-get update

# Install PHP extensions
RUN apt-get install -y \
    php8.3-mysql php8.3-mbstring php8.3-xml php8.3-bcmath php8.3-gd php8.3-soap php8.3-intl \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install npm dependencies and build assets
RUN npm install && npm run build

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Laravel setup
RUN php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan storage:link && \
    php artisan migrate:fresh --seed --force

# Copy cron job
COPY ./docker/laravel-cron /etc/cron.d/laravel-cron

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/laravel-cron

# Apply cron job
RUN crontab /etc/cron.d/laravel-cron

# Copy supervisor configuration
COPY ./docker/supervisord.conf /etc/supervisord.conf

# Start supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
