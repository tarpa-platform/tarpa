<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class SignupToken extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
		'signup_role'
	];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($token) {

            $token->{'token'} = (string) Str::random(4) . "-" . Str::random(4) . "-" . Str::random(4);

        });
    }

    public function registrant()
	{
		return $this->morphTo();
	}
}
