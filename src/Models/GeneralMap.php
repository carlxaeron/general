<?php

namespace Carlxaeron\General\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class GeneralMap extends Model
{
    protected $table;

    protected $fillable = [
        'mappable_type',
        'mappable_id',
        'related_type',
        'related_id',
        'relationship_type',
        'relationship_key',
        'metadata',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('general.tables.general_maps', 'general_maps');
    }

    /**
     * Get the parent mappable model.
     */
    public function mappable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the related model.
     */
    public function related(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope to only include active relationships.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by relationship type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('relationship_type', $type);
    }

    /**
     * Scope to filter by relationship key.
     */
    public function scopeWithKey($query, string $key)
    {
        return $query->where('relationship_key', $key);
    }

    /**
     * Scope to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Get metadata value by key.
     */
    public function getMetadataValue(string $key, $default = null)
    {
        return $this->metadata[$key] ?? $default;
    }

    /**
     * Set metadata value.
     */
    public function setMetadataValue(string $key, $value): void
    {
        $metadata = $this->metadata ?? [];
        $metadata[$key] = $value;
        $this->metadata = $metadata;
        $this->save();
    }

    /**
     * Remove metadata value.
     */
    public function removeMetadataValue(string $key): void
    {
        $metadata = $this->metadata ?? [];
        unset($metadata[$key]);
        $this->metadata = $metadata;
        $this->save();
    }
}
