<?php

/**
 * Dynamic navigations for Laravel 5.1
 *
 * @license MIT
 * @package SpotOnLive\Assertions
 */

namespace SpotOnLive\Navigation\Providers\Helpers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use SpotOnLive\Navigation\Helpers\NavigationHelper;
use SpotOnLive\Navigation\Services\NavigationService;

class NavigationHelperProvider extends ServiceProvider
{
    /**
     * Register navigation helper
     */
    public function register()
    {
        $this->app->bind(NavigationHelper::class, function (Application $application) {
            /** @var \SpotOnLive\Navigation\Services\NavigationServiceInterface $navigationService */
            $navigationService = $application->make(NavigationService::class);

            return new NavigationHelper($navigationService);
        });
    }
}
