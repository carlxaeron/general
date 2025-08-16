# Carlxaeron General Package

A Laravel package providing general mapping and meta functionality for flexible model relationships and metadata management.

## Features

- **General Maps**: Create flexible, polymorphic relationships between any models
- **General Meta**: Add custom metadata to any model
- **Helper Functions**: Global helper functions for easy access
- **Traits**: Easy-to-use traits for models
- **Configurable**: Customizable table names and settings
- **Laravel 10/11/12 Compatible**: Works with modern Laravel versions

## Installation

### Via Composer

```bash
composer require carlxaeron/general
```

### Manual Installation

1. Clone or download this package to your project
2. Add the package to your `composer.json`:

```json
{
    "require": {
        "carlxaeron/general": "*"
    }
}
```

3. Run `composer install`

## Setup

### 1. Publish Configuration (Optional)

```bash
php artisan vendor:publish --tag=general-config
```

This will publish the configuration file to `config/general.php`.

### 2. Publish Migrations (Optional)

```bash
php artisan vendor:publish --tag=general-migrations
```

This will publish the migrations to your `database/migrations` folder.

### 3. Run Migrations

```bash
php artisan migrate
```

## Usage

### Using Traits

#### HasGeneralMaps Trait

Add the `HasGeneralMaps` trait to any model you want to have relationships with other models:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carlxaeron\General\Traits\HasGeneralMaps;

class User extends Model
{
    use HasGeneralMaps;

    // ... your model code
}
```

#### HasGeneralMeta Trait

Add the `HasGeneralMeta` trait to any model you want to have metadata:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carlxaeron\General\Traits\HasGeneralMeta;

class User extends Model
{
    use HasGeneralMeta;

    // ... your model code
}
```

### Helper Functions

The package provides global helper functions for easy access to functionality:

#### General Maps Functions

```php
// Get related models
$relatedUsers = get_related_models($user, User::class, 'friend');

// Get a specific related model
$friend = get_related_model($user, User::class, $friendId, 'friend');

// Add a relationship
add_related_model($user, $friend, 'friend', 'best_friend', ['since' => '2020']);

// Remove a relationship
remove_related_model($user, $friend, 'friend');

// Check if relationship exists
if (has_related_model($user, $friend, 'friend')) {
    // Relationship exists
}

// Get relationship metadata
$metadata = get_relationship_metadata($user, $friend, 'friend');

// Set relationship metadata
set_relationship_metadata($user, $friend, ['since' => '2020'], 'friend');

// Toggle relationship
toggle_relationship($user, $friend, 'friend');

// Get all relationship types
$types = get_relationship_types($user);

// Get all relationship keys for a type
$keys = get_relationship_keys($user, 'friend');

// Find models by relationship
$users = find_by_relationship(User::class, User::class, $friendId, 'friend');

// Find models that have relationships with a specific model
$users = find_by_mappable(User::class, User::class, $friendId, 'friend');
```

#### General Meta Functions

```php
// Get meta value
$value = get_meta($user, 'preference', 'default_value');

// Set meta value
set_meta($user, 'preference', 'dark_theme', 'string');

// Check if meta exists
if (has_meta($user, 'preference')) {
    // Meta exists
}

// Delete meta
delete_meta($user, 'preference');

// Get all meta
$allMeta = get_all_meta($user);

// Find models by meta
$users = find_by_meta(User::class, 'theme', 'dark');
```

### Direct Model Methods

When using the traits, you can also call methods directly on your models:

```php
// General Maps
$user->getRelatedModels(User::class, 'friend');
$user->addRelatedModel($friend, 'friend');
$user->hasRelatedModel($friend, 'friend');

// General Meta
$user->getGeneralMeta('theme');
$user->setGeneralMeta('theme', 'dark');
$user->hasGeneralMeta('theme');
```

## Configuration

The package configuration file (`config/general.php`) allows you to customize:

- Table names
- Default relationship types
- Default sort orders
- Default active status
- Maximum string lengths for database columns
- Cache settings

```php
return [
    'tables' => [
        'general_maps' => 'general_maps',
        'general_meta' => 'general_meta',
    ],
    'default_relationship_type' => 'general',
    'default_sort_order' => 0,
    'default_is_active' => true,
    'max_lengths' => [
        'mappable_type' => 100,
        'related_type' => 100,
        'relationship_type' => 100,
        'relationship_key' => 100,
    ],
    'cache' => [
        'enabled' => env('GENERAL_CACHE_ENABLED', false),
        'ttl' => env('GENERAL_CACHE_TTL', 3600),
    ],
];
```

## Database Schema

### General Maps Table

```sql
CREATE TABLE general_maps (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mappable_type VARCHAR(100) NOT NULL,
    mappable_id BIGINT UNSIGNED NOT NULL,
    related_type VARCHAR(100) NOT NULL,
    related_id BIGINT UNSIGNED NOT NULL,
    relationship_type VARCHAR(100) DEFAULT 'general',
    relationship_key VARCHAR(100) NULL,
    metadata JSON NULL,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    UNIQUE KEY unique_general_map (
        mappable_type, mappable_id, related_type, related_id, 
        relationship_type, relationship_key
    ),
    
    INDEX idx_mappable (mappable_type, mappable_id, relationship_type),
    INDEX idx_related (related_type, related_id, relationship_type),
    INDEX idx_relationship (relationship_type, is_active)
);
```

### General Meta Table

```sql
CREATE TABLE general_meta (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    metable_type VARCHAR(255) NOT NULL,
    metable_id BIGINT UNSIGNED NOT NULL,
    `key` VARCHAR(255) NOT NULL,
    value TEXT NULL,
    type VARCHAR(255) DEFAULT 'string',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    UNIQUE KEY unique_meta (metable_type, metable_id, `key`)
);
```

## Examples

### User Friends System

```php
class User extends Model
{
    use HasGeneralMaps, HasGeneralMeta;
}

// Add a friend
$user->addRelatedModel($friend, 'friend', 'best_friend', ['since' => '2020']);

// Get all friends
$friends = $user->getRelatedModels(User::class, 'friend');

// Get best friends
$bestFriends = $user->getRelatedModels(User::class, 'friend', 'best_friend');

// Check if someone is a friend
if ($user->hasRelatedModel($friend, 'friend')) {
    echo "They are friends!";
}
```

### Product Categories with Metadata

```php
class Product extends Model
{
    use HasGeneralMaps, HasGeneralMeta;
}

class Category extends Model
{
    use HasGeneralMaps;
}

// Add product to category
$product->addRelatedModel($category, 'category', 'main');

// Add metadata to product
$product->setGeneralMeta('weight', 500, 'integer');
$product->setGeneralMeta('dimensions', ['width' => 10, 'height' => 20], 'array');

// Get products in category
$products = $category->getMappableModels(Product::class, 'category', 'main');

// Get product metadata
$weight = $product->getGeneralMeta('weight');
$dimensions = $product->getGeneralMeta('dimensions');
```

## Testing

```bash
composer test
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

If you have any questions or need help, please open an issue on GitHub or contact the maintainer.

## Changelog

### 1.0.0
- Initial release
- General Maps functionality
- General Meta functionality
- Helper functions
- Laravel 10/11 compatibility

