<?php

namespace Innocode\WPThemeModule\Interfaces;

/**
 * Interface ThemeInitializationInterface
 * @package Innocode\WPThemeModule\Interfaces
 */
interface ThemeInitializationInterface
{
    public function get_image_sizes() : array;

    public function get_nav_menus_locations() : array;

    public function enqueue_styles();

    public function enqueue_scripts();
}
