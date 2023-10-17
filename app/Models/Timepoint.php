<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timepoint extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    public static $model_display_name = 'Timepoint';

    public static $model_key_display_name = 'description';

    protected $fillable = [
        'description',
        'offset'
    ];

    protected $appends = [
        'is_base_timepoint'
    ];

    /**
     * Attribute determining whether this timepoint is the "base".
     */
    protected function isBaseTimepoint(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['offset'] === 0
        );
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('ordered', function (Builder $builder) {
            $builder->orderBy('offset', 'asc');
        });
    }

    /**
     * Resolve this model to its view and data properties.
     */
    public static function resolve()
    {
        return [
            'view' => 'Timepoint/Edit',
            'data' => 'timepoint'
        ];
    }
}
