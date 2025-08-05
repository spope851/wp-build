# WordPress Build Testing Guide

This guide shows you how to test your WordPress build project.

## Quick Test

Run the automated test script:

```bash
php test-build.php
```

## Manual Testing Steps

### 1. Verify Project Structure

```bash
# Check the main directories
ls -la
ls -la web/
ls -la web/wp-content/plugins/
```

### 2. Test WordPress Core

```bash
# Check WordPress version
vendor/bin/wp core version --path=web/

# Check WordPress status
vendor/bin/wp core is-installed --path=web/
```

### 3. Test Installed Plugins

```bash
# List installed plugins
vendor/bin/wp plugin list --path=web/

# Check plugin status
vendor/bin/wp plugin status --path=web/
```

### 4. Test with Local Server

Start a local PHP server to test the WordPress installation:

```bash
# Start server in the web directory
cd web
php -S localhost:8000

# Or from the project root
php -S localhost:8000 -t web/
```

Then visit: http://localhost:8000

### 5. Database Setup (Optional)

If you want to test with a real database:

1. Create a MySQL database named `wp_test`
2. Update `web/wp-config.php` with your database credentials
3. Run WordPress installation:

```bash
vendor/bin/wp core install --path=web/ \
  --url=localhost:8000 \
  --title="Test Site" \
  --admin_user=admin \
  --admin_password=password \
  --admin_email=admin@example.com
```

### 6. Test Plugin Functionality

```bash
# Activate plugins
vendor/bin/wp plugin activate woocommerce --path=web/
vendor/bin/wp plugin activate contact-form-7 --path=web/
vendor/bin/wp plugin activate wordpress-seo --path=web/

# Check plugin status
vendor/bin/wp plugin list --status=active --path=web/
```

## Development Testing

### Adding New Plugins

```bash
# Install a new plugin
composer require wpackagist-plugin/plugin-name

# Update all plugins
composer update
```

### Testing Custom Code

Add your custom code to the `src/` directory and it will be autoloaded.

### Running Tests

```bash
# Run the build test
php test-build.php

# Check for any issues
vendor/bin/wp core verify-checksums --path=web/
```

## Troubleshooting

### Common Issues

1. **Plugins not installing in correct location**: Check `composer.json` installer-paths
2. **WordPress not loading**: Verify `web/wp-config.php` exists and is configured
3. **Permission issues**: Ensure web server can read/write to `web/wp-content/`

### Debug Mode

WordPress debug mode is enabled in `web/wp-config.php`. Check `web/wp-content/debug.log` for errors.

## Production Testing

Before deploying:

1. Set `WP_DEBUG` to `false` in `web/wp-config.php`
2. Update database credentials for production
3. Test all functionality in a staging environment
4. Run security checks with WP-CLI

## Continuous Integration

Add this to your CI pipeline:

```bash
# Install dependencies
composer install --no-dev --optimize-autoloader

# Run tests
php test-build.php

# Verify WordPress integrity
vendor/bin/wp core verify-checksums --path=web/
``` 