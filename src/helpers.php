<?php

use Carlxaeron\General\Helpers\GeneralMapsHelper;
use Carlxaeron\General\Helpers\GeneralMetaHelper;
use Illuminate\Database\Eloquent\Model;

if (!function_exists('get_related_models')) {
    /**
     * Get related models for any model instance
     *
     * @param Model $model
     * @param string $relatedType
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_related_models(Model $model, string $relatedType, string $relationshipType = 'general', ?string $relationshipKey = null)
    {
        return GeneralMapsHelper::getRelatedModels($model, $relatedType, $relationshipType, $relationshipKey);
    }
}

if (!function_exists('get_related_model')) {
    /**
     * Get a specific related model for any model instance
     *
     * @param Model $model
     * @param string $relatedType
     * @param int $relatedId
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return Model|null
     */
    function get_related_model(Model $model, string $relatedType, int $relatedId, string $relationshipType = 'general', ?string $relationshipKey = null)
    {
        return GeneralMapsHelper::getRelatedModel($model, $relatedType, $relatedId, $relationshipType, $relationshipKey);
    }
}

if (!function_exists('add_related_model')) {
    /**
     * Add a relationship for any model instance
     *
     * @param Model $model
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @param array $metadata
     * @param int $sortOrder
     * @return \Carlxaeron\General\Models\GeneralMap|null
     */
    function add_related_model(Model $model, Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null, array $metadata = [], int $sortOrder = 0)
    {
        return GeneralMapsHelper::addRelatedModel($model, $relatedModel, $relationshipType, $relationshipKey, $metadata, $sortOrder);
    }
}

if (!function_exists('remove_related_model')) {
    /**
     * Remove a relationship for any model instance
     *
     * @param Model $model
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return bool
     */
    function remove_related_model(Model $model, Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null): bool
    {
        return GeneralMapsHelper::removeRelatedModel($model, $relatedModel, $relationshipType, $relationshipKey);
    }
}

if (!function_exists('has_related_model')) {
    /**
     * Check if a relationship exists for any model instance
     *
     * @param Model $model
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return bool
     */
    function has_related_model(Model $model, Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null): bool
    {
        return GeneralMapsHelper::hasRelatedModel($model, $relatedModel, $relationshipType, $relationshipKey);
    }
}

if (!function_exists('get_mappable_models')) {
    /**
     * Get mappable models for any model instance
     *
     * @param Model $model
     * @param string $mappableType
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_mappable_models(Model $model, string $mappableType, string $relationshipType = 'general', ?string $relationshipKey = null)
    {
        return GeneralMapsHelper::getMappableModels($model, $mappableType, $relationshipType, $relationshipKey);
    }
}

if (!function_exists('get_relationship_metadata')) {
    /**
     * Get relationship metadata for any model instance
     *
     * @param Model $model
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return array
     */
    function get_relationship_metadata(Model $model, Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null): array
    {
        return GeneralMapsHelper::getRelationshipMetadata($model, $relatedModel, $relationshipType, $relationshipKey);
    }
}

if (!function_exists('set_relationship_metadata')) {
    /**
     * Set relationship metadata for any model instance
     *
     * @param Model $model
     * @param Model $relatedModel
     * @param array $metadata
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return \Carlxaeron\General\Models\GeneralMap|null
     */
    function set_relationship_metadata(Model $model, Model $relatedModel, array $metadata, string $relationshipType = 'general', ?string $relationshipKey = null)
    {
        return GeneralMapsHelper::setRelationshipMetadata($model, $relatedModel, $metadata, $relationshipType, $relationshipKey);
    }
}

if (!function_exists('toggle_relationship')) {
    /**
     * Toggle relationship for any model instance
     *
     * @param Model $model
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return bool
     */
    function toggle_relationship(Model $model, Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null): bool
    {
        return GeneralMapsHelper::toggleRelationship($model, $relatedModel, $relationshipType, $relationshipKey);
    }
}

if (!function_exists('get_relationship_types')) {
    /**
     * Get all relationship types for any model instance
     *
     * @param Model $model
     * @return \Illuminate\Support\Collection
     */
    function get_relationship_types(Model $model)
    {
        return GeneralMapsHelper::getRelationshipTypes($model);
    }
}

if (!function_exists('get_relationship_keys')) {
    /**
     * Get all relationship keys for any model instance
     *
     * @param Model $model
     * @param string $relationshipType
     * @return \Illuminate\Support\Collection
     */
    function get_relationship_keys(Model $model, string $relationshipType)
    {
        return GeneralMapsHelper::getRelationshipKeys($model, $relationshipType);
    }
}

if (!function_exists('find_by_relationship')) {
    /**
     * Find models by relationship
     *
     * @param string $modelClass
     * @param string $relatedType
     * @param int $relatedId
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function find_by_relationship(string $modelClass, string $relatedType, int $relatedId, string $relationshipType = 'general', ?string $relationshipKey = null)
    {
        return GeneralMapsHelper::findByRelationship($modelClass, $relatedType, $relatedId, $relationshipType, $relationshipKey);
    }
}

if (!function_exists('find_by_mappable')) {
    /**
     * Find models that have relationships with a specific model
     *
     * @param string $modelClass
     * @param string $mappableType
     * @param int $mappableId
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function find_by_mappable(string $modelClass, string $mappableType, int $mappableId, string $relationshipType = 'general', ?string $relationshipKey = null)
    {
        return GeneralMapsHelper::findByMappable($modelClass, $mappableType, $mappableId, $relationshipType, $relationshipKey);
    }
}

// General Meta Helper Functions

if (!function_exists('get_meta')) {
    /**
     * Get meta value for any model instance
     *
     * @param Model $model
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function get_meta(Model $model, string $key, $default = null)
    {
        return GeneralMetaHelper::getMeta($model, $key, $default);
    }
}

if (!function_exists('set_meta')) {
    /**
     * Set meta value for any model instance
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @return \Carlxaeron\General\Models\GeneralMeta|null
     */
    function set_meta(Model $model, string $key, $value, string $type = 'string')
    {
        return GeneralMetaHelper::setMeta($model, $key, $value, $type);
    }
}

if (!function_exists('has_meta')) {
    /**
     * Check if model has meta key
     *
     * @param Model $model
     * @param string $key
     * @return bool
     */
    function has_meta(Model $model, string $key): bool
    {
        return GeneralMetaHelper::hasMeta($model, $key);
    }
}

if (!function_exists('delete_meta')) {
    /**
     * Delete meta value for any model instance
     *
     * @param Model $model
     * @param string $key
     * @return bool
     */
    function delete_meta(Model $model, string $key): bool
    {
        return GeneralMetaHelper::deleteMeta($model, $key);
    }
}

if (!function_exists('get_all_meta')) {
    /**
     * Get all meta for a model as array
     *
     * @param Model $model
     * @return array
     */
    function get_all_meta(Model $model): array
    {
        return GeneralMetaHelper::getAllMeta($model);
    }
}

if (!function_exists('find_by_meta')) {
    /**
     * Search models by meta key and value
     *
     * @param string $modelClass
     * @param string $key
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function find_by_meta(string $modelClass, string $key, $value = null)
    {
        return GeneralMetaHelper::findByMeta($modelClass, $key, $value);
    }
}
