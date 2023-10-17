<?php
namespace App\Models;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Permission extends SpatiePermission
{
    use HasUuids;
    // You might set a public property like guard_name or connection, or override other Eloquent Model methods/properties
}
