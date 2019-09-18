<?php

namespace Innocode\WPThemeModule\Interfaces;

/**
 * Interface ThemeInitializationInterface
 * @package Innocode\WPThemeModule\Interfaces
 */
interface ThemeInitializationInterface
{
	/**
	 * Returns image sizes
	 *
	 * @return array
	 */
    public function get_image_sizes() : array;

	/**
	 * Returns navigation menus locations
	 *
	 * @return array
	 */
    public function get_nav_menus_locations() : array;

	/**
	 * Enqueues styles
	 */
    public function enqueue_styles();

	/**
	 * Enqueues scripts
	 */
    public function enqueue_scripts();
}
