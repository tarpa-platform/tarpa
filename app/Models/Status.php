<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    public static $model_display_name = 'Status';

    public static $model_key_display_name = 'description';


    protected $fillable = [
        'description',
        'is_active',
        'is_default'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean'
    ];

    /**
     * Resolve this model to its view and data properties.
     */
    public static function resolve()
    {
        return [
            'view' => 'Status/Edit',
            'data' => 'status'
        ];
    }

}
