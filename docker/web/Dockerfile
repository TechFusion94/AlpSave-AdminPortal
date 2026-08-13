FROM php:8.4.12-apache-bookworm

# Install Node.js from official source
RUN apt-get update && apt-get install -y \
    curl \
    ca-certificates \
    gnupg \
    lsb-release \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
#    && npm install -g npm@latest \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install system libraries for PDO/MySQL and Xdebug via PECL
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
      default-mysql-client \
      libzip-dev \
      libcurl4-openssl-dev \
      libicu-dev \
      unzip \
      openssl \
      bash-completion \
      nano \
      less \
      pkg-config \
      build-essential \
      libpng-dev \
      zlib1g-dev \
 && pecl install xdebug \
 && docker-php-ext-enable xdebug \
 && rm -rf /var/lib/apt/lists/*

# Build PHP extensions: PDO and MySQL drivers
RUN docker-php-ext-install \
      pdo \
      pdo_mysql \
      mysqli \
      bcmath \
      curl \
      zip \
      intl \
      gd \
      exif \
      opcache

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer \
| php -- --install-dir=/usr/local/bin --filename=composer --version=2.8.1

# Enable Apache modules
RUN a2enmod rewrite ssl headers status

# Set the working directory
WORKDIR /var/www/html

# Copy and configure the entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod 755 /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
