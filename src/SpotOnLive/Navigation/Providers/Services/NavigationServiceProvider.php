<?php

/**
 * Dynamic navigations for Laravel 5+
 *
 * @license MIT
 * @package SpotOnLive\Navigation
 */

namespace SpotOnLive\Navigation\Providers\Services;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use SpotOnLive\Navigation\Exceptions\IllegalConfigurationException;
use SpotOnLive\Navigation\Services\NavigationService;

class NavigationServiceProvider extends ServiceProvider
{
    /**
     * Boot
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../../../config/config.php' => config_path('navigation.php'),
        ]);
    }

    /**
     * Register service
     */
    public function register()
    {
        $this->app->bind(NavigationService::class, function () {
            $navigationConfig = config('navigation');

            if (is_null($navigationConfig)) {
                throw new IllegalConfigurationException('Please run \'php artisan vendor:publish\'');
            }

            return new NavigationService($navigationConfig);
        });

        $this->mergeConfig();
    }

    /**
     * Merge config
     */
    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../../../config/config.php',
            'navigation'
        );
    }
}
