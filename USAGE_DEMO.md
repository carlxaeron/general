# Usage Demonstration

This file demonstrates how to use the Carlxaeron General Package in your Laravel project.

## Quick Start

### 1. Install the Package

```bash
# From your Laravel project root
composer require carlxaeron/general
```

### 2. Publish Configuration and Migrations

```bash
php artisan vendor:publish --tag=general-config
php artisan vendor:publish --tag=general-migrations
```

### 3. Run Migrations

```bash
php artisan migrate
```

## Basic Usage Examples

### Example 1: User Friends System

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carlxaeron\General\Traits\HasGeneralMaps;
use Carlxaeron\General\Traits\HasGeneralMeta;

class User extends Model
{
    use HasGeneralMaps, HasGeneralMeta;

    protected $fillable = ['name', 'email'];
}

// Usage in your application:
$user1 = User::create(['name' => 'John', 'email' => 'john@example.com']);
$user2 = User::create(['name' => 'Jane', 'email' => 'jane@example.com']);

// Add a friend relationship
$user1->addRelatedModel($user2, 'friend', 'best_friend', ['since' => '2020']);

// Get all friends
$friends = $user1->getRelatedModels(User::class, 'friend');

// Get best friends specifically
$bestFriends = $user1->getRelatedModels(User::class, 'friend', 'best_friend');

// Check if someone is a friend
if ($user1->hasRelatedModel($user2, 'friend')) {
    echo "They are friends!";
}

// Set user preferences
$user1->setGeneralMeta('theme', 'dark', 'string');
$user1->setGeneralMeta('notifications', true, 'boolean');

// Get user preferences
$theme = $user1->getGeneralMeta('theme', 'light'); // defaults to 'light' if not set
```

### Example 2: Product Categories

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carlxaeron\General\Traits\HasGeneralMaps;
use Carlxaeron\General\Traits\HasGeneralMeta;

class Product extends Model
{
    use HasGeneralMaps, HasGeneralMeta;

    protected $fillable = ['name', 'price'];
}

class Category extends Model
{
    use HasGeneralMaps;

    protected $fillable = ['name'];
}

// Usage:
$product = Product::create(['name' => 'Laptop', 'price' => 999.99]);
$category = Category::create(['name' => 'Electronics']);

// Add product to category
$product->addRelatedModel($category, 'category', 'main');

// Add product metadata
$product->setGeneralMeta('weight', 2.5, 'float');
$product->setGeneralMeta('dimensions', ['width' => 15, 'height' => 10], 'array');

// Get products in category
$products = $category->getMappableModels(Product::class, 'category', 'main');

// Get product metadata
$weight = $product->getGeneralMeta('weight');
$dimensions = $product->getGeneralMeta('dimensions');
```

### Example 3: Using Helper Functions

```php
<?php

// General Maps Helper Functions
$relatedUsers = get_related_models($user, User::class, 'friend');
$friend = get_related_model($user, User::class, $friendId, 'friend');
add_related_model($user, $friend, 'friend', 'best_friend', ['since' => '2020']);
remove_related_model($user, $friend, 'friend');
$hasFriend = has_related_model($user, $friend, 'friend');

// General Meta Helper Functions
$value = get_meta($user, 'preference', 'default_value');
set_meta($user, 'preference', 'dark_theme', 'string');
$hasPreference = has_meta($user, 'preference');
delete_meta($user, 'preference');
$allMeta = get_all_meta($user);
```

## Advanced Usage

### Custom Relationship Types

```php
// Create different types of relationships
$user->addRelatedModel($company, 'company', 'employer');
$user->addRelatedModel($school, 'institution', 'alumni');
$user->addRelatedModel($project, 'project', 'contributor');

// Get relationships by type
$employers = $user->getRelatedModels(Company::class, 'company');
$schools = $user->getRelatedModels(Institution::class, 'institution');
$projects = $user->getRelatedModels(Project::class, 'project');
```

### Relationship Metadata

```php
// Add metadata to relationships
$user->addRelatedModel($friend, 'friend', 'best_friend', [
    'since' => '2020',
    'met_at' => 'school',
    'shared_interests' => ['coding', 'music']
]);

// Get and update relationship metadata
$metadata = $user->getRelationshipMetadata($friend, 'friend');
$user->setRelationshipMetadata($friend, [
    'since' => '2020',
    'met_at' => 'school',
    'shared_interests' => ['coding', 'music', 'sports']
], 'friend');
```

### Finding Models by Relationships

```php
// Find all users who are friends with a specific user
$friendsOfUser = find_by_mappable(User::class, User::class, $userId, 'friend');

// Find all products in a specific category
$productsInCategory = find_by_relationship(Product::class, Category::class, $categoryId, 'category');

// Find all users with a specific preference
$usersWithTheme = find_by_meta(User::class, 'theme', 'dark');
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

## Best Practices

1. **Use meaningful relationship types**: Instead of just 'general', use descriptive types like 'friend', 'category', 'employer', etc.

2. **Use relationship keys**: When you need to distinguish between different types of the same relationship (e.g., 'best_friend' vs 'colleague').

3. **Store metadata efficiently**: Use the metadata field for relationship-specific data that doesn't warrant its own table.

4. **Use helper functions**: The global helper functions make your code more readable and consistent.

5. **Cache when appropriate**: Enable caching for frequently accessed relationships and metadata.

## Troubleshooting

### Common Issues

1. **Trait not found**: Make sure you've added the traits to your models and the package is properly installed.

2. **Table doesn't exist**: Run the migrations to create the necessary database tables.

3. **Helper functions not available**: Make sure the service provider is registered and the helpers file is loaded.

### Debugging

```php
// Check if a model has the traits
if (method_exists($user, 'generalMaps')) {
    echo "User has general maps functionality";
}

if (method_exists($user, 'generalMeta')) {
    echo "User has general meta functionality";
}

// Check relationship existence
$hasRelationship = $user->hasRelatedModel($friend, 'friend');
var_dump($hasRelationship);

// Check meta existence
$hasMeta = $user->hasGeneralMeta('theme');
var_dump($hasMeta);
```

## Performance Tips

1. **Use indexes**: The package automatically creates database indexes for better performance.

2. **Limit relationship queries**: Use relationship types and keys to narrow down queries.

3. **Cache frequently accessed data**: Enable caching for read-heavy applications.

4. **Use eager loading**: When possible, eager load relationships to avoid N+1 queries.

## Support

For more information, check the README.md file or create an issue on the package repository.
