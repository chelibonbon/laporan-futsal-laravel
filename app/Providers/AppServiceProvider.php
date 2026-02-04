<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\WebSetting;

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
            View::composer('*', function ($view) {
                $pengaturan = (object) [
                    'judul' => WebSetting::getValue('app_name', config('app.name')),
                    'logo' => WebSetting::getValue('app_logo'),
                    'deskripsi' => WebSetting::getValue('app_description'),
                    'email' => WebSetting::getValue('app_email'),
                    'telepon' => WebSetting::getValue('app_phone'),
                    'alamat' => WebSetting::getValue('app_address'),
                    'facebook' => WebSetting::getValue('social_facebook'),
                    'instagram' => WebSetting::getValue('social_instagram'),
                    'twitter' => WebSetting::getValue('social_twitter'),
                ];
                
                $view->with('pengaturan', $pengaturan);
            });
        } catch (\Exception $e) {
            // Handle case where database or table doesn't exist yet (e.g. during migration)
        }
    }
}
