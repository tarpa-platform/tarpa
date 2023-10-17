<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{

    public string $study_name;

    public string $timezone;

    public bool $longitudinal;

    public static function group(): string
    {
        return 'general';
    }
}
