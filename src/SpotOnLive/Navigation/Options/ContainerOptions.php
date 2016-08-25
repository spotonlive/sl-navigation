<?php

namespace SpotOnLive\Navigation\Options;

use SpotOnLive\Navigation\Navigation\Providers\ArrayProvider;

class ContainerOptions extends Options implements OptionsInterface
{
    /** @var array */
    protected $defaults = [
        'provider' => ArrayProvider::class,
        'provider_options' => [],

        'options' => [
            'ul_class' => null,
            'depth' => null,
        ],

        'attributes' => [],

        'pages' => [],
    ];
}
