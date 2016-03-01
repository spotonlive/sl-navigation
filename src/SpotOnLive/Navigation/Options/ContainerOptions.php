<?php

namespace SpotOnLive\Navigation\Options;

class ContainerOptions extends Options implements OptionsInterface
{
    /** @var array */
    protected $defaults = [
        'options' => [
            'ul_class' => null,
            'depth' => null,
        ],

        'attributes' => [],

        'pages' => []
    ];
}
