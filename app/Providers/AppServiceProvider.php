<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
<<<<<<< HEAD
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
=======
use Illuminate\Support\Facades\Gate;
>>>>>>> feature/translations

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
<<<<<<< HEAD
        if ($this->app->environment('stage')) {
            URL::forceScheme('https');
        }
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Scramble::configure()
            ->routes(function (Route $route) {
                return Str::startsWith($route->uri, 'api/');
            });

        Gate::define('viewApiDocs', function ($user = null) {
            return true;
        });

        Gate::before(function ($user, string $ability) {
            return $user->hasRole('admin') ? true : null;
        });

=======

        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

>>>>>>> feature/translations
        Scramble::configure()
            ->withDocumentTransformers(function (OpenApi $openApi) {
                // Tell Scramble that all endpoints use Bearer JWT auth
                $openApi->secure(
                    SecurityScheme::http('bearer', 'JWT')
                );
            });
    }
}
