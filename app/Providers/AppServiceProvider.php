<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('viewApiDocs', fn() => true);

        Scramble::routes([
            'docs' => true,    // default: false in production
        ]);

        Gate::before(function ($user, string $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        Scramble::configure()
            ->withDocumentTransformers(function (OpenApi $openApi) {
                // Tell Scramble that all endpoints use Bearer JWT auth
                $openApi->secure(
                    SecurityScheme::http('bearer', 'JWT')
                );
            });
    }
}
