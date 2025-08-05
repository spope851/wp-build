#!/bin/bash

# WordPress Build Script
# This script rebuilds the entire WordPress installation from Composer

echo "🚀 Starting WordPress build..."

# Run the PHP build script
php build.php

if [ $? -eq 0 ]; then
    echo "✅ Build completed successfully!"
    echo ""
    echo "Next steps:"
    echo "1. Set up your database (MySQL/MariaDB)"
    echo "2. Update web/wp-config.php with your database credentials"
    echo "3. Start the development server: php -S localhost:8000 -t web/"
    echo "4. Visit http://localhost:8000 to complete WordPress installation"
else
    echo "❌ Build failed! Please check the errors above."
    exit 1
fi 