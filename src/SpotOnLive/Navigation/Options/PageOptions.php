<?php

namespace SpotOnLive\Navigation\Options;

class PageOptions extends Options implements OptionsInterface
{
    /** @var array */
    protected $defaults = [
        'options' => [
            // Render in menu
            'render' => true,

            // Label
            'label' => '',
            'escape_html' => true,

            // Classes
            'liClass' => null,
            'ulClass' => null,
        ],

        // Attributes
        'attributes' => [],

        // Sub pages
        'pages' => []
    ];
}
