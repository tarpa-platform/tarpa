<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class EventSettings extends Settings
{

    public array $statuses;

    public string $default;

    public string $completed;

    public static function group(): string
    {
        return 'event';
    }
}
