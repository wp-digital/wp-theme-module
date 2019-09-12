<?php

namespace Innocode\WPThemeModule\Interfaces;

/**
 * Interface InitializationInterface
 * @package Innocode\WPThemeModule\Interfaces
 */
interface InitializationInterface
{
    public function get_post_types() : array;

    public function get_taxonomies() : array;
}
