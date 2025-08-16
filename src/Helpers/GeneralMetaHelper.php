<?php

namespace Carlxaeron\General\Helpers;

use Carlxaeron\General\Models\GeneralMeta;
use Illuminate\Database\Eloquent\Model;

/**
 * GeneralMetaHelper
 * 
 * Provides global helper functions for working with GeneralMeta
 */
class GeneralMetaHelper
{
    /**
     * Get meta value for any model instance
     *
     * @param Model $model
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getMeta(Model $model, string $key, $default = null)
    {
        if (!method_exists($model, 'generalMeta')) {
            return $default;
        }

        $meta = $model->generalMeta()->where('key', $key)->first();
        return $meta ? $meta->value : $default;
    }

    /**
     * Set meta value for any model instance
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @return GeneralMeta|null
     */
    public static function setMeta(Model $model, string $key, $value, string $type = 'string'): ?GeneralMeta
    {
        if (!method_exists($model, 'generalMeta')) {
            return null;
        }

        return $model->generalMeta()->updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type
            ]
        );
    }

    /**
     * Delete meta value for any model instance
     *
     * @param Model $model
     * @param string $key
     * @return bool
     */
    public static function deleteMeta(Model $model, string $key): bool
    {
        if (!method_exists($model, 'generalMeta')) {
            return false;
        }

        return $model->generalMeta()->where('key', $key)->delete();
    }

    /**
     * Check if model has meta key
     *
     * @param Model $model
     * @param string $key
     * @return bool
     */
    public static function hasMeta(Model $model, string $key): bool
    {
        if (!method_exists($model, 'generalMeta')) {
            return false;
        }

        return $model->generalMeta()->where('key', $key)->exists();
    }

    /**
     * Get all meta for a model as array
     *
     * @param Model $model
     * @return array
     */
    public static function getAllMeta(Model $model): array
    {
        if (!method_exists($model, 'generalMeta')) {
            return [];
        }

        return $model->generalMeta->pluck('value', 'key')->toArray();
    }

    /**
     * Search models by meta key and value
     *
     * @param string $modelClass
     * @param string $key
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function findByMeta(string $modelClass, string $key, $value = null)
    {
        $model = new $modelClass;
        
        if (!method_exists($model, 'generalMeta')) {
            return collect([]);
        }

        $query = $modelClass::whereHas('generalMeta', function ($query) use ($key, $value) {
            $query->where('key', $key);
            if ($value !== null) {
                $query->where('value', $value);
            }
        });

        return $query->get();
    }
}

