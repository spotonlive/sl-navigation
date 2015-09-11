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

class NavigationHelperProvider extends ServiceProvider
{
    /**
     * Register assertions
     */
    public function register()
    {
        $this->app->bind('SpotOnLive\Navigation\Helpers\NavigationHelper', function(Application $application) {
            /** @var \SpotOnLive\Navigation\Services\NavigationServiceInterface $navigationService */
            $navigationService = $application->make('SpotOnLive\Navigation\Service\NavigationService');

            return new NavigationHelper($navigationService);
        });
    }
}
