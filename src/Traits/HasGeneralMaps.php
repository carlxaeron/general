<?php

namespace Carlxaeron\General\Traits;

use Carlxaeron\General\Models\GeneralMap;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait HasGeneralMaps
 *
 * Provides functionality for models to have polymorphic relationships with other models
 */
trait HasGeneralMaps
{
    /**
     * Get all relationship maps for the model.
     */
    public function generalMaps(): MorphMany
    {
        return $this->morphMany(GeneralMap::class, 'mappable');
    }

    /**
     * Get all related models of a specific type.
     *
     * @param string $relatedType
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return Collection
     */
    public function getRelatedModels(string $relatedType, string $relationshipType = 'general', ?string $relationshipKey = null): Collection
    {
        $query = $this->generalMaps()
            ->where('related_type', $relatedType)
            ->where('relationship_type', $relationshipType)
            ->where('is_active', true);

        if ($relationshipKey) {
            $query->where('relationship_key', $relationshipKey);
        }

        return $query->ordered()->get()->map(function ($map) {
            return $map->related;
        })->filter();
    }

    /**
     * Get a specific related model.
     *
     * @param string $relatedType
     * @param int $relatedId
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return Model|null
     */
    public function getRelatedModel(string $relatedType, int $relatedId, string $relationshipType = 'general', ?string $relationshipKey = null): ?Model
    {
        $query = $this->generalMaps()
            ->where('related_type', $relatedType)
            ->where('related_id', $relatedId)
            ->where('relationship_type', $relationshipType)
            ->where('is_active', true);

        if ($relationshipKey) {
            $query->where('relationship_key', $relationshipKey);
        }

        $map = $query->first();
        return $map ? $map->related : null;
    }

    /**
     * Create a relationship with another model.
     *
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @param array $metadata
     * @param int $sortOrder
     * @return GeneralMap
     */
    public function addRelatedModel(Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null, array $metadata = [], int $sortOrder = 0): GeneralMap
    {
        return $this->generalMaps()->updateOrCreate(
            [
                'related_type' => get_class($relatedModel),
                'related_id' => $relatedModel->id,
                'relationship_type' => $relationshipType,
                'relationship_key' => $relationshipKey,
            ],
            [
                'metadata' => $metadata,
                'sort_order' => $sortOrder,
                'is_active' => true,
            ]
        );
    }

    /**
     * Remove a relationship with another model.
     *
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return bool
     */
    public function removeRelatedModel(Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null): bool
    {
        $query = $this->generalMaps()
            ->where('related_type', get_class($relatedModel))
            ->where('related_id', $relatedModel->id)
            ->where('relationship_type', $relationshipType);

        if ($relationshipKey) {
            $query->where('relationship_key', $relationshipKey);
        }

        return $query->delete();
    }

    /**
     * Check if a relationship exists with another model.
     *
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return bool
     */
    public function hasRelatedModel(Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null): bool
    {
        $query = $this->generalMaps()
            ->where('related_type', get_class($relatedModel))
            ->where('related_id', $relatedModel->id)
            ->where('relationship_type', $relationshipType)
            ->where('is_active', true);

        if ($relationshipKey) {
            $query->where('relationship_key', $relationshipKey);
        }

        return $query->exists();
    }

    /**
     * Get all models that have a relationship with this model.
     *
     * @param string $mappableType
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return Collection
     */
    public function getMappableModels(string $mappableType, string $relationshipType = 'general', ?string $relationshipKey = null): Collection
    {
        $query = GeneralMap::where('mappable_type', $mappableType)
            ->where('related_type', get_class($this))
            ->where('related_id', $this->id)
            ->where('relationship_type', $relationshipType)
            ->where('is_active', true);

        if ($relationshipKey) {
            $query->where('relationship_key', $relationshipKey);
        }

        return $query->ordered()->get()->map(function ($map) {
            return $map->mappable;
        })->filter();
    }

    /**
     * Get relationship metadata.
     *
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return array
     */
    public function getRelationshipMetadata(Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null): array
    {
        $query = $this->generalMaps()
            ->where('related_type', get_class($relatedModel))
            ->where('related_id', $relatedModel->id)
            ->where('relationship_type', $relationshipType);

        if ($relationshipKey) {
            $query->where('relationship_key', $relationshipKey);
        }

        $map = $query->first();
        return $map ? ($map->metadata ?? []) : [];
    }

    /**
     * Set relationship metadata.
     *
     * @param Model $relatedModel
     * @param array $metadata
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return GeneralMap|null
     */
    public function setRelationshipMetadata(Model $relatedModel, array $metadata, string $relationshipType = 'general', ?string $relationshipKey = null): ?GeneralMap
    {
        $query = $this->generalMaps()
            ->where('related_type', get_class($relatedModel))
            ->where('related_id', $relatedModel->id)
            ->where('relationship_type', $relationshipType);

        if ($relationshipKey) {
            $query->where('relationship_key', $relationshipKey);
        }

        $map = $query->first();
        if ($map) {
            $map->metadata = $metadata;
            $map->save();
            return $map;
        }

        return null;
    }

    /**
     * Toggle relationship active status.
     *
     * @param Model $relatedModel
     * @param string $relationshipType
     * @param string|null $relationshipKey
     * @return bool
     */
    public function toggleRelationship(Model $relatedModel, string $relationshipType = 'general', ?string $relationshipKey = null): bool
    {
        $query = $this->generalMaps()
            ->where('related_type', get_class($relatedModel))
            ->where('related_id', $relatedModel->id)
            ->where('relationship_type', $relationshipType);

        if ($relationshipKey) {
            $query->where('relationship_key', $relationshipKey);
        }

        $map = $query->first();
        if ($map) {
            $map->is_active = !$map->is_active;
            $map->save();
            return $map->is_active;
        }

        return false;
    }

    /**
     * Get all relationship types for this model.
     *
     * @return Collection
     */
    public function getRelationshipTypes(): SupportCollection
    {
        return $this->generalMaps()
            ->select('relationship_type')
            ->distinct()
            ->pluck('relationship_type');
    }

    /**
     * Get all relationship keys for a specific type.
     *
     * @param string $relationshipType
     * @return Collection
     */
    public function getRelationshipKeys(string $relationshipType): SupportCollection
    {
        return $this->generalMaps()
            ->where('relationship_type', $relationshipType)
            ->whereNotNull('relationship_key')
            ->select('relationship_key')
            ->distinct()
            ->pluck('relationship_key');
    }
}
