<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

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
    Scramble::configure()
        ->withDocumentTransformers(function (OpenApi $openApi) {
            // Tell Scramble that all endpoints use Bearer JWT auth
            $openApi->secure(
                SecurityScheme::http('bearer', 'JWT')
            );
        });
}
}
