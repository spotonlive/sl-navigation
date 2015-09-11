<?php

namespace SpotOnLive\Navigation\Options;

class PageOptions extends Options implements OptionsInterface
{
    /** @var array */
    protected $defaults = [
        'options' => [
            'label' => 'Forside',
            'escape_html' => true,
            'liClass' => null,
            'ulClass' => null,
        ],

        'attributes' => [],
        'pages' => []
    ];
}
