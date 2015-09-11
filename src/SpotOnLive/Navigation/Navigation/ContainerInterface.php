<?php

namespace SpotOnLive\Navigation\Navigation;

interface ContainerInterface
{
    /**
     * Render menu
     *
     * @param int $depth
     * @return string
     */
    public function render($depth = 0);

    /**
     * Render menu through partial
     *
     * @param string $partial
     * @return string
     */
    public function renderPartial($partial);

    /**
     * @return array|PageInterface[]
     */
    public function getPages();
}