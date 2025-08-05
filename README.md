# WordPress Build Project

A modern WordPress development setup using Composer for dependency management and a clean build process.

## 🚀 Quick Start

### 1. Clone and Build
```bash
git clone <your-repo>
cd wp-build
./build.sh
```

### 2. Set up Database
Create a MySQL database and update `web/wp-config.php` with your credentials.

### 3. Start Development Server
```bash
php -S localhost:8000 -t web/
```

Visit http://localhost:8000 to complete WordPress installation.

## 📁 Project Structure

```
wp-build/
├── composer.json          # Dependencies and configuration
├── composer.lock          # Locked versions (committed)
├── .gitignore            # Ignores generated files
├── build.php             # Build script
├── build.sh              # Build shell script
├── src/                  # Your custom code (committed)
│   ├── bootstrap.php     # WordPress initialization
│   ├── CustomPlugin.php  # Main custom plugin
│   ├── Utilities/        # Helper functions
│   └── Features/         # Custom features
├── vendor/               # Composer packages (ignored)
└── web/                  # WordPress installation (ignored)
    ├── wp-admin/         # WordPress admin
    ├── wp-includes/      # WordPress core
    ├── wp-content/       # Plugins and themes
    └── wp-config.php     # WordPress configuration
```

## 🔧 Development Workflow

### Adding Plugins
```bash
composer require wpackagist-plugin/plugin-name
./build.sh
```

### Adding Custom Code
1. Add your classes to `src/`
2. Initialize them in `src/bootstrap.php`
3. The code is automatically loaded by WordPress

### Rebuilding WordPress
```bash
./build.sh
```

This completely rebuilds the WordPress installation from Composer dependencies.

## 🎯 Key Features

- **Composer-managed**: All dependencies managed through Composer
- **Clean builds**: Entire WordPress installation rebuilt from scratch
- **Custom code**: Your code in `src/` automatically loaded
- **Version controlled**: Only source code and configuration committed
- **Development ready**: Debug mode enabled, file editing disabled

## 📦 Installed Plugins

- **WooCommerce**: E-commerce functionality
- **Contact Form 7**: Contact forms
- **Yoast SEO**: Search engine optimization

## 🛠️ Custom Code

Your custom code goes in the `src/` directory and is automatically loaded by WordPress.

### Example Custom Feature
```php
// src/Features/SocialSharing.php
namespace Spenpo\WpBuild\Features;

class SocialSharing {
    public function __construct() {
        add_filter('the_content', [$this, 'add_social_buttons']);
    }
}
```

### Initializing Custom Code
```php
// src/bootstrap.php
new Features\SocialSharing();
```

## 🧪 Testing

### Run Build Tests
```bash
php test-build.php
```

### Run Source Code Tests
```bash
php test-src.php
```

### Test Without Database
```bash
php test-no-db.php
```

## 🔄 Build Process

The build script (`build.php`) does the following:

1. **Cleans up**: Removes existing WordPress installation
2. **Installs dependencies**: Runs `composer install`
3. **Sets up structure**: Moves files to `web/` directory
4. **Creates configuration**: Generates `wp-config.php` with security keys
5. **Creates directories**: Sets up uploads, cache, etc.
6. **Sets permissions**: Ensures proper file permissions
7. **Verifies installation**: Checks all required files exist

## 🚫 What's Ignored

The `.gitignore` file excludes:
- `web/` - Entire WordPress installation
- `vendor/` - Composer packages
- `composer.lock` - Optional (some teams commit this)
- Uploads, cache, and logs
- Environment-specific files

## 🔒 Security

- WordPress security keys are randomly generated on each build
- File editing is disabled in admin
- Automatic updates are disabled
- Debug logging is enabled for development

## 📚 Documentation

- [TESTING.md](TESTING.md) - Comprehensive testing guide
- [WordPress Codex](https://codex.wordpress.org/) - WordPress documentation
- [Composer Documentation](https://getcomposer.org/doc/) - Composer documentation

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Add your custom code to `src/`
4. Test with `./build.sh`
5. Submit a pull request

## 📄 License

MIT License - see LICENSE file for details. 