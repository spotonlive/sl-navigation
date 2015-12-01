<?php

namespace SpotOnLive\Navigation\Navigation;

interface PageInterface
{
    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return boolean
     */
    public function isActive();
}
