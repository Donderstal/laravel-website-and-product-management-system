<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'admin.layouts.sidebar',
            'App\Http\Composers\AdminNavigationComposer'
        );
        view()->composer(
            'admin.layouts.breadcrumb',
            'App\Http\Composers\AdminBreadcrumbComposer'
        );
    }
}
