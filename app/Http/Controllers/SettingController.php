<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings\GeneralSettings;
use App\Http\Requests\UpdateSettingsRequest;
use DateTime;
use DateTimeZone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    public function edit(Request $request): Response
    {


        return Inertia::render('Setting/Edit', [ 'settings' => app(GeneralSettings::class), 'timezones' => SettingController::timezone_list() ]);

    }

    public function update(UpdateSettingsRequest $request, GeneralSettings $settings): RedirectResponse
    {

        $validated = $request->validated();

        $settings->study_name = $validated['study_name'];
        $settings->timezone = $validated['timezone'];
        $settings->longitudinal = $validated['longitudinal'];

        $settings->save();

        return redirect()->action([SettingController::class, 'edit']);

    }

    protected function timezone_list() {
        static $timezones = null;

        if ($timezones === null) {
            $timezones = array();
            $offsets = [];
            $now = new DateTime('now', new DateTimeZone('UTC'));

            foreach (DateTimeZone::listIdentifiers() as $timezone) {
                $now->setTimezone(new DateTimeZone($timezone));
                $offsets[] = $offset = $now->getOffset();
                array_push($timezones, ['value' => $timezone, 'display' => '(' . SettingController::format_GMT_offset($offset) . ') ' . SettingController::format_timezone_name($timezone)]);
            }

            array_multisort($offsets, $timezones);
        }

        return $timezones;
    }

    protected function format_GMT_offset($offset) {
        $hours = intval($offset / 3600);
        $minutes = abs(intval($offset % 3600 / 60));
        return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
    }

    protected function format_timezone_name($name) {
        $name = str_replace('/', ', ', $name);
        $name = str_replace('_', ' ', $name);
        $name = str_replace('St ', 'St. ', $name);
        return $name;
    }

}
