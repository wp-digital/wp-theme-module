<?php

namespace Innocode\WPThemeModule;

/**
 * Interface ThemeInitializationInterface
 * @package Innocode\WPThemeModule
 */
interface ThemeInitializationInterface
{
    public static function get_image_sizes() : array;

    public static function get_nav_menus_locations() : array;

    public static function enqueue_styles();

    public static function enqueue_scripts();
}
