<?php

namespace App\Providers;

use App\Actions\DeleteMember;
use App\Actions\RestoreMember;
use App\Contracts\DeletesMembers;
use App\Contracts\RestoresMembers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DeletesMembers::class, DeleteMember::class);
        $this->app->bind(RestoresMembers::class, RestoreMember::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
