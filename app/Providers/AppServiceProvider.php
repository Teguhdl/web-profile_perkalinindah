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
            $target = env('PUBLIC_STORAGE_PATH', storage_path('app/public'));
            
            // If it's a symlink, check if it points to the correct target or is broken
            if (is_link($link)) {
                $currentTarget = function_exists('readlink') ? @readlink($link) : null;
                if ($currentTarget !== $target || !file_exists($link)) {
                    if (function_exists('unlink')) {
                        @unlink($link);
                    }
                }
            }
            
            // Create symlink if it does not exist and symlink function is available
            if (!file_exists($link) && function_exists('symlink')) {
                @symlink($target, $link);
            }
        } catch (\Throwable $e) {
            // Silence any filesystem permission errors or disabled functions during local migrations or cli runs
        }

        try {
            $settings = Setting::all()->pluck('value', 'key');
            View::share('settings', $settings);
        } catch (\Exception $e) {
            // Handle case where table might not exist yet (e.g. during migration)
        }
    }
}
