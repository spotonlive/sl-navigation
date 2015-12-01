<?php

namespace SpotOnLive\Navigation\Options;

class ContainerOptions extends Options implements OptionsInterface
{
    /** @var array */
    protected $defaults = [
        'options' => [
            'ulClass' => null,
            'depth' => null,
        ],

        'attributes' => [],

        'pages' => []
    ];
}
