<?php

namespace Carlxaeron\General\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class GeneralMeta extends Model
{
    protected $table;

    protected $fillable = [
        'key',
        'value',
        'type'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('general.tables.general_meta', 'general_meta');
    }

    /**
     * Get the parent metable model.
     */
    public function metable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the value attribute with proper type casting and error handling for JSON decode.
     */
    public function getValueAttribute($value)
    {
        return match ($this->type) {
            'integer' => (int) $value,
            'float' => (float) $value,
            'boolean' => (bool) $value,
            'json', 'array' => $this->safeJsonDecode($value),
            default => $value,
        };
    }

    /**
     * Safely decode a JSON string, returning null on error.
     *
     * @param string|null $value
     * @return mixed|null
     */
    protected function safeJsonDecode($value)
    {
        if ($value === null || $value === '') {
            return null;
        }
        $decoded = json_decode($value, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Optionally, log the error here
            return null;
        }
        return $decoded;
    }

    /**
     * Set the value attribute with proper type casting.
     */
    public function setValueAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['value'] = json_encode($value);
        } else {
            $this->attributes['value'] = $value;
        }
    }
}

