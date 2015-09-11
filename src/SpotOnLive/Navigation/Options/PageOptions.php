<?php

namespace SpotOnLive\Navigation\Options;

class PageOptions extends Options implements OptionsInterface
{
    /** @var array */
    protected $defaults = [
        'label' => '',
        'escape_html' => true,

        'options' => [
            'liClass' => null,
        ],

        'pages' => [

        ]
    ];
}