#!/bin/bash

echo "🚀 Installing Carlxaeron General Package via Composer..."

# Check if we're in a Laravel project
if [ ! -f "artisan" ]; then
    echo "❌ Error: This doesn't appear to be a Laravel project. Please run this script from your Laravel project root."
    exit 1
fi

# Check if composer is available
if ! command -v composer &> /dev/null; then
    echo "❌ Error: Composer is not installed or not in PATH."
    exit 1
fi

echo "📦 Adding package to composer.json..."
composer require carlxaeron/general

echo "🔧 Publishing configuration..."
php artisan vendor:publish --tag=general-config

echo "🗄️ Publishing migrations..."
php artisan vendor:publish --tag=general-migrations

echo "📊 Running migrations..."
php artisan migrate

echo "✅ Installation complete!"
echo ""
echo "📚 Next steps:"
echo "1. Add the traits to your models:"
echo "   use Carlxaeron\\General\\Traits\\HasGeneralMaps;"
echo "   use Carlxaeron\\General\\Traits\\HasGeneralMeta;"
echo ""
echo "2. Check the README.md for usage examples"
echo "3. Run tests: composer test"
echo ""
echo "🎉 Happy coding!"

