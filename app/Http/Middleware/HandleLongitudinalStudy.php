<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Settings\GeneralSettings;
use Symfony\Component\HttpFoundation\Response;

class HandleLongitudinalStudy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!app(GeneralSettings::class)->longitudinal) {
            return redirect('dashboard')->with('flash.error', [
                'title' => 'Longitudinal Study Not Set Up',
                'message' => 'This is not a longitudinal study.  Administrators can turn on this feature in settings.'
            ]);
        }

        return $next($request);
    }
}
