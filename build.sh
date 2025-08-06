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
    echo "2. Create wordpress/wp-config.php from wordpress/wp-config-sample.php"
    echo "3. Update wordpress/wp-config.php with your database credentials"
    echo "4. Start the development server: php -S localhost:8000 -t wordpress/"
    echo "5. Visit http://localhost:8000 to complete WordPress installation"
    echo ""
    echo "Note: For deployment, your environment should handle wp-config.php"
else
    echo "❌ Build failed! Please check the errors above."
    exit 1
fi 