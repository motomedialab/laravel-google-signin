<?php

namespace Motomedialab\GoogleSignin;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\SocialiteManager;
use Motomedialab\GoogleSignin\Contracts\AuthenticatesUser;
use Motomedialab\GoogleSignin\Contracts\DeniesAccess;
use Motomedialab\GoogleSignin\Providers\GoogleSigninProvider;

class GoogleSigninServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureAssets();
        $this->configureBindings();
        $this->configureSocialite();
        $this->configureThrottling();
    }

    private function configureAssets(): void
    {
        $baseDir = __DIR__ . '/../';

        $this->mergeConfigFrom($baseDir . 'config/google-signin.php', 'google-signin');

        $this->loadRoutesFrom($baseDir . 'routes/web.php');

        $this->loadMigrationsFrom($baseDir . 'database/migrations');

        $this->loadViewsFrom($baseDir . 'resources/views', 'google-signin');
        View::addNamespace('google-signin', $baseDir . 'resources/views');

        $this->addPublishGroup('views-google-signin', [
            $baseDir . 'resources/views' => $this->app->resourcePath('views/vendor/google-signin'),
        ]);

        $this->addPublishGroup('config-google-signin', [
            $baseDir . 'config/google-signin.php' => $this->app->configPath('google-signin.php'),
        ]);

        $this->publishes([
            $baseDir . 'config/google-signin.php' => $this->app->configPath('google-signin.php'),
            $baseDir . 'database/migrations' => $this->app->databasePath('migrations'),
            $baseDir . 'resources/views' => $this->app->resourcePath('views/vendor/google-signin'),
        ], 'google-signin');
    }

    private function configureBindings(): void
    {
        $this->app->bind(AuthenticatesUser::class, config('google-signin.actions.authenticate'));
        $this->app->bind(DeniesAccess::class, config('google-signin.actions.deny'));
    }

    private function configureSocialite(): void
    {
        /** @var SocialiteManager $socialite */
        $socialite = $this->app->make(Factory::class);

        $socialite->extend(
            'google-signin',
            fn () => $socialite
                ->buildProvider(config('google-signin.provider', GoogleSigninProvider::class), [
                    ...Arr::only(config('google-signin'), ['client_id', 'client_secret']),
                    'redirect' => route('google-signin.store'),
                ])
        );
    }

    private function configureThrottling(): void
    {
        RateLimiter::for('google-signin', fn () => Limit::perMinute(5));
    }
}
