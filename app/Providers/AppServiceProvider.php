<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Setting;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            $settings = Setting::all()->pluck('value', 'key');
            View::share('settings', $settings);
        } catch (\Exception $e) {
            // Handle case where table might not exist yet (e.g. during migration)
        }
    }
}
