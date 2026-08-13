#!/bin/bash
set -e

# Install npm packages if needed
if [ -f package.json ]; then
    if [ ! -d node_modules ] || [ package.json -nt node_modules ]; then
        echo "Installing npm packages..."
        npm install
    else
        echo "npm packages up to date"
    fi
fi

# Install Composer dependencies if needed
if [ -f composer.json ]; then
    if [ ! -d vendor ] || [ composer.json -nt vendor ]; then
        echo "Installing Composer dependencies..."
        composer install --no-interaction --prefer-dist --optimize-autoloader
    else
        echo "Composer dependencies up to date"
    fi
fi

# Start Apache
exec apache2-foreground
