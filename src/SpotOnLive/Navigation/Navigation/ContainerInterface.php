<?php

namespace SpotOnLive\Navigation\Navigation;

interface ContainerInterface
{
    public function render();

    public function renderPartial();

    /** @return array|PageInterface[] */
    public function getPages();
}