<?php

return [
    /*
    |--------------------------------------------------------------------------
    | General Package Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the General package
    | including table names and default settings.
    |
    */

    // Table names
    'tables' => [
        'general_maps' => 'general_maps',
        'general_meta' => 'general_meta',
    ],

    // Default relationship type
    'default_relationship_type' => 'general',

    // Default sort order
    'default_sort_order' => 0,

    // Default active status
    'default_is_active' => true,

    // Maximum string lengths for database columns
    'max_lengths' => [
        'mappable_type' => 100,
        'related_type' => 100,
        'relationship_type' => 100,
        'relationship_key' => 100,
    ],

    // Cache settings
    'cache' => [
        'enabled' => env('GENERAL_CACHE_ENABLED', false),
        'ttl' => env('GENERAL_CACHE_TTL', 3600), // 1 hour
    ],
];

