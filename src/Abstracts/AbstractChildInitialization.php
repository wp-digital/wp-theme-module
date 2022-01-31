<?php

namespace Innocode\WPThemeModule\Abstracts;

/**
 * Class AbstractChildInitialization
 * @package Innocode\WPThemeModule\Abstracts
 */
abstract class AbstractChildInitialization extends AbstractThemeInitialization
{
	/**
	 * Returns text domain from CHILD_TEXT_DOMAIN constant
	 *
	 * @return string
	 */
	protected function _get_text_domain() : string
	{
		return defined( 'CHILD_TEXT_DOMAIN' ) ? CHILD_TEXT_DOMAIN : '';
	}

	/**
	 * Makes it optional
	 *
	 * @return array
	 */
	public function get_image_sizes() : array
	{
		return [];
	}

	/**
	 * Makes it optional
	 *
	 * @return array
	 */
	public function get_nav_menus_locations() : array
	{
		return [];
	}

	/**
	 * Makes it optional
	 *
	 * @return void
	 */
	public function enqueue_styles()
	{

	}

	/**
	 * Makes it optional
	 *
	 * @return void
	 */
	public function enqueue_scripts()
	{

	}
}
