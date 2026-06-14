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
        // Auto-check and create/repair storage symlink for Hostinger/cPanel environment
        try {
            $link = public_path('storage');
            $target = storage_path('app/public');
            
            // If it's a broken symlink, delete it first so we can recreate it
            if (is_link($link) && !file_exists($link)) {
                @unlink($link);
            }
            
            // Create symlink if it does not exist
            if (!file_exists($link)) {
                @symlink($target, $link);
            }
        } catch (\Exception $e) {
            // Silence any filesystem permission errors during local migrations or cli runs
        }

        try {
            $settings = Setting::all()->pluck('value', 'key');
            View::share('settings', $settings);
        } catch (\Exception $e) {
            // Handle case where table might not exist yet (e.g. during migration)
        }
    }
}
