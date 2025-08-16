<?php

namespace Carlxaeron\General\Helpers;

use Carlxaeron\General\Models\GeneralMap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

/**
 * GeneralMapsHelper
 *
 * Provides global helper functions for working with GeneralMaps
 */
class GeneralMapsHelper
{
    /**
     * Get related models for any model instance
     *
     * @param Model $model
     * @param string $relatedType
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return Collection
     */
    public static function getRelatedModels(Model $model, string $relatedType, string $relationshipType = 'general', ?string $relationshipKey = null): Collection
    {
        if (!method_exists($model, 'generalMaps')) {
            return new Collection([]);
        }

        return $model->getRelatedModels($relatedType, $relationshipType, $relationshipKey);
    }

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
    public static function getRelatedModel(Model $model, string $relatedType, int $relatedId, string $relationshipType = 'general', ?string $relationshipKey = null): ?Model
    {
        if (!method_exists($model, 'generalMaps')) {
            return null;
        }

        return $model->getRelatedModel($relatedType, $relatedId, $relationshipType, $relationshipKey);
    }

    /**
     * Add a relationship for any model instance
     *
     * @param Model $model
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @param array $metadata
     * @param int $sortOrder
     * @return GeneralMap|null
     */
    public static function addRelatedModel(Model $model, Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null, array $metadata = [], int $sortOrder = 0): ?GeneralMap
    {
        if (!method_exists($model, 'generalMaps')) {
            return null;
        }

        return $model->addRelatedModel($relatedModel, $relationshipType, $relationshipKey, $metadata, $sortOrder);
    }

    /**
     * Remove a relationship for any model instance
     *
     * @param Model $model
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return bool
     */
    public static function removeRelatedModel(Model $model, Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null): bool
    {
        if (!method_exists($model, 'generalMaps')) {
            return false;
        }

        return $model->removeRelatedModel($relatedModel, $relationshipType, $relationshipKey);
    }

    /**
     * Check if a relationship exists for any model instance
     *
     * @param Model $model
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return bool
     */
    public static function hasRelatedModel(Model $model, Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null): bool
    {
        if (!method_exists($model, 'generalMaps')) {
            return false;
        }

        return $model->hasRelatedModel($relatedModel, $relationshipType, $relationshipKey);
    }

    /**
     * Get mappable models for any model instance
     *
     * @param Model $model
     * @param string $mappableType
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return Collection
     */
    public static function getMappableModels(Model $model, string $mappableType, string $relationshipType = 'general', ?string $relationshipKey = null): Collection
    {
        if (!method_exists($model, 'generalMaps')) {
            return new Collection([]);
        }

        return $model->getMappableModels($mappableType, $relationshipType, $relationshipKey);
    }

    /**
     * Get relationship metadata for any model instance
     *
     * @param Model $model
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return array
     */
    public static function getRelationshipMetadata(Model $model, Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null): array
    {
        if (!method_exists($model, 'generalMaps')) {
            return [];
        }

        return $model->getRelationshipMetadata($relatedModel, $relationshipType, $relationshipKey);
    }

    /**
     * Set relationship metadata for any model instance
     *
     * @param Model $model
     * @param Model $relatedModel
     * @param array $metadata
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return GeneralMap|null
     */
    public static function setRelationshipMetadata(Model $model, Model $relatedModel, array $metadata, string $relationshipType = 'general', ?string $relationshipKey = null): ?GeneralMap
    {
        if (!method_exists($model, 'generalMaps')) {
            return null;
        }

        return $model->setRelationshipMetadata($relatedModel, $metadata, $relationshipType, $relationshipKey);
    }

    /**
     * Toggle relationship for any model instance
     *
     * @param Model $model
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return bool
     */
    public static function toggleRelationship(Model $model, Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null): bool
    {
        if (!method_exists($model, 'generalMaps')) {
            return false;
        }

        return $model->toggleRelationship($relatedModel, $relationshipType, $relationshipKey);
    }

    /**
     * Get all relationship types for any model instance
     *
     * @param Model $model
     * @return SupportCollection
     */
    public static function getRelationshipTypes(Model $model): SupportCollection
    {
        if (!method_exists($model, 'generalMaps')) {
            return new SupportCollection([]);
        }

        return $model->getRelationshipTypes();
    }

    /**
     * Get all relationship keys for any model instance
     *
     * @param Model $model
     * @param string $relationshipType
     * @return SupportCollection
     */
    public static function getRelationshipKeys(Model $model, string $relationshipType): SupportCollection
    {
        if (!method_exists($model, 'generalMaps')) {
            return new SupportCollection([]);
        }

        return $model->getRelationshipKeys($relationshipType);
    }

    /**
     * Find models by relationship
     *
     * @param string $modelClass
     * @param string $relatedType
     * @param int $relatedId
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return Collection
     */
        public static function findByRelationship(string $modelClass, string $relatedType, int $relatedId, string $relationshipType = 'general', ?string $relationshipKey = null): Collection
    {
        $model = new $modelClass;

        if (!method_exists($model, 'generalMaps')) {
            return new Collection([]);
        }

        $query = $modelClass::whereHas('generalMaps', function ($query) use ($relatedType, $relatedId, $relationshipType, $relationshipKey) {
            $query->where('related_type', $relatedType)
                ->where('related_id', $relatedId)
                ->where('relationship_type', $relationshipType)
                ->where('is_active', true);

            if ($relationshipKey) {
                $query->where('relationship_key', $relationshipKey);
            }
        });

        return $query->get();
    }

    /**
     * Find models that have relationships with a specific model
     *
     * @param string $modelClass
     * @param string $mappableType
     * @param int $mappableId
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return Collection
     */
    public static function findByMappable(string $modelClass, string $mappableType, int $mappableId, string $relationshipType = 'general', ?string $relationshipKey = null): Collection
    {
        $query = GeneralMap::where('mappable_type', $modelClass)
            ->where('related_type', $mappableType)
            ->where('related_id', $mappableId)
            ->where('relationship_type', $relationshipType)
            ->where('is_active', true);

        if ($relationshipKey) {
            $query->where('relationship_key', $relationshipKey);
        }

        return $query->ordered()->get()->map(function ($map) {
            return $map->mappable;
        })->filter();
    }
}

