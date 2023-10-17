<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Archive extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'archive';

    protected $appends = [
        'model_name',
        'model_key'
    ];

    /**
     * Resolve this model to its view and data properties.
     */
    protected function modelName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => app($attributes['archivable_type'])->model_display_name()
        );
    }

    /**
     * Resolve this model to its view and data properties.
     */
    protected function modelKey(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => app($attributes['archivable_type'])->model_key_display_name()
        );
    }

    public function archivable(): MorphTo
    {
        return $this->morphTo()->withTrashed();
    }
}
