<?php

namespace Carlxaeron\General\Traits;

use Carlxaeron\General\Models\GeneralMeta;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

/**
 * Trait HasGeneralMeta
 * 
 * Provides functionality for models to have associated general meta data
 */
trait HasGeneralMeta
{
    /**
     * Get all meta data for the model.
     */
    public function generalMeta(): MorphMany
    {
        return $this->morphMany(GeneralMeta::class, 'metable');
    }

    /**
     * Get a meta value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getGeneralMeta(string $key, $default = null)
    {
        $meta = $this->generalMeta()->where('key', $key)->first();
        return $meta ? $meta->value : $default;
    }

    /**
     * Set a meta value.
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @return GeneralMeta
     */
    public function setGeneralMeta(string $key, $value, string $type = 'string'): GeneralMeta
    {
        return $this->generalMeta()->updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type
            ]
        );
    }

    /**
     * Delete a meta value.
     *
     * @param string $key
     * @return bool
     */
    public function deleteGeneralMeta(string $key): bool
    {
        return $this->generalMeta()->where('key', $key)->delete();
    }

    /**
     * Check if a meta key exists.
     *
     * @param string $key
     * @return bool
     */
    public function hasGeneralMeta(string $key): bool
    {
        return $this->generalMeta()->where('key', $key)->exists();
    }

    /**
     * Get all meta data as a collection.
     *
     * @return Collection
     */
    public function getAllGeneralMeta(): Collection
    {
        return $this->generalMeta->pluck('value', 'key');
    }

    /**
     * Set multiple meta values at once.
     *
     * @param array $meta
     * @return void
     */
    public function setMultipleGeneralMeta(array $meta): void
    {
        foreach ($meta as $key => $value) {
            $type = is_array($value) ? 'array' : 'string';
            $this->setGeneralMeta($key, $value, $type);
        }
    }

    /**
     * Delete multiple meta values at once.
     *
     * @param array $keys
     * @return bool
     */
    public function deleteMultipleGeneralMeta(array $keys): bool
    {
        return $this->generalMeta()->whereIn('key', $keys)->delete();
    }
}

